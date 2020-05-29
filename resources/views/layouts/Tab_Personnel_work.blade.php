<div class="work-box" style="margin-top: 20px;">
    <form class="form-horizontal" name="doAddGroups" role="form">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="form-group">
            <label class="col-md-2 control-label">年度</label>
            <div class="col-md-4">
                <div class="year dropdown">
                    <input type="hidden" name="year" value="" >
                    <button class="btn btn-default dropdown-toggle" type="button" name="year" data-toggle="dropdown" aria-expanded="true">
                        選擇年度
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        @foreach($yearly as $item)
                        <li role="presentation" data-val="{{$item}}"><a role="menuitem" tabindex="-1" href="#">{{$item}}</a></li>
                        @endforeach
                    </ul>
                </div> 
                <div class="error-year" style="color: red;"></div>
            </div>           
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">區域</label>
            <div class="col-md-4">
                <div class="area dropdown">
                    <input type="hidden" name="area" value="" >
                    <button class="btn btn-default dropdown-toggle" type="button" name="area" data-toggle="dropdown" aria-expanded="true">
                        選擇負責區域
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        @foreach($areas as $item)
                        <li role="presentation" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['word']}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="error-area" style="color: red;"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">組別</label>
            <div class="col-md-4">
                <div class="group dropdown">
                    <input type="hidden" name="group" value="" >
                    <button class="btn btn-default dropdown-toggle" type="button" name="group" data-toggle="dropdown" aria-expanded="true">
                        選擇負責組別
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        @foreach($groups['data'] as $item)
                        <li role="presentation" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['word']}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="error-group" style="color: red;"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">組長</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="leader" placeholder="輸入姓名或email"> 
            </div>
            <div class="col-md-1">
                <button type="button" class="leader btn btn-primary right" aria-expanded="fales">新增</button>
            </div>
            <div class="leader-list col-md-4">
            </div>
            <div style="height: 35px;">
                <div class="error-leader" style="color: red; margin-top: 15px;  margin-left: 5px;"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">副組長</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="deputy_leader" placeholder="輸入姓名或email"> 
            </div>
            <div class="col-md-1">
                <button type="button" class="deputy_leader btn btn-primary right" aria-expanded="fales">新增</button>
            </div>
            <div class="deputy_leader-list col-md-4">
            </div>
            <div style="height: 35px;">
                <div class="error-deputy_leader" style="color: red; margin-top: 15px; margin-left: 5px;"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">組員</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="member" placeholder="輸入姓名或email"> 
            </div>
            <div class="col-md-1">
                <button type="button" class="member btn btn-primary right" aria-expanded="fales">新增</button>
            </div>
            <div class="member-list col-md-4">
            </div>
        </div>
                
        <div align="right" style="margin-top: 20px;">
            <button type="button" class="btn btn-primary right" name="add" aria-expanded="fales">新增</button>
        </div>

        <div class="group-data" style="display: none;">
            <table class="table">
              <thead class="thead-inverse">
                <tr>
                    <th>年度</th>
                    <th>區域</th>
                    <th>組別</th>
                    <th>組長</th>
                    <th>副組長</th>
                    <th>組員</th>
                    <th></th>
                </tr>
              </thead>

            </table>

            <div align="right" style="margin-top: 20px;">
                <button type="button" class="save btn btn-primary right" aria-expanded="fales">送出</button>
            </div>    
        </div>
        
    </form>
</div>