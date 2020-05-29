<div class="search_bar">
    <div class="col-md-2">
        <div class="dropdown">
            <input type="hidden" name="" value="" >
            <button class="btn btn-default dropdown-toggle" type="button" name="" data-toggle="dropdown" aria-expanded="true">
                選擇書籍類別
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">foreach</a></li>
                
            </ul>
        </div> 
    </div>        
                                    
    <div class="col-md-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="搜尋書名" />
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">搜尋</button>
            </span>
        </div>
    </div>
    <label class="col-md-3 control-label" style="margin-top: 13px;">
        <a href="" data-toggle="modal" data-target="#Count">盤點書籍</a>
    </label>                                   
</div>

<div style="height:20px"></div>
<div class="row">

    @foreach($books as $item)
    <div class="col-md-6 col-md-4">
        <div class="thumbnail">
            <img src="/upload/receive/{{$item['img']}}" alt="{{$item['title']}}" name="item_img" data-val="{{$item['id']}}" data-toggle="modal" data-target="#view_Receivebook">
            <div class="caption">
                <h3></h3>
                <p style="height: 38px;text-align: center;">{{$item['title']}}</p>
                <div style="display: inline-block;width: 100%;height: 100%;">
                    <p class="clearMargin" style="text-align: left;float: left;">庫存: {{$item['count']}}本</p>

                    <p class="clearMargin" style="text-align: right;float: right;">
                        <a class="edit_btn" data-toggle="modal" data-target="#Edit_book" data-val="{{$item['id']}}">編輯</a>
                    </p>
                </div>
                
            </div>
        </div>
    </div>
    @endforeach
              
</div>

<nav aria-label="Page navigation" style="text-align: center;">
  <ul class="pagination">
    <li class="{{$Previous}}">
      <a href="/BookReceive?page=1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    @foreach($page as $item)
    <li class="{{$item['active']}}"><a href="{{$item['link']}}">{{$item['count']}}</a></li>
    @endforeach
    <li class="{{$Next}}">
      <a href="/BookReceive?page={{$pageCount}}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>