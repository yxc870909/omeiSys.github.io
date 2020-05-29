<div id="bk-recordgroup">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#aa" aria-controls="aa" role="tab" data-toggle="tab">{{$tabTitle}}</a></li>
        
    </ul>

    <div style="height:20px"></div>


    <table class="table table-hover">
        @foreach($data as $item)
        <tr>
            <th>{{$item['year']}}</th>
            <th>{{$item['area']}}</th>
            <th>{{$item['group']}}</th>
            <th>{{$item['type']}}</th>
        </tr>
        @endforeach
    </table>

    <nav aria-label="Page navigation" style="text-align: center;">
      <ul class="pagination">
        <li class="{{$Previous}}">
          <a href="/Personnel?page=1" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        @foreach($page as $item)
        <li class="{{$item['active']}}"><a href="{{$item['link']}}">{{$item['count']}}</a></li>
        @endforeach
        <li class="{{$Next}}">
          <a href="/Personnel?page={{$pageCount}}" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
</div>
    