<div class="search_bar" style="height: 120px;">
    <form action="/Personnel" method="GET" >

        <div class="col-md-2 col-sm-2">
            <div class="area dropdown">
                <input type="hidden" name="area" value="<?php if(@isset($_GET['area']))echo $_GET['area'];@endisset ?>" >
                <button class="btn btn-default dropdown-toggle" type="button" name="area" data-toggle="dropdown" aria-expanded="true">
                    {{$ddl_areas['word']}}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    @foreach($ddl_areas['data'] as $item)                 
                    <li role="presentation" class="{{$item['active']}}" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1">{{$item['word']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-2">
            <div class="group dropdown">
                <input type="hidden" name="group" value="<?php if(@isset($_GET['group']))echo $_GET['group'];@endisset ?>" >
                <button class="btn btn-default dropdown-toggle" type="button" name="group" data-toggle="dropdown" aria-expanded="true">
                    {{$groups['word']}}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" name="ddl">選擇團隊組別</a></li>
                    @foreach($groups['data'] as $item)
                    <li role="presentation" class="{{$item['active']}}" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1" href="#" name="ddl">{{$item['word']}}</a></li>
                    @endforeach      
                </ul>
            </div> 
        </div>
                            
        <div class="col-md-4">
            <div class="input-group">
                <input type="text" class="form-control" name="name" value="<?php if(@isset($_GET['name']))echo $_GET['name'];@endisset ?>" placeholder="搜尋姓名" />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">搜尋</button>
                </span>
            </div>
        </div>

        <div class="col-md-2" style="height:44px;"></div>
        <div class="col-md-12">
            @for($i = 0; $i < Count($positions); $i++)
            <label class="radio-inline">
              <input type="checkbox" name="position[]" id="radio{{$i}}" value="{{$positions[$i]['value']}}" {{$positions[$i]['checked']}}> {{$positions[$i]['word']}}
            </label>
            @endfor
        </div>
        
        <div class="col-md-12">
            @for($i = 0; $i < Count($works); $i++)
            <label class="radio-inline">
              <input type="checkbox" name="work[]" id="radio{{$i}}" value="{{$works[$i]['value']}}"  {{$works[$i]['checked']}}> {{$works[$i]['word']}}
            </label>
            @endfor
        </div>

        <div class="col-md-12">
            @for($i = 0; $i < Count($templer); $i++)
            <label class="radio-inline">
                <input type="checkbox" name="templer" id="radio{{$i}}" value="{{$templer[$i]['value']}}"  {{$templer[$i]['checked']}}> {{$templer[$i]['word']}}
            </label>
            @endfor
        </div>   
    </form>
    
</div>

<div style="height:20px"></div>
<table class="table table-hover personnel_table">
    <thead>
        <tr>
            <th></th>
            <th>性別</th>
            <th>姓名</th>                            
            <th>年次</th>
            <th>手機</th>
            <th>點傳師</th>
            <th>天職</th>
            <th>立愿</th>
            <th>組別</th>
        </tr>
    </thead>
        @foreach($users as $item)  
        <tr data-val="{{$item['id']}}" >
            <th class="edit" data-val="{{$item['id']}}" >
                @if($item['show'] || $editShow)
                <span class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="modal" data-target="#personnel_edit"></span>
                @endif
            </th>
            <th data-toggle="modal" data-target="#personnel_view">{{$item['gender']}}</th>
            <th data-toggle="modal" data-target="#personnel_view">{{$item['first_name']}}{{$item['last_name']}}</th>                        
            <th data-toggle="modal" data-target="#personnel_view">{{$item['year']}}</th>
            <th data-toggle="modal" data-target="#personnel_view">{{$item['mobile']}}</th>
            <th data-toggle="modal" data-target="#personnel_view">{{$item['Dianchuanshi_name']}}{{$item['Dianchuanshi_out']}}</th>
            <th data-toggle="modal" data-target="#personnel_view">{{$item['work']}}</th>
            <th data-toggle="modal" data-target="#personnel_view">{{$item['position']}}</th>
            <th data-toggle="modal" data-target="#personnel_view">{{$item['group']}}-{{$item['group_type']}}</th>
        </tr>
        @endforeach
</table>

<nav aria-label="Page navigation" style="text-align: center;">
  <ul class="pagination">
    <li class="{{$Previous}}">
      <a href="/Personnel?page=1&{{$linkParam}}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    @foreach($page as $item)
    <li class="{{$item['active']}}"><a href="{{$item['link']}}">{{$item['count']}}</a></li>
    @endforeach
    <li class="{{$Next}}">
      <a href="/Personnel?page={{$pageCount}}&{{$linkParam}}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>