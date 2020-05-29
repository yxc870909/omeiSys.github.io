<div class="search_bar">        
    <form action="/BookBorrow" method="GET" >
        <div class="col-md-5">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="搜尋書名" />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">搜尋</button>
                </span>
            </div>
        </div>
        @if($linkShow)
        <label class="col-md-3 control-label" style="margin-top: 13px;">
            <a href="" data-toggle="modal" data-target="#Count">盤點書籍</a>
        </label>
        @endif
    </form>          
    
    <div class="col-md-2" style="height:44px;"></div>                                    
</div>

<div style="height:20px"></div>
<div class="row">

    @foreach($books as $item)
    <div class="col-md-6 col-md-4">
        <div class="thumbnail">
            <img src="/upload/books/{{$item['img']}}" alt="{{$item['title']}}" name="item_img" data-val="{{$item['id']}}" data-toggle="modal" data-target="#view_Borrowbook">
            <div class="caption">
                <h3></h3>
                <p style="height: 38px;text-align: center;">{{$item['title']}}</p>
                <div style="display: inline-block;width: 100%;height: 100%;">
                    <p class="clearMargin" style="text-align: left;float: left;">庫存: {{$item['count']}}本</p>

                    @if($editShow)
                    <p class="clearMargin" style="text-align: right;float: right;">
                        <a class="edit_btn" data-toggle="modal" data-target="#Edit_book" data-val="{{$item['id']}}">編輯</a>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
              
</div>

<nav aria-label="Page navigation" style="text-align: center;">
  <ul class="pagination">
    <li class="{{$Previous}}">
      <a href="/BookBorrow?page=1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    @foreach($page as $item)
    <li class="{{$item['active']}}"><a href="{{$item['link']}}">{{$item['count']}}</a></li>
    @endforeach
    <li class="{{$Next}}">
      <a href="/BookBorrow?page={{$pageCount}}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>