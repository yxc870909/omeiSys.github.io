<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use DB;
use \App\Models\User\Service\UserService as UserService;
use \App\Models\Books\Service\BooksService as BooksService;
use \App\Models\Books\Service\BorrowBooksService as BorrowBooksService;
use \App\Models\Books\Service\tmpBorrowService as tmpBorrowService;
use \App\Models\Books\Service\SubScriptionBooksService as SubScriptionBooksService;
use \App\Models\Books\Service\SubApplicationService as SubApplicationService;
use \App\Models\Books\Service\ReceiveBooksService as ReceiveBooksService;
use \App\Models\Books\Service\RecvApplicationService as RecvApplicationService;
use \App\Models\Temple\Service\TempleService as TempleService;
use \App\Models\Category\Service\CategoryService as CategoryService;
use \App\Support\PageSupport as PageSupport;
use \App\Support\FileSupport as FileSupport;
use \App\Checker\BooksValidator as BooksValidator;
use \App\Support\Menu as Menu;

class BooksController extends Controller
{
    public function doDelPhoto(Request $request)
    {
        echo json_encode("");
        exit();
    }

    public function doUploadPhoto(Request $request)
    {
        $file = $request::file('photo');
        $check = FileSupport::checkFile($file);
        if(!$check['status']){
            echo json_encode(array('ServerNo' => '400','ResultData' => $check['msg']));
            exit();
        }


        //取得原始路徑
        $transverse_pic = $file->getRealPath();
        //tmp路徑
        $path = public_path('tmp');
        //取得前綴
        $postfix = $file->getClientOriginalExtension();
        //重組檔名
        $fileName = date("Ymdhis").'.'.$postfix;
        if(!$file->move($path,$fileName)){
            echo json_encode(array('ServerNo' => '400','ResultData' => '檔案讀取失敗'));
            exit();
        }

        echo json_encode(array('ServerNo' => '200','ResultData' => $fileName));
        exit();
    }

    public function doAddBooks(Request $request)
    {
        $request = $request::all();

        $validator = BooksValidator::AddLibraryBookValidator($request);
        if($validator->fails()) {
            echo json_encode($validator->getMessageBag()->toArray());
            exit();
        }

        try {

            DB::beginTransaction();

            $book = new \App\Models\Books\Entity\Books;
            $book->type = 'library';
            $book->number = BooksService::addBooksNumber('J', 'A', $request['type']);
            $book->cat = $request['type'];
            $book->location = $request['location'];
            $book->title = $request['book_name'];
            $book->img = $request['fileName'];
            $book->author = $request['author'];
            $book->isbn = $request['isbn'];
            $book->lan = $request['lan'];
            $book->pub_year = $request['pub_year'];
            $book->version = $request['version'];
            $book->no = $request['no'];
            $book->price = $request['price'];
            $book->tid = $request['temple'];
            $book->count = $request['count'];
            $book->buy_date = $request['buy_date'];
            $book->is_borrow = $request['is_borrow'];
            $book->save();

            DB::commit();

            //複製後刪除暫存檔
            $root = $_SERVER['DOCUMENT_ROOT'];
            if(file_exists($root.'/tmp/'.$request['fileName'])) {
                copy($root.'/tmp/'.$request['fileName'], $root.'/upload/books/'.$request['fileName']);
                unlink($root.'/tmp/'.$request['fileName']);
            }           
            echo json_encode('success');
            exit();

        }catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function doGetBooksData(Request $request)
    {
        $request = $request::all();

        $data = BooksService::getBooksData('b.id='.$request['id'], 1, 999999);

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function doEditBooks(Request $request)
    {
        $request = $request::all();

        $validator = BooksValidator::EditLibraryBookValidator($request);
        if($validator->fails()) {
            echo json_encode($validator->getMessageBag()->toArray());
            exit();
        }

        $updateData = array();
        $updateData['title'] = $request['book_name'];
        $updateData['img'] = $request['fileName'];
        $updateData['author'] = $request['author'];
        $updateData['isbn'] = $request['isbn'];
        $updateData['lan'] = $request['lan'];
        $updateData['pub_year'] = $request['pub_year'];
        $updateData['version'] = $request['version'];
        $updateData['no'] = $request['no'];
        $updateData['price'] = $request['price'];
        $updateData['tid'] = $request['temple'];
        $updateData['count'] = $request['count'];
        $updateData['buy_date'] = $request['buy_date'];
        $updateData['is_borrow'] = $request['is_borrow']=='on' ? 'true' : 'false';

        try {

            DB::beginTransaction();

            BooksService::update($request['id'], $updateData);

            DB::commit();

            //複製後刪除暫存檔
            $root = $_SERVER['DOCUMENT_ROOT'];
            if(file_exists($root.'/tmp/'.$request['fileName'])) {
                copy($root.'/tmp/'.$request['fileName'], $root.'/upload/books/'.$request['fileName']);
                unlink($root.'/tmp/'.$request['fileName']);
            }   
            echo json_encode('success');
            exit();
        }
        catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function doGetSubscriptionData(Request $request)
    {
        $request = $request::all();

        $data = SubScriptionBooksService::getBooksData('subscription_books.id='.$request['id'], 1, 9999);

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function doGetReceiveData(Request $request)
    {
        $request = $request::all();

        $data = ReceiveBooksService::getBooksData('a.id='.$request['id'], 1, 1);

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function doEditReceive(Request $request)
    {
        $request = $request::all();

        $validator = BooksValidator::EditReceiveBookValidator($request);
        if($validator->fails()) {
            echo json_encode($validator->getMessageBag()->toArray());
            exit();
        }

        $updateData = array();
        $updateData['title'] = $request['book_name'];
        $updateData['img'] = $request['fileName'];
        $updateData['author'] = $request['author'];
        $updateData['isbn'] = $request['isbn'];
        $updateData['lan'] = $request['lan'];
        $updateData['pub_year'] = $request['pub_year'];
        $updateData['version'] = $request['version'];
        $updateData['no'] = $request['no'];
        $updateData['price'] = $request['price'];
        $updateData['tid'] = $request['temple'];
        $updateData['count'] = $request['count'];

        try {

            DB::beginTransaction();

            ReceiveBooksService::update($request['id'], $updateData);

            DB::commit();

        //複製後刪除暫存檔
        $root = $_SERVER['DOCUMENT_ROOT'];
        if(file_exists($root.'/tmp/'.$request['fileName'])) {
            copy($root.'/tmp/'.$request['fileName'], $root.'/upload/receive/'.$request['fileName']);
            unlink($root.'/tmp/'.$request['fileName']);
        }   
            echo json_encode('success');
            exit();
        }
        catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function doEditSubscription(Request $request)
    {
        $request = $request::all();

        $validator = BooksValidator::EditSnscriptionBookValidator($request);
        if($validator->fails()) {
            echo json_encode($validator->getMessageBag()->toArray());
            exit();
        }

        $request['public_date'] = str_replace(array('年','月','日'), array('-','-',''), $request['public_date']);
        $updateData = array();
        $updateData['title'] = $request['book_name'];
        $updateData['img'] = $request['fileName'];
        $updateData['author'] = $request['author'];
        $updateData['isbn'] = $request['isbn'];
        $updateData['lan'] = $request['lan'];
        $updateData['pub_year'] = $request['pub_year'];
        $updateData['version'] = $request['version'];
        $updateData['no'] = $request['no'];
        $updateData['price'] = $request['price'];
        $updateData['tid'] = $request['temple'];
        $updateData['count'] = $request['count'];
        $updateData['public_date'] = $request['public_date'];
        $updateData['status'] = ($request['count']>0 && $request['public_date']!='0000-00-00') ? 'process' : 'open';


        try {

            DB::beginTransaction();

            SubScriptionBooksService::update($request['id'], $updateData);

            DB::commit();

            echo json_encode('success');
            exit();
        }
        catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function doGetSubscriptionType(Request $request)
    {
        $request = $request::all();

        $data = \App\Models\Entity\Category::where('attribute', '=', $request['type'])->get();
        echo json_encode($data);
        exit();

        // \App\Models\Entity\Books::doGetSubscriptionType($request::all());
    }

    public function doAddSubscriptionBooks(Request $request)
    {
        $request = $request::all();

        $validator = BooksValidator::AddSnscriptionBookValidator($request);
        if($validator->fails()) {
            echo json_encode($validator->getMessageBag()->toArray());
            exit();
        }

        try {
            DB::beginTransaction();

            $sub = new \App\Models\Books\Entity\SubscriptionBooks;
            $sub->cat = $request['type2'];
            $sub->title = $request['book_name'];
            $sub->img = $request['fileName'];
            $sub->author = $request['author'];
            $sub->isbn = $request['isbn'];
            $sub->lan = $request['lan'];
            $sub->pub_year = $request['pub_year'];
            $sub->version = $request['version'];
            $sub->no = $request['no'];
            $sub->price = $request['price'];
            $sub->tid = $request['temple'];
            $sub->count = $request['SubscriptionCount'];

            $rcev = new \App\Models\Books\Entity\ReceiveBooks;
            $rcev->cat = $request['type2'];
            $rcev->title = $request['book_name'];
            $rcev->img = $request['fileName'];
            $rcev->author = $request['author'];
            $rcev->isbn = $request['isbn'];
            $rcev->lan = $request['lan'];
            $rcev->pub_year = $request['pub_year'];
            $rcev->version = $request['version'];
            $rcev->no = $request['no'];
            $rcev->price = $request['price'];
            $rcev->count = $request['ReceiveCount'];

            $book = new \App\Models\Books\Entity\Books;
            $book->type = 'receive';
            $book->cat = $request['type2'];
            $book->title = $request['book_name'];
            $book->img = $request['fileName'];
            $book->author = $request['author'];
            $book->isbn = $request['isbn'];
            $book->lan = $request['lan'];
            $book->pub_year = $request['pub_year'];
            $book->version = $request['version'];
            $book->no = $request['no'];
            $book->price = $request['price'];
            $book->count = $request['LibraryCount'];
            $book->is_borrow = 'false';

            $sub->save();
            $rcev->save();
            $book->save();

            DB::commit();

            //複製後刪除暫存檔
            $root = $_SERVER['DOCUMENT_ROOT'];
            if(file_exists($root.'/tmp/'.$request['fileName'])) {
                copy($root.'/tmp/'.$request['fileName'], $root.'/upload/books/'.$request['fileName']);
                copy($root.'/tmp/'.$request['fileName'], $root.'/upload/subscription/'.$request['fileName']);
                copy($root.'/tmp/'.$request['fileName'], $root.'/upload/receive/'.$request['fileName']);
                unlink($root.'/tmp/'.$request['fileName']);
            }
            echo json_encode('success');
            exit();
        }
        catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }  

        echo json_encode($request);
        exit();
    }

    public function doGetBorrowRecordData(Request $request)
    {
        $request = $request::all();

        $data = BorrowBooksService::getRecordData('a.id='.$request['id'], 1, 9999);

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function doGetSubscriptionRecordData(Request $request)
    {
        $request = $request::all();

        $data = SubApplicationService::doGetSubscriptionRecordData('sp.id='.$request['id'], 1, 9999);

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function doGetReceiveRecordData(Request $request)
    {
        $request = $request::all();

        $data = RecvApplicationService::getApplicationData('app.id='.$request['id'], 1, 9999);

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }
    
    public function doGetBooksDataFromNumber(Request $request)
    {
        $request = $request::all();

        $data = BooksService::getBooksData('b.number='.$request['number'], 1, 99999);

        if(count($data) >0) {
            $filter = array();
            $filter[] = 'bid='.$request['bid'];
            $filter[] = 'upid='.$request['upid'];
            $filter = implode(' and ', $filter);
            $tmp = tmpBorrowService::getTmpBorrow($filter);

            if(count($tmp) == 0) {
                $updateData = array();
                $updateData['bid'] = $request['bid'];
                $updateData['upid'] = $request['upid'];
                tmpBorrowService::update('1', $updateData);

                $data = tmpBorrowService::getBorrowBooksData('t.upid='.$request['upid'], 1, 9999);

                echo json_encode(array('status'=>'success', 'data'=>$data));
                exit();
            }
        }
        else {
            if($data[0]['count'] > $tmp[0]['count']) {
                $updateData = array();
                $updateData['bid'] = $data[0]['id'];
                $updateData['upid'] = $request['upid'];
                $updateData['count'] = $tmp[0]['count']+1;
                tmpBorrowService::update();

                $data = tmpBorrowService::getBorrowBooksData('t.upid='.$request['upid'], 1, 9999);

                echo json_encode(array('status'=>'success', 'data'=>$data));
                exit();
            }
            else {
                echo json_encode(array('status'=>'not found'));
                exit();
            }
        }
        // else
        //     echo json_encode(array('status'=>'not found'));
        // exit();
    }

    public function doCountLocationBooks(Request $request)
    {
        $request = $request::all();

        if($request['mode'] == 'scann')
            $request['temple'] = $request['scann_temple'];
        if($request['mode'] == 'key')
            $request['temple'] = $request['key_temple'];

        $data = BooksService::getBooksData('b.tid='.$request['temple'], 1, 9999);

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function doCountLocationRcevBooks(Request $request)
    {
        $request = $request::all();

        $data = ReceiveBooksService::getBooksData('b.tid='.$request['temple'], 1, 9999);

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function doGetSubscriptionCount(Request $request)
    {
        // $data = \App\Models\Entity\SetSubscriptionCount::where('year', '=', $request['year'])
        //                                                ->where('area', '=', $request['area'])
        //                                                ->get();
        // echo json_encode($data);
        // exit();

        // \App\Models\Entity\Books::doGetSubscriptionCount($request::all());
    }

    public function doSaveSubscriptionCount(Request $request)
    {
        // $data = array();
        // foreach($request as $k=>$v) {
        //     if($k!='_token' && $k!='area' && $k!='year') {
        //         if($v > 0) {
        //             DB::beginTransaction();
        //             //類別數量
        //             $del = \App\Models\Entity\SetSubscriptionCount::where('type', '=', $k)
        //                                                           ->where('year', '=', $request['year'])
        //                                                           ->where('area', '=', $request['area'])
        //                                                           ->where('count', '=', $v);
        //             $del->delete();

        //             $setBookCount = new \App\Models\Entity\SetSubscriptionCount;
        //             $setBookCount['type'] = $k;
        //             $setBookCount['year'] = $request['year'];
        //             $setBookCount['area'] = $request['area'];
        //             $setBookCount['count'] = $v;
        //             $setBookCount->save();

        //             //實際書籍數量
        //             $res = DB::table('set_subscription_count as sc')
        //                      ->join('subscription_books as sb', 'sc.type', '=', 'sb.cat')
        //                      ->leftJoin('sub_application as sp', 'sb.id', '=', 'sp.sbid')
        //                      ->where('sb.cat', '=', $k)
        //                      ->where('sc.year', '=', $request['year'])
        //                      ->where('sc.area', '=', $request['area'])
        //                      ->select('sp.id', 'sb.id as sbid', 'sc.id as set_id')
        //                      ->get();
        //             if(count($res) > 0) {
        //                 $res = $res[0];
        //                 $del = \App\Models\Entity\SubApplication::where('id', '=', $res->id);
        //                 $del->delete();

        //                 $sub_app = new \App\Models\Entity\SubApplication;
        //                 $sub_app['set_id'] = $res->set_id;
        //                 $sub_app['sbid'] = $res->sbid;
        //                 $sub_app['area'] = $request['area'];
        //                 $sub_app['count'] = $v;
        //                 $sub_app->save();
        //             }

        //             DB::commit();
        //         }
        //         else if($v==0 || $v=='') {
        //             DB::beginTransaction();

        //             $del = \App\Models\Entity\SetSubscriptionCount::where('type', '=', $k)
        //                                                           ->where('year', '=', $request['year'])
        //                                                           ->where('area', '=', $request['area'])
        //                                                           ->where('count', '=', $v);
        //             $del->delete();

        //             DB::commit();
        //         }
        //     }
        // }
        // echo json_encode('success');
        // exit();

        // \App\Models\Entity\Books::doSaveSubscriptionCount($request::all());
    }

    public function doGetSubScriptionBookData(Request $request)
    {
        // $data = DB::table('sub_application as sp')
        //                 ->join('subscription_books as sb', 'sp.sbid', '=', 'sb.id')
        //                 ->join('category as c', 'sb.cat', '=', 'c.value')
        //                 ->leftJoin('temple as t', 'sb.tid', '=', 't.id')
        //                 ->where('sb.id', '=', $request['id'])
        //                 ->select(
        //                     'sp.status', 
        //                     'sb.cat', 
        //                     'sb.title', 
        //                     'sb.img', 
        //                     'sb.author', 
        //                     'sb.isbn', 
        //                     'sb.lan', 
        //                     'sb.pub_year', 
        //                     'sb.version', 
        //                     'sb.no', 
        //                     'c.*', 
        //                     't.name')
        //                 ->get();
        // echo json_encode(array('status'=>'success', 'data'=>$data));
        // exit();

        // \App\Models\Entity\Books::doGetSubScriptionBookData($request::all());
    }

    public function doSaveTempleReceive(Request $request)
    {
        // if($request['count'] == 0 || $request['count'] == '') {
        //     echo json_encode(array('count'=>'required'));
        //     exit();
        // }

        // $diff = DB::table('sub_application as sp')
        //          ->leftJoin('temple_receive as tr', 'sp.id', '=', 'tr.spid')
        //          ->where('sp.id', '=', $request['spid'])
        //          ->select(DB::Raw('sp.count - sum(case when tr.count>0 then tr.count else 0 end) as diff'))
        //          ->get()[0]->diff;
        // if($diff < 0) {
        //     echo json_encode('Inventory shortage');
        //     exit();
        // }

        // if($request['count'] > $diff) {
        //     echo json_encode('Inventory shortage');
        //     exit();
        // }

        // try
        // {
        //     DB::beginTransaction();

        //     $tr = new \App\Models\Entity\TempleReceive;
        //     $tr['spid'] = $request['spid'];
        //     $tr['tid'] = $request['tid'];
        //     $tr['count'] = $request['count'];
        //     $tr->save();

        //     DB::commit();
        //     echo json_encode('success');
        //     exit();
        // }
        // catch(Exception $e){
        //     DB::rollback();
        //     echo json_encode($e);
        //     exit();
        // }

        // \App\Models\Entity\Books::doSaveTempleReceive($request::all());
    }
    
    public function BookBorrowView(Request $request)
    {
        $request = $request::all();

        //圖書館
        $tabs = array(
            array('id'=>'library', 'title'=>'圖書館', 'active'=>'active'),);

        if(UserService::UserTypeValidator('BookBorrow_RecordTab', Auth::user()->type))
            array_push($tabs, array('id'=>'record', 'title'=>'借書紀錄', 'active'=>''));

        array_push($tabs, array('id'=>'myrecord', 'title'=>'我的借書紀錄', 'active'=>''));
        if(UserService::UserTypeValidator('BookBorrow_RecordTab', Auth::user()->type))
            array_push($tabs, array('id'=>'borrow', 'title'=>'借書', 'active'=>''));

        if(isset($request['tab']) && $request['tab'])
            $tab = $request['tab'];
        else
            $tab = 'library';

        //process tab active
        foreach($tabs as &$t) {
            $t['active'] = '';
            if($t['id'] == $tab) $t['active'] = 'active';
        }
        unset($t);


        $filter = array();
        $Previous = '';
        $Next = '';
        if(!isset($request['page']) || !$request['page']) 
            $request['page'] = 1;
        if(isset($request['search']) && $request['search']) 
            $filter[] = "title like '%".$request['search']."%'";
        else
            $request['search'] = '';
        if(!UserService::UserTypeValidator('AddBookBorrow_itemShow', Auth::user()->type))
            $filter[] = "is_borrow = 'true'";

        $filter = implode(' and ', $filter);
        if($filter == '')
            $filter = '1';

        $books = BooksService::getBooksData($filter, $request['page'], 9);

        $pageCount = BooksService::getPageCount($filter);

        if($request['page'] == 1)
            $Previous = 'disabled';
        if($request['page'] == $pageCount)
            $Next = 'disabled';

        $linkParam = 'search='.$request['search'];
        $page = PageSupport::getPageArrayStructure('/BookBorrow', $pageCount, $request['page'], $linkParam);

        $bookStore = TempleService::getBookStore();

        $lans = CategoryService::getDataByType('lan');
        $book_type = CategoryService::getDataByType('library_books_type');



        //借書紀錄
        $rPrevious = '';
        $rNext = '';
        if(!isset($request['rpage']) || !$request['rpage']) 
            $request['rpage'] = 1;

        $record = BorrowBooksService::getBorrowBooksData('1', $request['rpage'], 15);

        $rpageCount = BooksService::getBorrowPageCount('1');

        if($request['rpage'] == 1)
            $rPrevious = 'disabled';
        if($request['rpage'] == $rpageCount)
            $rNext = 'disabled';

        $linkParam = 'tab=record';
        $rpage = PageSupport::getPageArrayStructure('/BookBorrow', $rpageCount, $request['rpage'], $linkParam);
        //例外情況 同頁多page
        foreach($rpage as &$item) {
            $item['link'] = str_replace('page', 'rpage', $item['link']);
        }
        unset($item);

        

        //我的借書紀錄
        $mPrevious = '';
        $mNext = '';
        if(!isset($request['mpage']) || !$request['mpage']) 
            $request['mpage'] = 1;

        $myrecord = BorrowBooksService::getBorrowBooksData(implode(' and ', array('a.upid', '=', Auth::user()->id)), 
                                                   $request['mpage'], 15);

        $mpageCount = BooksService::getBorrowPageCount('upid='.Auth::id());

        if($request['mpage'] == 1)
            $mPrevious = 'disabled';
        if($request['mpage'] == $mpageCount)
            $mNext = 'disabled';

        $linkParam = 'tab=myrecord';
        $mpage = PageSupport::getPageArrayStructure('/BookBorrow', $rpageCount, $request['mpage'], $linkParam);
        //例外情況 同頁多page
        foreach($mpage as &$item) {
            $item['link'] = str_replace('page', 'mpage', $item['link']);
        }
        unset($item);


        return view('BKBooksBorrow')->with('menu', Menu::setMenuList('BookBorrow'))
                                    ->with('userInfo', UserService::getUserBoxInfo())
                                    ->with('btnShow', UserService::UserTypeValidator('AddBookBorrow', Auth::user()->type))
                                    ->with('linkShow', UserService::UserTypeValidator('AddBookBorrowCount', Auth::user()->type))
                                    ->with('editShow', UserService::UserTypeValidator('EditBookBorrow', Auth::user()->type))

                                    ->with('books', $books)
                                    ->with('page', $page)
                                    ->with('pageCount', $pageCount)
                                    ->with('Previous', $Previous)
                                    ->with('Next', $Next)
                                    ->with('tab', $tabs)
                                    ->with('bookStore', $bookStore)
                                    ->with('book_type', $book_type)
                                    ->with('lans', $lans)
                                    ->with('record', $record)
                                    ->with('rpage', $rpage)
                                    ->with('rpageCount', $rpageCount)
                                    ->with('rPrevious', $rPrevious)
                                    ->with('rNext', $rNext)
                                    ->with('myrecord', $myrecord)
                                    ->with('mpage', $mpage)
                                    ->with('mpageCount', $mpageCount)
                                    ->with('mPrevious', $mPrevious)
                                    ->with('mNext', $mNext);
    }

    public function BookSubscriptionView(Request $request)
    {
        $request = $request::all();

        if(isset($request['year']) && $request['year']) 
            $y = $request['year'];
        else
            $y = date('Y');

        $tabs = array(
            array('id'=>'set', 'title'=>'年度書籍設定', 'active'=>''),
            array('id'=>'add', 'title'=>'書籍管理', 'active'=>''),
            array('id'=>'count', 'title'=>'各區統計', 'active'=>''),
            array('id'=>'distribute', 'title'=>'分發書籍', 'active'=>'active'));

        if(isset($request['tab']) && $request['tab'])
            $tab = $request['tab'];
        else
            $tab = 'add';

        //process tab active
        foreach($tabs as &$t) {
            $t['active'] = '';
            if($t['id'] == $tab) $t['active'] = 'active';
        }
        unset($t);

        //年度書籍設定
        $years = array('data'=>array(), 'word'=>'');
        for($i=0; $i<3; $i++) {
            array_push($years['data'], array(
                'active'=>$i==0 ? 'active' : '',
                'value'=>date('Y')+$i,
                'word'=>date('Y')+$i.'年'
                ));
        }
        foreach($years['data'] as $item) {
            if($item['active'] == 'active')
                $years['word'] = $item['word'];
        }

        $book_types = CategoryService::getDataByAttr('books_type');
        $book_types_vals = CategoryService::getDataByAttr('getDataByType');
        $areas = CategoryService::getDataByType('area');

        //各區統計
        $subBookCount = SubScriptionBooksService::getSubBooksCountData();

        //分發書籍
        $block_area = CategoryService::getDataByType('area');
        $block_temple = TempleService::getAllData();
        $block_book = SubApplicationService::getApplicationData();


        //書籍管理
        $filter = array();
        $Previous = '';
        $Next = '';
        if(!isset($request['page']) || !$request['page']) 
            $request['page'] = 1;


        $filter = array();
        if(isset($request['type']) && $request['type']) {
            $filter[] = "substr(subscription_books.cat, 1, Length(subscription_books.cat)-3)='".$request['type']."'";
        }

        if(isset($request['val']) && $request['val']) {
            $filter[] = "subscription_books.title like '%".$request['val']."%'";
        }

        if(isset($request['start']) && $request['start'] && isset($request['end']) && $request['end']) {

            $request['start'] = str_replace(array('年','月','日'), array('-','-',''), $request['start']);
            $request['end'] = str_replace(array('年','月','日'), array('-','-',''), $request['end']);
            $filter[] = "subscription_books.public_date between '".$request['start']."' and '".$request['end']."'";
        }
        else {
            $request['start'] = '';
            $request['end'] = '';
        }

        $filter[] = 'count > 0';
        $filter[] = "status != 'finish'";
        $filter = implode(' and ', $filter);
        if($filter == '')
            $filter = '1';

        $ddl_bookType = CategoryService::getAttr_DDL('books_type');

        $books = SubScriptionBooksService::getBooksData($filter, $request['page'], 9);

        $pageCount = SubScriptionBooksService::getPageCount($filter);

        if($request['page'] == 1)
            $Previous = 'disabled';
        if($request['page'] == $pageCount)
            $Next = 'disabled';

        $linkParam = '';
        $page = PageSupport::getPageArrayStructure('/BookSubscription', $pageCount, $request['page'], $linkParam);


        $cat = CategoryService::getBooksType_DDL(isset($request['type']) ? $request['type'] : '', 'books_type', '選擇搜尋類別');

        $bookStore = TempleService::getBookStore();
        $lans = CategoryService::getDataByType('lan');
        $book_type = CategoryService::getDataByType('library_books_type');

        return view('BKBookSubscription')->with('menu', Menu::setMenuList('BookSubscriptionView'))
                                         ->with('userInfo', UserService::getUserBoxInfo())
                                         ->with('books', $books)
                                         ->with('page', $page)
                                         ->with('pageCount', $pageCount)
                                         ->with('Previous', $Previous)
                                         ->with('Next', $Next)
                                         ->with('tab', $tabs)
                                         ->with('bookStore', $bookStore)
                                         ->with('book_type', $book_type)
                                         ->with('lans', $lans)
                                         ->with('ddl_bookType',$ddl_bookType)
                                         ->with('cat', $cat)

                                         ->with('y', $y)
                                         ->with('year', $years)
                                         ->with('book_types', $book_types)
                                         ->with('book_types_vals', $book_types_vals)
                                         ->with('areas', $areas)

                                         ->with('subBookCount', $subBookCount)

                                         ->with('block_area', $block_area)
                                         ->with('block_temple', $block_temple)
                                         ->with('block_book', $block_book);
    }

    public function BookReceiveView(Request $request)
    {
        $request = $request::all();

        $tabs = array(
            array('id'=>'receive', 'title'=>'新書請領', 'active'=>'active'),
            array('id'=>'record', 'title'=>'請領紀錄', 'active'=>''),
            array('id'=>'myrecord', 'title'=>'我的請領紀錄', 'active'=>''),);

        if(isset($request['tab']) && $request['tab'])
            $tab = $request['tab'];
        else
            $tab = 'receive';

        //process tab active
        foreach($tabs as &$t) {
            $t['active'] = '';
            if($t['id'] == $tab) $t['active'] = 'active';
        }
        unset($t);

        $Previous = '';
        $Next = '';
        if(!isset($request['page']) || !$request['page']) 
            $request['page'] = 1;

        $books = ReceiveBooksService::getBooksData('1', $request['page'], 9);

        $pageCount = ReceiveBooksService::getPageCount('1');

        if($request['page'] == 1)
            $Previous = 'disabled';
        if($request['page'] == $pageCount)
            $Next = 'disabled';

        $linkParam = '';
        $page = PageSupport::getPageArrayStructure('/BookReceive', $pageCount, $request['page'], $linkParam);

        $bookStore = TempleService::getBookStore();
        $lans = CategoryService::getDataByType('lan');
        $book_type = CategoryService::getDataByType('library_books_type');



        //請領紀錄
        $rPrevious = '';
        $rNext = '';
        if(!isset($request['rpage']) || !$request['rpage']) 
            $request['rpage'] = 1;

        $record = RecvApplicationService::getApplicationData('1', $request['rpage'], 15);

        $rpageCount = RecvApplicationService::getPageCount('1');

        if($request['rpage'] == 1)
            $rPrevious = 'disabled';
        if($request['rpage'] == $rpageCount)
            $rNext = 'disabled';

        $linkParam = 'tab=record';
        $rpage = PageSupport::getPageArrayStructure('/BookReceive', $rpageCount, $request['rpage'], $linkParam);
        //例外情況 同頁多page
        foreach($rpage as &$item) {
            $item['link'] = str_replace('page', 'rpage', $item['link']);
        }
        unset($item);



        //我的請領紀錄
        $mPrevious = '';
        $mNext = '';
        if(!isset($request['mpage']) || !$request['mpage']) 
            $request['mpage'] = 1;

        $myrecord = RecvApplicationService::getApplicationData('app.upid='.Auth::user()->id, $request['mpage'], 15);

        $mpageCount = RecvApplicationService::getPageCount('upid='.Auth::user()->id);

        if($request['mpage'] == 1)
            $mPrevious = 'disabled';
        if($request['mpage'] == $mpageCount)
            $mNext = 'disabled';

        $linkParam = 'tab=myrecord';
        $mpage = PageSupport::getPageArrayStructure('/BookSubscription', $mpageCount, $request['mpage'], $linkParam);
        //例外情況 同頁多page
        foreach($mpage as &$item) {
            $item['link'] = str_replace('page', 'mpage', $item['link']);
        }
        unset($item);


        return view('BKBookReceive')->with('menu', Menu::setMenuList('BookReceiveView'))
                                    ->with('userInfo', UserService::getUserBoxInfo())
                                    ->with('books', $books)
                                    ->with('page', $page)
                                    ->with('pageCount', $pageCount)
                                    ->with('Previous', $Previous)
                                    ->with('Next', $Next)
                                    ->with('tab', $tabs)
                                    ->with('bookStore', $bookStore)
                                    ->with('book_type', $book_type)
                                    ->with('lans', $lans)
                                    ->with('record', $record)
                                    ->with('rpage', $rpage)
                                    ->with('rpageCount', $rpageCount)
                                    ->with('rPrevious', $rPrevious)
                                    ->with('rNext', $rNext)
                                    ->with('myrecord', $myrecord)
                                    ->with('mpage', $mpage)
                                    ->with('mpageCount', $mpageCount)
                                    ->with('mPrevious', $mPrevious)
                                    ->with('mNext', $mNext);
    }

    public function doDeleteTmpBorrow(Request $request)
    {
        $request = $request::all();

        tmpBorrowService::delete($request['id']);

        echo json_encode('success');
        exit();
    }

    public function doAddBorrow(Request $request)
    {
        $request = $request::all();

        BorrowBooksService::AddBorrow($request);

        echo json_encode('success');
        exit();
    }

    public function doEditBorrow(Request $request)
    {
        $request = $request::all();

        $updateData = array();
        $updateData['status'] = $request['status'];;
        BorrowBooksService::update($request['id'], $updateData);

        echo json_encode('success');
        exit();
    }
}
