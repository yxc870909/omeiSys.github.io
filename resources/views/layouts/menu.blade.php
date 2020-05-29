<div class="panel-group" id="info" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#info" href="#collapseOne" true" aria-controls="collapseOne">
                    個人資料                                    
                </a>                                
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li>{{$userInfo['position']}}</li>
                    <li>{{$userInfo['name']}}</li>
                    <li>{{$userInfo['preside']}}</li>
                    <li>{{$userInfo['group']}}</li>
                    <li style="color:#337ab7">未歸還書籍&nbsp;&nbsp;&nbsp;<a href="/BookBorrow?mpage=1&tab=myrecord"><span class="badge">{{$userInfo['count']}}</span></a></li>
                </ul>
                <div align="right"><a href="/Member">編輯</a></div>
            </div>
        </div>
    </div>
</div>
                
<div class="list-group">

    @foreach($menu as $item)
    
    <a href="{{$item['link']}}" class="list-group-item {{$item['sel']}}">{{$item['word']}}</a>
    @foreach($item['sub'] as $sub)
    <a href="{{$sub['link']}}" class="sub-menu">{{$sub['word']}}</a>
    @endforeach

    @endforeach
</div>