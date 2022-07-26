from flask import Flask, request, abort

from linebot import (
    LineBotApi, WebhookHandler
)
from linebot.exceptions import (
    InvalidSignatureError
)
from linebot.models import *

from bs4 import BeautifulSoup
import requests
from datetime import date
import json

app = Flask(__name__)

# Channel Access Token
line_bot_api = LineBotApi('gSyTrvMX7NTZW+eMdfKPmFD8QJ0TLKVLxFJi32YaqZ4Z2jxY1Vsz2uNmf9FjmKia2SNaiz+eqwP1TEV+TqDNQClSN5SkYaB8Rde5o9XfdM2Xe27C2HVzk6XCYOpqmPRMYGmloO4XyqZrpCxJZyr2HQdB04t89/1O/w1cDnyilFU=')
# Channel Secret
handler = WebhookHandler('0ca4cded60b2db96cdf3aa9a6308be99')

# 監聽所有來自 /callback 的 Post Request
@app.route("/callback", methods=['POST'])
def callback():
    # get X-Line-Signature header value
    signature = request.headers['X-Line-Signature']
    # get request body as text
    body = request.get_data(as_text=True)
    app.logger.info("Request body: " + body)
    # handle webhook body
    try:
        handler.handle(body, signature)
    except InvalidSignatureError:
        abort(400)
    return 'OK'

def getHtmlBody(url, charset='big5'):
    response = requests.get(url)
    response.encoding = charset
    soup = BeautifulSoup(response.text, "html.parser")
    return soup

def getStockNo(str):
    
    try:
        if int(str):
            soup = getHtmlBody('https://tw.stock.yahoo.com/quote/' + str + '.TW', 'utf-8')
            result = soup.find('div', class_='D(f) Ai(c) Mb(6px)')

            name = ''
            no = ''
            index = 0
            for item in result:
                # print(item.getText())
                if index == 0:
                    name = item.getText()
                elif index == 1:
                    no = item.getText()
                    break
                index = index+1

            fullText = name + '(' + no + '.TW)'
            return [fullText, name, no]

    except:
        soup = getHtmlBody('https://www.google.com/search?q=' + str + '&rlz=1C1GCEU_zh-TWTW947TW947')

        today = date.today()
        result = soup.findAll('h3')

        for item in result:
            print(item.getText())
            if item.getText().index('.TW') > -1:
                fullText = item.getText().split(' ')[0].strip()
                no = fullText[-8:-4].strip()
                name = fullText.replace(no,'').replace('(.TW)','')
                return [fullText, name, no] 
            else:
                continue   
    
    return 'None'

def getPrice(no):
    soup = getHtmlBody('https://tw.stock.yahoo.com/quote/' + no + '.TW')

    today = date.today()
    result = soup.find('span',class_= 'Fz(32px) Fw(b) Lh(1) Mend(16px) D(f) Ai(c) C($c-trend-up)')
    
    if result is not None:
        return result.getText()

    result = soup.find('span',class_= 'Fz(32px) Fw(b) Lh(1) Mend(16px) D(f) Ai(c) C($c-trend-down)')
    return result.getText()

#取得近四季EPS
def getNearEPS(no):
    soup = getHtmlBody('https://histock.tw/stock/' + no + '/%E6%AF%8F%E8%82%A1%E7%9B%88%E9%A4%98')

    today = date.today()
    result = soup.find('table',class_= 'tb-stock text-center tbBasic').select('tr')[1:5]

    QEPS = []
    Q = ''
    index = 0
    row = 0
    col = 0
    for item in result:
        for it in item.select('td'):
            fieldVal = it.getText()
            if fieldVal != '-':
                QEPS.append(0)
                if len(QEPS) % 4 == 1:
                    Q = '~Q1'
                elif len(QEPS) % 4 == 2:
                    Q = '~Q2'
                elif len(QEPS) % 4 == 3:
                    Q = '~Q3'
                elif len(QEPS) % 4 == 0:
                    Q = '~Q4'
        
    for item in result:
        for it in item.select('td'):
            fieldVal = it.getText()
            # print(fieldVal)

            if col > 8:
                col = 0
                index = index + 1

            if fieldVal != '-':
                QEPS[index+col*4] = float(fieldVal)
                
            col = col + 1

    QEPS.reverse()
    return [Q, round(sum(QEPS[0:4]),2)]

def PE240avg(no):
    soup = getHtmlBody('https://histock.tw/stock/' + no + '/%E6%9C%AC%E7%9B%8A%E6%AF%94')

    today = date.today()
    result = soup.find('table',class_= 'tb-stock tb-outline tbBasic').select('tr')[:]

    PE = []
    index = 0
    row = 0
    col = 0
    for item in result:
        for it in item.select('td'):
            fieldVal = it.getText()
            if fieldVal.find('/') == -1:
                PE.append(0)
        
        
    for item in result:
        for it in item.select('td'):
            fieldVal = it.getText()
            
            if fieldVal.find('/') == -1:
                if col > 4:
                    col = 0
                    index = index + 1
                
                PE[index+col*13] = float(fieldVal)
                col = col + 1
    
    return [round(sum(PE[0:12])/12, 2), max(PE), min(PE)]

def nowPB(no):
    soup = getHtmlBody('https://histock.tw/stock/' + no + '/%E6%AF%8F%E8%82%A1%E6%B7%A8%E5%80%BC')

    today = date.today()
    result = soup.find('table',class_= 'tb-stock text-center tbBasic').select('tr')[:]

    PB = []
    Q = ''
    index = 0
    row = 0
    col = 0
    for item in result:
        for it in item.select('td'):
            fieldVal = it.getText()
            if fieldVal != '-':
                PB.append(0)
                if len(PB) % 4 == 1:
                    Q = 'Q1'
                elif len(PB) % 4 == 2:
                    Q = 'Q2'
                elif len(PB) % 4 == 3:
                    Q = 'Q3'
                elif len(PB) % 4 == 0:
                    Q = 'Q4'

    for item in result:
        for it in item.select('td'):
            fieldVal = it.getText()
            # print(fieldVal)

            if col > 8:
                col = 0
                index = index + 1

            if fieldVal != '-':
                PB[index+col*4] = float(fieldVal)
                
            col = col + 1

    PB.reverse()
    return [Q, PB[0]]

def PB240avg(no):
    soup = getHtmlBody('https://histock.tw/stock/' + no + '/%E8%82%A1%E5%83%B9%E6%B7%A8%E5%80%BC%E6%AF%94')

    today = date.today()
    result = soup.find('table',class_= 'tb-stock tb-outline tbBasic').select('tr')[:]

    PB = []
    index = 0
    row = 0
    col = 0
    for item in result:
        for it in item.select('td'):
            fieldVal = it.getText()
            if fieldVal.find('/') == -1:
                PB.append(0)

    for item in result:
        for it in item.select('td'):
            fieldVal = it.getText()
            
            if fieldVal.find('/') == -1:
                if col > 4:
                    col = 0
                    index = index + 1
                
                PB[index+col*13] = float(fieldVal)
                col = col + 1

    return [round(sum(PB[0:12])/12, 2), max(PB), min(PB)]

#取得營收
def getIncome(no):
    soup = getHtmlBody('https://histock.tw/stock/' + no + '/%E6%AF%8F%E6%9C%88%E7%87%9F%E6%94%B6')
    
    today = date.today()
    result = soup.find('table',class_= 'tb-stock text-center tbBasic').select('tr')[2:2+int(today.strftime('%m'))+1]

    Income = []
    loopEnd = False
    for item in result:
        if loopEnd:
            break
        for it in item.select('td'):
            fieldVal = it.getText()
            if len(fieldVal.split('/')) > 1:
                if int(fieldVal.split('/')[0]) == int(today.year)-1 and fieldVal.split('/')[1] == '12':
                    #取得第一行月份
                    latestDate = soup.find('table',class_= 'tb-stock text-center tbBasic').select('tr')[2:3][0].select('td')[0].getText()
                    latestDate = latestDate.replace('/','')[2:]
                    Income.append(latestDate)
                    #取得第一行的累積YoY
                    currentYoY = soup.find('table',class_= 'tb-stock text-center tbBasic').select('tr')[2:3][0].select('td')[7].getText()
                    Income.append(currentYoY)
                    #取得去年底之營收總和
                    Income.append(fieldVal[2:].replace('/',''))
                    total_income = int(item.select('td')[5].getText().replace(',','')) / 100000
                    Income.append(round(total_income, 2))
                    loopEnd = True
    
    return Income

def addMsgTitle(row1, row2):
    return {
        "type": "box", 
        "layout": "baseline",
        "contents": [
            { "type": "text", "text": str(row1), "size": "md", "weight": "bold" },
            { "type": "text", "text": str(row2), "weight": "bold" }
        ]
    }

def addMsgDataRow(row1, row2, margin='none', size1='sm', size2='sm', color1='#aaaaaa', color2='#666666'):
    return {
                "type": "box",
                "layout": "baseline",
                "contents": [
                    { "type": "text", "text": row1, "color": color1, "size": size1 },
                    { "type": "text", "text": row2, "size": size2, "color": color2 }
                ],
                "margin": margin
    }

def addSeparator():
    return { "type": "separator" }

# 處理訊息
@handler.add(MessageEvent, message=TextMessage)
def handle_message(event):
    message = TextSendMessage(text=event.message.text)

    info = getStockNo(event.message.text.split(' ')[0])
    if type(info) == str and info == 'None':
        line_bot_api.reply_message(event.reply_token, '指令輸入錯誤!!')

    print(info)
    price = getPrice(info[2])
    QEPS = getNearEPS(info[2])
    PEs = PE240avg(info[2])
    PE = PEs[0]
    MaxPE = PEs[1]
    MinPE = PEs[2]
    PB = nowPB(info[2])
    PBs = PB240avg(info[2])
    PB_240 = PBs[0]
    MaxPB = PBs[1]
    MinPB = PBs[2]
    Income = getIncome(info[2])


    msgDataRow = []
    msgDataRow.append(addMsgTitle(info[0],'股價' + price))
    msgDataRow.append(addSeparator())

    if len(event.message.text.split(' ')) > 1:
        if float(event.message.text.split(' ')[1]):
            estimateEPS = float(event.message.text.split(' ')[1])
            msgDataRow.append(addMsgDataRow('預估EPS', str(estimateEPS)))
    else:
        msgDataRow.append(addMsgDataRow('近四季EPS(' + str(QEPS[0]) + ')', str(QEPS[1])))

    msgDataRow.append(addSeparator())
    msgDataRow.append(addMsgDataRow('滾動PE(240avg)', str(PE),'lg'))
    msgDataRow.append(addMsgDataRow('5年Max: ' + str(MaxPE), '5年Min: ' + str(MinPE), 'none','sm','sm','#FF0000','#00EC00'))

    if len(event.message.text.split(' ')) > 1:
        estimateEPS = float(event.message.text.split(' ')[1])
        msgDataRow.append(addMsgDataRow('特賣價',str(round(estimateEPS * PE * 0.618, 2)),'lg'))
        msgDataRow.append(addMsgDataRow('便宜價',str(round(estimateEPS * PE * 0.8, 2))))
        msgDataRow.append(addMsgDataRow('合理價',str(round(estimateEPS * PE, 2))))
        msgDataRow.append(addMsgDataRow('偏高價',str(round(estimateEPS * PE * 1.2, 2))))
        msgDataRow.append(addMsgDataRow('瘋狂價',str(round(estimateEPS * PE * 1.382, 2))))
    else:
        msgDataRow.append(addMsgDataRow('特賣價',str(round(QEPS[1] * PE * 0.618, 2)),'lg'))
        msgDataRow.append(addMsgDataRow('便宜價',str(round(QEPS[1] * PE * 0.8, 2))))
        msgDataRow.append(addMsgDataRow('合理價',str(round(QEPS[1] * PE, 2))))
        msgDataRow.append(addMsgDataRow('偏高價',str(round(QEPS[1] * PE * 1.2, 2))))
        msgDataRow.append(addMsgDataRow('瘋狂價',str(round(QEPS[1] * PE * 1.382, 2))))

    msgDataRow.append(addSeparator())
    msgDataRow.append(addMsgDataRow('最新淨值(' + str(PB[0]) + ')', str(PB[1]),'lg'))
    msgDataRow.append(addMsgDataRow('滾動PB(240avg)', str(PB_240)))
    msgDataRow.append(addMsgDataRow('5年Max: ' + str(MaxPB), '5年Min: ' + str(MinPB), 'none','sm','sm','#FF0000','#00EC00'))
    msgDataRow.append(addMsgDataRow('合理',str(round(PB[1] * PB_240, 2)),'lg'))
    msgDataRow.append(addMsgDataRow('便宜',str(round(PB[1] * PB_240 * 0.8, 2))))
    msgDataRow.append(addMsgDataRow('特價',str(round(PB[1] * PB_240 * 0.618, 2))))
    msgDataRow.append(addSeparator())
    msgDataRow.append(addMsgDataRow('累計YoY(' + str(Income[0]) + ')',str(Income[1]),'lg'))
    msgDataRow.append(addMsgDataRow('累計YoY(' + str(Income[2]) + ')',str(Income[3]) + '億'))

    message = FlexSendMessage(
        alt_text='已傳送' + info[0] + '基本面分析',
        contents={
            "type": "bubble",
            "body": {
                "type": "box",
                "layout": "vertical",
                "contents": msgDataRow
            }
        }
    )

    line_bot_api.reply_message(event.reply_token, message)

import os
if __name__ == "__main__":
    port = int(os.environ.get('PORT', 5000))
    app.run(host='0.0.0.0', port=port)