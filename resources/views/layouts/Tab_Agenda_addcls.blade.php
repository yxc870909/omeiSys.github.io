<div style="height:20px"></div>
<form class="form-horizontal" name="worker-box" role="form">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <div class="form-group">
        <div class="col-md-2">
            <label>區域</label>
            <div class="area dropdown">
                <input type="hidden" name="area" value="" >
                <button class="btn btn-default dropdown-toggle" type="button" name="area" data-toggle="dropdown" aria-expanded="true">
                    選擇區域
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    @foreach($areas as $item)
                    <li role="presentation" data-val="{{$item['area']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['word']}}</a></li>
                    @endforeach
                </ul>
            </div>  
            <div class="error-area" style="color: red;"></div>                              
        </div>   
                            
        <div class="col-md-2">
            <label>開班壇名</label>
            <div class="temple dropdown">
                <input type="hidden" name="temple" value="" >
                <button class="btn btn-default dropdown-toggle" type="button" name="temple" data-toggle="dropdown" aria-expanded="true">
                    ---
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    @foreach($operating as $item)                 
                    <li role="presentation" data-val="{{$item['id']}}"><a role="menuitem" tabindex="-1">{{$item['name']}}壇</a></li>
                    @endforeach
                </ul>
            </div> 
            <div class="error-temple" style="color: red;"></div>  
        </div>
        
        <div class="col-md-offset-1 col-md-7">
            <br />
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="one" > 一天法會
            </label>
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="recls" checked> 複 習 班
            </label>
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="three" checked> 三天法會
            </label>
        </div>
    </div>

    <div class="form-group">
            <div class="col-md-3">
                <label>開班時間</label>
                <div class="input-group date">
                    <input type="text" class="form-control" name="add_date" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div> 
                <div class="error-time" style="color: red;"></div>
            </div>

            <div class="col-md-8">
                <label>歲次</label>
                <div class="form-group">

                    <div class="col-md-3">
                        <input type="text" class="form-control" name="yyy" placeholder="西元年">                        
                    </div>
                    <label  class="col-md-1 control-label" style="padding-left: 0; text-align: left;">年</label>
                            
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="yy" placeholder="ex: 子丑">                        
                    </div>
                            
                    <div class="col-md-2">
                        <div class="mm dropdown">
                            <input type="hidden" name="mm" value="" >
                            <button class="btn btn-default dropdown-toggle" type="button" name="mm" data-toggle="dropdown" aria-expanded="true">
                                月
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                @foreach($lunar_month as $item)
                                <li role="presentation" data-val="{{$item}}"><a role="menuitem" tabindex="-1" href="#">{{$item}}</a></li>
                                @endforeach
                            </ul>
                        </div>                                
                    </div>
                                
                    <div class="col-md-2">
                        <div class="dd dropdown">
                            <input type="hidden" name="dd" value="" >
                            <button class="btn btn-default dropdown-toggle" type="button" name="dd" data-toggle="dropdown" aria-expanded="true">
                                日
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                @foreach($lunar_day as $item)
                                <li role="presentation" data-val="{{$item}}"><a role="menuitem" tabindex="-1" href="#">{{$item}}</a></li>
                                @endforeach
                            </ul>
                        </div>                                
                    </div> 
                                
                </div>                
            </div>
        </div>
    <hr>    
                
    <div class="panel-group" id="register" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default worker" style="display: none">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#register" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        辦事人員
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    @include('layouts.Tab_Agenda_addcls_worker', array($lunar_month, $lunar_day, $lunar_hour))
                </div>
            </div>
        </div>
                        
        <div class="panel panel-default joiner">
            <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#register" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      班員
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body">
                    @include('layouts.Tab_Agenda_addcls_joiner', array($edus, $skills))
                </div>
            </div>
        </div>
    </div>
                                    
    <div style="height:10px"></div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>姓名</th>
                <th>性別</th>
                <th>引師</th>
                <th>保師</th>
                <th>年次</th>
                <th>手機</th>
                <th style="display: none;">室內電話</th>
                <th>學歷</th>
                <th>職業</th>
                <th>詳細地址</th>
                <th>備註</th>
                <th style="display: none;">佛堂</th>
                <th></th>
            </tr>
        </thead>
                        
    </table>
                
    <div style="height:10px"></div>
    <div align="right">
        <button type="button" class="btn btn-primary right" name="add-agenda-save" aria-expanded="fales" data-toggle="modal" data-target="#confirm_agenda">送出</button>
    </div>
</form>