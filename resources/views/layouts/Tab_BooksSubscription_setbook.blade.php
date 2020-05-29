<div class="search_bar">
    <div class="form-group">
        <div class="col-md-2 col-sm-2">
            <div class="year dropdown">
                <input type="hidden" name="year" value="{{$y}}" >
                <button class="btn btn-default dropdown-toggle" type="button" name="year" data-toggle="dropdown" aria-expanded="true">
                    {{$year['word']}}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    @foreach($year['data'] as $item)                 
                    <li role="presentation" class="{{$item['active']}}" data-val="{{$item['value']}}"><a href="#" role="menuitem" tabindex="-1">{{$item['word']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div style="height:20px"></div>
<table class="table table-hover">
    @foreach($areas as $item)
   <tr>
       <th>{{$item->word}}</th>
       <th style="width: 20%; text-align: right;"><a class="areaCount" href="#" data-toggle="modal" data-target="#setCount" data-val="{{$item->value}}">數量設定</a></th>
   </tr>
   @endforeach
</table>