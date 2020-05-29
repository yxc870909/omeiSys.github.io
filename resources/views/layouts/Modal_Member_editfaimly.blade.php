<div class="modal fade bs-example-modal-md" id="edit_faimly" tabindex="-1" role="dialog" aria-labelledby="mymdallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dimdiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3>家屬編輯<h3/>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" name="edit_faimly">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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

                    <div align="right">
                        <button type="button" class="btn btn-primary right" name="save" aria-expanded="fales">送出</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>