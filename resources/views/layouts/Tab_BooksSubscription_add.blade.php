<form action="/BookSubscription" method="GET" >
    <div class="search_bar">    
        <div class="col-md-6">
            <div class="input-daterange input-group date" id="datepicker">
                <span class="input-group-addon">發放日期從</span>
                <input type="text" class="input-md form-control" name="start" value="<?php if(@isset($_GET['start']))echo $_GET['start'];@endisset ?>" />
                <span class="input-group-addon">到</span>
                <input type="text" class="input-md form-control" name="end" value="<?php if(@isset($_GET['end']))echo $_GET['end'];@endisset ?>" />
            </div>
        </div> 

        

        <div class="col-md-6">
            <div class="input-group">
                <div class="type input-group-btn">
                    <input type="hidden" name="type" value="<?php if(@isset($_GET['type']))echo $_GET['type'];@endisset ?>">
                    <button class="btn btn-default dropdown-toggle" name="type" data-toggle="dropdown" aria-expaned="false" >
                        {{$cat['word']}}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @foreach($ddl_bookType['data'] as $item)
                        <li class="{{$item['active']}}" data-val="{{$item['value']}}"><a href="#">{{$item['attribute']}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <input type="text" class="form-control" name="val" value="<?php if(@isset($_GET['val']))echo $_GET['val'];@endisset ?>" placeholder="" />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">搜尋</button>
                </span>
            </div> 
        </div>                                  
    </div>
</form>


<div style="height:20px"></div>
<div class="row">
    
    @foreach($books as $item)
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <img name="item_img" src="/upload/subscription/{{$item['img']}}" alt="{{$item['title']}}" data-val="{{$item['id']}}" data-toggle="modal" data-target="#view_Subscriptionbook">
            <div class="caption" style="padding-bottom: 0;">
                <h5>發放時間 : {{$item['public_date']}}</h5>
                <p style="height: 38px;text-align: center;">{{$item['title']}}</p>
                <div style="display: inline-block;width: 100%;height: 100%;">
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
      <a href="/BookSubscription?page=1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    @foreach($page as $item)
    <li class="{{$item['active']}}"><a href="{{$item['link']}}">{{$item['count']}}</a></li>
    @endforeach
    <li class="{{$Next}}">
      <a href="/BookSubscription?page={{$pageCount}}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>