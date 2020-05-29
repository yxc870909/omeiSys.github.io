<div class="search_bar">
    <div class="col-sm-6">
        <div class="input-group">
            <div class="input-group-btn">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expaned="false" >選擇搜尋類別<span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">書籍名稱</a></li>
                    <li><a href="#">領書人</a></li>
                    <li><a href="#">申請人</a></li>
                </ul>
            </div>
            <input type="text" class="form-control" placeholder="" />
        </div>
    </div>                           
</div>

<div style="height:20px"></div>
<table class="record_table table table-hover">
    @foreach($record as $item)
    <tr data-val="{{$item['id']}}" data-toggle="modal" data-target="#Edit_record">
        <th>
            <a href="" style="cursor: default; text-decoration:none;">{{$item['title']}}</a>
        </th>
        <th style="width: 10%; text-align: right;">{{$item['first_name']}}{{$item['last_name']}}</th>
        <th style="width: 14%; text-align: center;">{{$item['count']}}本</th>
        <th class="{{$item['color']}}" style="width: 10%; text-align: center;">{{$item['statusWord']}}</th>
    </tr>
    @endforeach
</table>

<nav aria-label="Page navigation" style="text-align: center;">
  <ul class="pagination">
    <li class="{{$rPrevious}}">
      <a href="/BookBorrow?page=1&tab=record" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    @foreach($rpage as $item)
    <li class="{{$item['active']}}"><a href="{{$item['link']}}">{{$item['count']}}</a></li>
    @endforeach
    <li class="{{$rNext}}">
      <a href="/BookBorrow?page={{$rpageCount}}&tab=record" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>