<div id="bk-recordgroup">
    <ul class="nav nav-tabs" role="tablist">        
        <li role="presentation" class="active"><a href="#Introducer" aria-controls="Introducer" role="tab" data-toggle="tab">引師紀錄</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

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
                            <li role="presentation" class="{{$item['active']}}" data-val="{{$item['value']}}"><a href="/RecordIntroducer?upid={{$upid}}&year={{$item['value']}}"role="menuitem" tabindex="-1">{{$item['word']}}</a></li>
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
                   <a class="collapsed  open" data-id="" data-toggle="collapse" data-parent="#temple" href="#{{$item['id']}}" aria-expanded="false" aria-controls="@{{href}}">
                       {{$item['date']}} 掛號
                   </a>
                </h4>
           </div>
           <div id="{{$item['id']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
               <div class="panel-body"> 

                   <p style="font-size: 18px;">地點: {{$item['name']}}</p>
                   <p style="font-size: 18px;">{{$item['date2']}}</p>
                   <label class="col-md-12" >掛號人：</label>
                   <p style="padding-left: 40px;">{{$item['users']}}</p>
               </div>
           </div>
        </div>
        @endforeach
        @endforeach


    </div>


</div>
    