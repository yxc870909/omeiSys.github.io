<div class="modal fade bs-example-modal-md" id="personnel_edit" tabindex="-1" role="dialog" aria-labelledby="mymdallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-body">

                <form class="form-horizontal" name="personnel_edit">
                    
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="upid" value=""
                    @if($EditAuth)
                    <h4>權限管理</h4>
                    <hr>
                    <div class="form-group">
                        <label class="col-md-3 control-label">會員等級</label>
                        <div class="col-md-8 level">
                            
                        </div>  
                    </div>
                    @endif

                    <h4>基本資訊</h4>
                    <hr>
                    <div class="form-group">
                        <label class="col-md-3 control-label">姓</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="first_name" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">名</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="last_name" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">市話</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="phone" value="" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">手機</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="mobile" value="" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">年次</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="year" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">學歷</label>
                        <div class="col-md-6 edu">
                            
                        </div>                                
                    </div>

                    <div class="form-group">                                
                        <label class="col-md-3 control-label">職業</label>
                        <div class="col-md-6 skill">
                                               
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">父</label>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="father" data-upid="" placeholder="輸入姓名或email">
                                    <span class="input-group-btn">
                                        <button class="father btn btn-default" type="button" >搜尋</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">母</label>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="mother" data-upid="" placeholder="輸入姓名或email">
                                    <span class="input-group-btn">
                                        <button class="mother btn btn-default" type="button" >搜尋</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">配偶</label>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="spouse" data-upid="" placeholder="輸入姓名或email">
                                    <span class="input-group-btn">
                                        <button class="spouse btn btn-default" type="button" >搜尋</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">手足</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="brosis" placeholder="輸入姓名或email"> 
                        </div>
                        <div class="col-md-2" style="padding-left: 0;">
                            <button type="button" class="brosis btn btn-primary right" aria-expanded="fales">新增</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="brosis-list col-md-offset-3 col-md-9">
                        </div>
                        <div class="error-brosis col-md-offset-3 col-md-9" style="color: red;"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">兒女</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="child" placeholder="輸入姓名或email"> 
                        </div>
                        <div class="col-md-2" style="padding-left: 0;">
                            <button type="button" class="child btn btn-primary right" aria-expanded="fales">新增</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="child-list col-md-offset-3 col-md-9">
                        </div>
                        <div class="error-child col-md-offset-3 col-md-9" style="color: red;"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">親戚</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="relative" placeholder="輸入姓名或email"> 
                        </div>
                        <div class="col-md-2" style="padding-left: 0;">
                            <button type="button" class="relative btn btn-primary right" aria-expanded="fales">新增</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="relative-list col-md-offset-3 col-md-9">
                        </div>
                        <div class="error-relative col-md-offset-3 col-md-9" style="color: red;"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">詳細地址</label>
                        <div class="col-md-6">
                            <textarea class="form-control" rows="3" name="addr"></textarea>
                        </div>
                    </div>

                    <h4>道場履歷</h4>
                    <hr>
                    <div class="form-group">
                        <label class="col-md-3 control-label">所屬佛堂</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="temple" placeholder="" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">點傳師</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="Dianchuanshi" placeholder="" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">引師</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="Introducer" placeholder="" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">保師</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="Guarantor" placeholder="" readonly>
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label class="col-md-3 control-label">天職</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="work" placeholder="" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">立愿</label>
                        <div class="col-md-6 position">
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">組別</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="group" placeholder="" readonly>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" name="saveChange">儲存變更</button>
            </div>
        </div>
    </div>
</div>