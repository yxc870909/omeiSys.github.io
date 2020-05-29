<div class="search_bar">
    <div class="form-group">
        <div class="col-md-2 col-md-2">
            <div class="year dropdown">
                <input type="hidden" name="year" value="" >
                <button class="btn btn-default dropdown-toggle" type="button" name="year" data-toggle="dropdown" aria-expanded="true">
                    {{$year2['word']}}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    @foreach($year2['data'] as $item)                 
                    <li role="presentation" class="{{$item['active']}}" data-val="{{$item['value']}}"><a href="/RecordActivity?upid={{$upid}}&year={{$item['value']}}"role="menuitem" tabindex="-1">{{$item['word']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div style="height:20px"></div>
@foreach($data2 as $mon => $val)
<h4>{{$mon}}月</h4>
@foreach($val as $item)
<table class="table">
   <tr>
       <td style="width: 20px;">{{$item['date']}}</td>
       <td>{{$item['name']}}壇</td>
       <td style="width: 20%;">求道人數 {{$item['count']}}</td>
   </tr>
</table>
@endforeach
@endforeach