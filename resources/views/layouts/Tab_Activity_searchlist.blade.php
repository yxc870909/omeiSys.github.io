<div style="height:20px"></div>
<table class="table table-hover">
   @foreach($data as $k=>$v)
   @foreach($v as $val)
   @if($k == $item['title'])
    <tr>
        <th style="width: 6%;">
            <div class="user_box {{$val['gender']}}">
                @if($val['gender'] == 'male') 乾
                @else 坤
                @endif
            </div>
        </th>
        <th>{{$val['name']}}</th>
        <th style="width: 20%;"></th>
        <th style="width: 30%; text-align: right;"><a href="/Activity?upid={{$val['upid']}}">檢視活動紀錄</a></th>
    </tr>    
    @endif
    @endforeach
    @endforeach
</table>

<nav aria-label="Page navigation" style="text-align: center;">
  <ul class="pagination">
    @foreach($Previous as $k=>$previous) @if($k == $item['title'])
    <li class="{{$previous}}">
    @endif @endforeach
      <a href="/Activity?tab={{$item['title']}}&page=1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    @foreach($page as $k=>$p) @if($k == $item['title']) @foreach($p as $key=>$val)
    <li class="{{$val['active']}}"><a href="{{$val['link']}}">{{$val['count']}}</a></li>
    @endforeach @endif @endforeach

    @foreach($Next as $k=>$next) @if($k == $item['title'])
    <li class="{{$next}}">@endif @endforeach

      @foreach($pageCount as $p) @if($p['type'] == $item['title'])
      <a href="/Activity?tab={{$item['title']}}&page={{$p['count']}}" aria-label="Next"> @endif @endforeach
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>