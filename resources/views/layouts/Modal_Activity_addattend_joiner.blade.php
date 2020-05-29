<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">是否為峨眉道親</label>
    <div class="col-sm-2">
        <label class="radio-inline">
            <input type="radio" name="inDB" value="yes" checked> 是
        </label>
        <label class="radio-inline">
            <input type="radio" name="inDB" value="no"> 否
        </label>
    </div>
</div>
<hr />

<div class="quickSearch_box">
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">快速查詢</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="quickSearch" placeholder="輸入道親姓名"> 
        </div>
        <div class="col-sm-1">
            <button type="button" class="quick btn btn-primary right" aria-expanded="fales">查詢</button>
        </div>
        <div class="col-sm-5" style="height:40px; line-height:60px;">
            <p class="text-muted" style="margin: 0;">ps. 送出查詢後選擇道親，即可快速填入表單。</p>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
        <table class="quick_table table-hover"></table>
    </div>
</div>
            
<input type="hidden" name="upid" value="" />
<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">姓名</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" name="name" placeholder=""> 
    </div>
    <label for="inputPassword3" class="col-sm-2 control-label">姓別</label>
    <div class="col-sm-4">
        <label class="radio-inline">
            <input type="radio" name="sex_type" value="male" checked> 乾
        </label>
        <label class="radio-inline">
            <input type="radio" name="sex_type" value="female"> 坤
        </label>
    </div>
</div>
                
<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">年次</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" name="year" placeholder="西元年"> 
    </div>
</div>
                
<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">室內電話</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" name="phone" placeholder=""> 
    </div>
    <label for="inputPassword3" class="col-sm-2 control-label">手機</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" name="mobile" placeholder="">
    </div>
</div>

<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">學歷</label>
    <div class="col-sm-4">
        <div class="edu dropdown">
            <input type="hidden" name="edu">
            <button class="btn btn-default dropdown-toggle" type="button" name="edu" data-toggle="dropdown" aria-expanded="true">
                選擇學歷
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                @foreach($edus as $item)
                <li role="presentation" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['word']}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <label for="inputPassword3" class="col-sm-2 control-label">職業</label>
    <div class="col-sm-4">
        <div class="skill dropdown">
            <input type="hidden" name="skill" value>
            <button class="btn btn-default dropdown-toggle" type="button" name="skill" data-toggle="dropdown" aria-expanded="true">
                選擇職業
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                @foreach($skills as $item)
                <li role="presentation" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['word']}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label" >詳細地址</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="addr" placeholder=""> 
    </div>                    
</div>

<div align="right">
    <button type="button" class="btn btn-primary right" name="add-user-btn" aria-expanded="fales" data-val="0">新增</button>
</div>