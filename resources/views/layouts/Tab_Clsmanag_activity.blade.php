<div class="search_bar">
    <div class="form-group">
        <div class="col-md-2 col-sm-2">
            <div class="year dropdown">
                <input type="hidden" name="year" value="" >
                <button class="btn btn-default dropdown-toggle" type="button" name="year" data-toggle="dropdown" aria-expanded="true">
                    {{$year['word']}}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    @foreach($year['data'] as $item)                 
                    <li role="presentation" class="{{$item['active']}}" data-val="{{$item['value']}}"><a href="/Clsmanag?year={{$item['value']}}&tab=cls"role="menuitem" tabindex="-1">{{$item['word']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div style="height:20px"></div>
<table class="table table-hover">
    
    @foreach($data as $item)
    <tr>
        <th class="clickable-row" data-href="/ClsDetail?data={{$item['type']}}{{$y}}" style="width: 80%;  font-size: 90%;">{{$item['type']}} - <a style="cursor: default; text-decoration:none;">{{$item['min_date']}} ~ {{$item['max_date']}}</a></th>
        <th style="width: 20%"><span class="label label-success">共編列了 {{$item['count']}} 堂課</span></th>
    </tr>
    @endforeach
    
</table>