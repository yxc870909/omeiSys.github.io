<div style="height:20px"></div>
<form class="form-horizontal" name="worker-box" role="form">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <div class="form-group">
        <div class="col-sm-2">
            <label>區域</label>
            <div class="area dropdown">
                <input type="hidden" name="area" value="" >
                <button class="btn btn-default dropdown-toggle" type="button" name="area" data-toggle="dropdown" aria-expanded="true">
                    選擇區域
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    @foreach($areas as $item)
                    <li role="presentation" data-val="{{$item->area}}"><a role="menuitem" tabindex="-1" href="#">{{$item->word}}</a></li>
                    @endforeach
                </ul>
            </div>                                
        </div>   
                            
        <div class="col-sm-2">
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
        </div>
        <div class="col-sm-3"></div>
        <div class="col-sm-4">
            <br />
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="one" > 一天法
            </label>
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="recls" checked> 一天法
            </label>
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="three" checked> 一天法
            </label>
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="three" checked> 一天法
            </label>
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="three" checked> 一天法
            </label>
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="three" checked> 一天法
            </label>
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="three" checked> 一天法
            </label>
            <label class="radio-inline">
                <input type="radio" name="cls_type" value="three" checked> 一天法
            </label>
        </div>
    </div>

    <div class="form-group">
            <div class="col-md-3">
                <label>時間</label>
                <div class="input-group date">
                    <input type="text" class="form-control" name="add_date" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div> 
            </div>
        </div>
    <hr>
                                    
    <div style="height:10px"></div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>姓名</th>
                <th>性別</th>
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