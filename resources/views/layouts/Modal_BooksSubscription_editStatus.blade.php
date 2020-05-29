<div class="modal fade bs-example-modal-md" id="edit_status" tabindex="-1" role="dialog" aria-labelledby="mymdallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dimdiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4>變更申請狀態</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" name="edit_status">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="sbid">
                    <input type="hidden" name="spid">
                    <label>地點 : </label>
                    <label name="temple"></label>

                    <div class="form-inline" style="float: right;">

                        <div class="col-md-2" style="padding: 0; margin-right: 30px;">
                            <div class="status dropdown">
                                <input type="hidden" name="status" value="" >
                                <button class="btn btn-default dropdown-toggle" type="button" name="status" data-toggle="dropdown" aria-expanded="true">
                                  
                                  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                     <li role="presentation" data-val="process"><a role="menuitem" tabindex="-1" href="#">處理中</a></li>
                                     <li role="presentation" data-val="finish"><a role="menuitem" tabindex="-1" href="#">已領取</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6" style="padding: 0; margin-right: 70px;">
                            <input type="hidden" name="upid">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="輸入領書人姓名或email">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" name="search" type="button">搜尋</button>
                                </span>
                            </div>
                        </div>

                    </div>

                    <hr>
                    <div class="form-group">
                        <div class="col-md-5">

                            <label>書名/刊名 : </label>
                            <label name="title"></label>

                            <div class="img-box" style="height: 100%;width: 100%;float: none;">
                                <img id="img" src="/img/solo3.png">
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-md-4">類別 : </label>
                                        <div class="col-md-8">
                                            <label name="cat"></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">語文 : </label>
                                        <div class="col-md-8">
                                            <label name="lan"></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">作者/編者/譯者 : </label>
                                        <div class="col-md-8">
                                            <label name="author"></label>
                                        </div>
                                    </div>
                    
                                    <div class="form-group">
                                        <label class="col-md-4">ISBN : </label>
                                        <div class="col-md-8">
                                            <label name="isbn"></label>
                                        </div>
                                    </div>
                    
                                    <div class="form-group">
                                        <label class="col-md-4">出版年 : </label>
                                        <div class="col-md-8">
                                            <label name="pub_year"></label>
                                        </div>
                                    </div>
                    
                                    <div class="form-group">
                                        <label class="col-md-4">版次 : </label>
                                        <div class="col-md-8">
                                            <label name="version"></label>
                                        </div>
                                    </div>
                    
                                    <div class="form-group">
                                        <label class="col-md-4">卷/冊次 : </label>
                                        <div class="col-md-8">
                                            <label name="no"></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>                    
    
                    <div align="right">
                        <button type="button" class="btn btn-success right" name="save" aria-expanded="fales">送出變更</button>
                    </div>
    
                </form>
            </div>
        </div>
    </div>
</div>