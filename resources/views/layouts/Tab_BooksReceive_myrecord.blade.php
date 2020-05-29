<div style="height:20px"></div>
<table class="view_table table table-hover">
    @foreach($myrecord as $item)
    <tr>
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
    <li class="{{$mPrevious}}">
      <a href="/BookSubscription?page=1&tab=myrecord" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    @foreach($mpage as $item)
    <li class="{{$item['active']}}"><a href="{{$item['link']}}">{{$item['count']}}</a></li>
    @endforeach
    <li class="{{$mNext}}">
      <a href="/BookSubscription?page={{$mpageCount}}&tab=myrecord" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>