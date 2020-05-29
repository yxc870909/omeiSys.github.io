<div class="search_bar">
    <form action="/Agenda" method="GET" >
        <div class="col-md-6">
            <div class="input-daterange input-group date" id="datepicker">
                <span class="input-group-addon">日期區間從</span>
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
                        {{$dispatch['word']}}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#" name="ddl">選擇搜尋類別</a></li>
                        @foreach($dispatch['data'] as $item)
                        <li class="{{$item['activ']}}" data-val="{{$item['value']}}"><a href="#">{{$item['word']}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <input type="text" class="form-control" name="val" value="<?php if(@isset($_GET['val']))echo $_GET['val'];@endisset ?>" placeholder="" />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">搜尋</button>
                </span>
            </div> 
        </div>  
    </form>
        
                    
</div>

<div style="height:20px"></div>
<table class="table table-hover agenda_table">
    <thead>
        <tr>
            <th></th>
            <th>班程類別</th>
            <th>區域</th>
            <th>佛堂</th>
            <th>日期</th>
            <th>主班經理</th>
            <th>班員數</th>
        </tr>
    </thead>
    
    @for($i = 0; $i < count($users); $i++)    
    <tr data-val="{{$users[$i]['id']}}">
        <th></th>
        <th data-toggle="modal" data-target="#view_Agenda">{{$users[$i]['type']}}</th>
        <th data-toggle="modal" data-target="#view_Agenda">{{$users[$i]['area']}}</th>                        
        <th data-toggle="modal" data-target="#view_Agenda">{{$users[$i]['temple_name']}}</th>
        <th data-toggle="modal" data-target="#view_Agenda">{{$users[$i]['add_date']}}</th>
        <th data-toggle="modal" data-target="#view_Agenda">{{$users[$i]['name']}}</th>
        <th data-toggle="modal" data-target="#view_Agenda">{{$users[$i]['count']}}</th>
    </tr>
    @endfor
    
</table>

<nav aria-label="Page navigation" style="text-align: center;">
  <ul class="pagination">
    <li class="{{$Previous}}">
      <a href="/Agenda?page=1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    @foreach($page as $item)
    <li class="{{$item['active']}}"><a href="{{$item['link']}}">{{$item['count']}}</a></li>
    @endforeach
    <li class="{{$Next}}">
      <a href="/Agenda?page={{$pageCount}}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>