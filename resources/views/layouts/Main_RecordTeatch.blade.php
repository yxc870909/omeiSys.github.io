<div id="bk-recordgroup">
    <ul class="nav nav-tabs" role="tablist">
        @foreach($tabs as $tab)
        <li role="presentation" class="{{$tab['active']}}"><a href="{{$tab['link']}}" aria-controls="{{$tab['val']}}" role="tab" data-toggle="tab">{{$tab['word']}}</a></li>
        @endforeach
        
    </ul>

    <div class="search_bar">
        <div class="form-group">
            <div class="col-md-2 col-md-2">
                <div class="year dropdown">
                    <input type="hidden" name="year" value="" >
                    <button class="btn btn-default dropdown-toggle" type="button" name="year" data-toggle="dropdown" aria-expanded="true">
                        {{$year['word']}}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        @foreach($year['data'] as $item)                 
                        <li role="presentation" class="{{$item['active']}}" data-val="{{$item['value']}}"><a href="/RecordTeatch?upid={{$upid}}&year={{$item['value']}}"role="menuitem" tabindex="-1">{{$item['word']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div style="height:20px"></div>
    @foreach($data as $mon => $val)
    <h4>{{$mon}}月</h4>
    <hr />
    @foreach($val as $item)
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed  open" data-id="" data-toggle="collapse" data-parent="#temple" href="#{{$item['type']}}{{$item['id']}}" aria-expanded="false" aria-controls="@{{href}}">
                    {{$item['date']}} {{$item['type']}}
                </a>
             </h4>
        </div>
        <div id="{{$item['type']}}{{$item['id']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body"> 

                <p style="font-size: 18px;">地點: {{$item['name']}}</p>
                <label class="col-md-12" >操持：</label> 
                <p style="padding-left: 40px;">
                    @foreach($item['preside'] as $v) {{$v}} @endforeach
                </p>

                <label class="col-md-12" >聖歌：</label>
                @foreach($item['course'] as $v)
                <p style="padding-left: 40px;">{{$v}}</p>
                @endforeach
                

                <label class="col-md-12" >課程：</label>
                @foreach($item['song'] as $v)
                <p style="padding-left: 40px;">{{$v}}</p>
                @endforeach

            </div>
        </div>
    </div>
    @endforeach
    @endforeach
</div>
    