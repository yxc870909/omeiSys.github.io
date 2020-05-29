<div class="form-group">
    <label class="col-md-3 control-label">是否為峨眉道親</label>
    <div class="col-md-2">
        <label class="radio-inline">
            <input type="radio" name="inDB" value="yes" checked> 是
        </label>
        <label class="radio-inline">
            <input type="radio" name="inDB" value="no"> 否
        </label>
    </div>

    <label class="col-md-offset-1 col-md-2 control-label">是否為旁聽</label>
    <div class="col-md-2">
        <label class="radio-inline">
            <input type="radio" name="app" value="yes" checked> 是
        </label>
        <label class="radio-inline">
            <input type="radio" name="app" value="no"> 否
        </label>
    </div>
</div>
<hr />

<div class="quickSearch_box">
    <div class="form-group">
        <label class="col-md-2 control-label">快速查詢</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="quickSearch" placeholder="輸入道親姓名"> 
        </div>
        <div class="col-md-1">
            <button type="button" class="quick btn btn-primary right" aria-expanded="fales">查詢</button>
        </div>
        <div class="col-md-5" style="height:40px; line-height:60px;">
            <p class="text-muted" style="margin: 0;">ps. 送出查詢後選擇道親，即可快速填入表單。</p>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-2"></div>
    <div class="col-md-10">
        <table class="quick_table table-hover"></table>
    </div>
</div>
            
<input type="hidden" name="upid" value="" />
<div class="form-group">
    <label class="col-md-2 control-label">姓名</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="name" placeholder=""> 
    </div>
    <label class="col-md-2 control-label">姓別</label>
    <div class="col-md-4">
        <label class="radio-inline">
            <input type="radio" name="sex_type" value="male" checked> 乾
        </label>
        <label class="radio-inline">
            <input type="radio" name="sex_type" value="female"> 坤
        </label>
        <label class="radio-inline">
            <input type="radio" name="sex_type" value="boy" > 童
        </label>
        <label class="radio-inline">
            <input type="radio" name="sex_type" value="girl"> 女
        </label>
    </div>
</div>

<div class="form-group">
        <label class="col-md-2 control-label">引師</label>
        <div class="col-md-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" class="form-control" name="Introducer" data-upid="" placeholder="輸入姓名或email">
                        <span class="input-group-btn">
                            <button class="Introducer btn btn-default" type="button" >搜尋</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <label class="col-md-2 control-label">保師</label>
        <div class="col-md-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group">
                    <input type="text" class="form-control" name="Guarantor" data-upid="" placeholder="輸入姓名或email">
                    <span class="input-group-btn">
                        <button class="Guarantor btn btn-default" type="button" >搜尋</button>
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
<div class="form-group">
    <label class="col-md-2 control-label">年次</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="year" placeholder="西元年(ex:1981)"> 
    </div>
</div>

<div class="form-group out-member" style="display: none;">
    <label class="col-md-2 control-label">佛堂</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="other_temple" placeholder="輸入壇名 ex: 銘新壇"> 
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">室內電話</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="phone" placeholder=""> 
    </div>
    <label class="col-md-2 control-label">手機</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="mobile" placeholder="">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">學歷</label>
    <div class="col-md-4">
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
    <label class="col-md-2 control-label">職業</label>
    <div class="col-md-4">
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
    <label for="inputEmail3" class="col-md-2 control-label" >詳細地址</label>
    <div class="col-md-10">
        <input type="text" class="form-control" name="addr" placeholder=""> 
    </div>                    
</div>

<div class="form-group">
    <label for="inputEmail3" class="col-md-2 control-label" >備註</label>
    <div class="col-md-10">
        <input type="text" class="form-control" name="remark" placeholder=""> 
    </div>                    
</div>

<div align="right">
    <button type="button" class="btn btn-primary right" name="add-user-btn" aria-expanded="fales">新增</button>
</div> 