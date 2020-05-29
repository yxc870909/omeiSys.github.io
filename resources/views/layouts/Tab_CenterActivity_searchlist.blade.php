<div class="search_bar">
    <div class="form-group">
        <div class="col-md-2 col-sm-2">
            <div class="year dropdown">
                <input type="hidden" name="year" value="<?php if(@isset($_GET['area']))echo $_GET['area'];@endisset ?>" >
                <button class="btn btn-default dropdown-toggle" type="button" name="year" data-toggle="dropdown" aria-expanded="true">
                    {{$year['word']}}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    @foreach($year['data'] as $y)                 
                    <li role="presentation" class="{{$y['active']}}" data-val="{{$y['value']}}"><a href="/CenterActivity?year={{$y['value']}}"role="menuitem" tabindex="-1">{{$y['word']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div style="height:20px"></div>
<div class="panel-group" id="Details" role="tablist" aria-multiselectable="true">
    @foreach($data as $t)
    @if($t['type'] == $item['title'])
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed  open" data-id="{{$t['id']}}" data-toggle="collapse" data-parent="#temple" href="#No{{$t['id']}}" aria-expanded="false" aria-controls="@{{href}}">
                    {{$t['add_date']}}
                </a>
             </h4>
        </div>
        <div id="No{{$t['id']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">                
                參班人數: {{$t['count']}}

                <table class="table">
                </table>

            </div>
        </div>
    </div>
    @endif
    @endforeach

</div>