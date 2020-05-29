<div id="bk-member">
    <div class="user-info">
        <form class="form-horizontal" name="doEditProfile" method="post" role="form" > 
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="upid" value="{{$upid}}">
            <div class="heading">            
                <h3>編輯個人資訊</h3>
                <div class="btn-group">
                    <a href="/Calendar" class="btn btn-link" style="font-size: 20px;">取消</a>
                    <button type="button" class="btn btn-link" name="save">確認</button>
                </div>
            </div>
            
            <hr>
        
            <h4>帳戶</h4>
            <hr>
            <div class="form-group">
                <label class="col-md-3 control-label">會員帳號</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="{{$data['uid']}}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">會員密碼</label>
                <div class="col-md-6">
                    <input class="form-control" type="password" placeholder="********" readonly>
                </div>
                <div class="col-md-1">
                    <a class="btn btn-default" data-toggle="modal" data-target="#PasswodReset" >更改</a>
                </div>                
            </div>
        

           
            <h4>基本資訊</h4>
            <hr>
            <div class="form-group">
                <label class="col-md-3 control-label">姓</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="{{$data['first_name']}}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">名</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="{{$data['last_name']}}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">市話</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="phone" value="{{$data['phone']}}" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">手機</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="mobile" value="{{$data['mobile']}}" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">年次</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="{{$data['year']}}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">學歷</label>
                <div class="col-md-6">
                    @for($i = 0; $i < Count($edus); $i++)
                    <label class="radio-inline">
                      <input type="radio" name="radio-edu" id="radio{{$i}}" value="{{$edus[$i]['value']}}" {{$edus[$i]['checked']}}> {{$edus[$i]['word']}}
                    </label>
                    @endfor
                </div>                                
            </div>

            <div class="form-group">                                
                <label class="col-md-3 control-label">職業</label>
                <div class="col-md-6">
                    @for($i = 0; $i < Count($skills); $i++)
                    <label class="radio-inline">
                      <input type="radio" name="radio-skill" id="radio{{$i}}" value="{{$skills[$i]['value']}}" {{$skills[$i]['checked']}}> {{$skills[$i]['word']}}
                    </label>
                    @endfor                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">父</label>
                <div class="col-md-6">
                    <label class="control-label">
                        <a href="" class="faimly_link" data-val="{{$data['father_id']}}" data-toggle="modal" data-target="#member_view" data-toggle="modal" data-target="#member_view" style="cursor: pointer;">{{$data['father']}}</a>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">母</label>
                <div class="col-md-6">
                    <label class="control-label">
                        <a href="" class="faimly_link" data-val="{{$data['mother_id']}}"  data-toggle="modal" data-target="#member_view" style="cursor: pointer;">{{$data['mother']}}</a>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">配偶</label>
                <div class="col-md-6">
                    <label class="control-label">
                        <a href="" class="faimly_link" data-val="{{$data['spouse_id']}}" data-toggle="modal" data-target="#member_view" style="cursor: pointer;">{{$data['spouse']}}</a>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">手足</label>
                <div class="col-md-6">
                    @foreach($data['brosis'] as $item)
                    <label class="control-label">
                        <a href="" class="faimly_link" data-val="{{$item['id']}}" data-toggle="modal" data-target="#member_view" style="cursor: pointer;">{{$item['word']}}</a>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">兒女</label>
                <div class="col-md-6">
                    @foreach($data['child'] as $item)
                    <label class="control-label">
                        <a href="" class="faimly_link" data-val="{{$item['id']}}" data-toggle="modal" data-target="#member_view" style="cursor: pointer;">{{$item['word']}}</a>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">親戚</label>
                <div class="col-md-6">
                    @foreach($data['relative'] as $item)
                    <label class="control-label">
                        <a href="" class="faimly_link" data-val="{{$item['id']}}" data-toggle="modal" data-target="#member_view" style="cursor: pointer;">{{$item['word']}}</a>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-9 control-label">
                    <a href="" name="edit_faimly" data-toggle="modal" data-target="#edit_faimly">編輯</a>
                </label>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">詳細地址</label>
                <div class="col-md-6">
                    <textarea class="form-control" rows="3" name="addr">{{$data['addr']}}</textarea>
                </div>
            </div>

            <h4>道場履歷</h4>
            <hr>
            <div class="form-group">
                <label class="col-md-3 control-label">所屬佛堂</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="{{$data['name']}}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">點傳師</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="{{$data['Dianchuanshi']}}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">引師</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="{{$data['Introducer']}}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">保師</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="{{$data['Guarantor']}}" readonly>
                </div>
            </div>

            

            <div class="form-group">
                <label class="col-md-3 control-label">天職</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="{{$data['work']}}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">立愿</label>
                <div class="col-md-6">
                    @for($i = 0; $i < Count($positions); $i++)
                    <label class="checkbox-inline">
                        <input type="checkbox" id="position{{$i+1}}" name="position[]" value="{{$positions[$i]['value']}}" {{$positions[$i]['checked']}}> {{$positions[$i]['word']}}
                    </label>
                    @endfor
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">組別</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="{{$data['groups']}}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">引師紀錄</label>
                <div class="col-md-6">
                    <label class="control-label">
                        <a href="/RecordIntroducer?upid={{$upid}}&year={{$year}}" class="" data-val="" style="cursor: pointer;">詳細資訊</a>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">保師紀錄</label>
                <div class="col-md-6">
                    <label class="control-label">
                        <a href="/RecordGuarantor?upid={{$upid}}&year={{$year}}" class="" data-val="" style="cursor: pointer;">詳細資訊</a>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">法會參班紀錄</label>
                <div class="col-md-6">
                    <label class="control-label">
                        <a href="/RecordAgenda?upid={{$upid}}&year={{$year}}" class="" data-val="" style="cursor: pointer;">詳細資訊</a>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">班程參班紀錄</label>
                <div class="col-md-6">
                    <label class="control-label">
                        <a href="/RecordJoin?upid={{$upid}}&year={{$year}}" class="" data-val="" style="cursor: pointer;">詳細資訊</a>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">團隊辦事紀錄</label>
                <div class="col-md-6">
                    <label class="control-label">
                        <a href="/RecorGroup?upid={{$upid}}" class="" data-val="" style="cursor: pointer;">詳細資訊</a>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">辦事紀錄</label>
                <div class="col-md-6">
                    <label class="control-label">
                        <a href="/RecordActivity?upid={{$upid}}&year={{$year}}" class="" data-val="" style="cursor: pointer;">詳細資訊</a>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">授課紀錄</label>
                <div class="col-md-6">
                    <label class="control-label">
                        <a href="/RecordTeatch?upid={{$upid}}&year={{$year}}" class="" data-val="" style="cursor: pointer;">詳細資訊</a>
                    </label>
                </div>
            </div>

        </form>
    </div>
    @include('layouts.Modal_Member_passwordreset')
    @include('layouts.Modal_Member_view')
    @include('layouts.Modal_Member_editfaimly')
</div>