<div class="modal fade bs-example-modal-lg" id="Add_activity" tabindex="-1" role="dialog" aria-labelledby="mymdallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dimdiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3>新增班程<h3/>
            </div>
            <div class="modal-body">
                
                <form class="form-horizontal" name="add-activity-box" role="form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="inputEmail3">選擇日期</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" name="add_date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>                  
                        </div>
            
                        <div class="col-md-2">
                            <label>選擇班程</label>
                            <div class="type dropdown">
                                <input type="hidden" name="type" value="">
                                <button class="btn btn-default dropdown-toggle" type="button" name="type" data-toggle="dropdown" aria-expanded="true">
                                    選擇班程
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    @foreach($ddlActivity as $item)
                                    <li role="presentation" data-val="{{$item['id']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['title']}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="error-type" style="color: red;"></div>   
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
                    </div>
                    <hr> 

                    <div class="form-group">
                        <label class="col-md-2 control-label">操持</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="preside" placeholder="輸入姓名或email"> 
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="preside btn btn-primary right" aria-expanded="fales">新增</button>
                        </div>
                        <div class="preside-list col-md-5">
                        </div>
                        <div style="height: 35px;">
                            <div class="error-preside" style="color: red; margin-top: 15px;"></div>
                        </div>
                    </div>

                    <br>
            
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label class="col-md-2 control-label">聖歌</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="song_title" placeholder="ex: 仙佛\語寄\調寄"> 
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="song_lecturer" placeholder="輸入姓名或email"> 
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="song btn btn-primary right" aria-expanded="fales">新增</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <p class="col-md-6 control-label text-muted">ps. 輸入框內必須 有仙佛、語寄、調寄，以 \ 隔開</p>
                    </div>

                    <div class="form-group">
                        <div class="song-list col-md-offset-2 col-md-10">
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label class="col-md-2 control-label">課程</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="course_title" placeholder="輸入班程名稱"> 
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="course_lecturer" placeholder="輸入姓名或email"> 
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="course btn btn-primary right" aria-expanded="fales">新增</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-4">
                            <div class="error-course" style="color: red;"></div>
                        </div>
                        <div class="course-list col-md-offset-2 col-md-10">
                        </div>
                    </div>
            
                    <div align="right" style="margin-top: 20px;">
                        <button type="button" class="save btn btn-primary right" aria-expanded="fales">新增班程</button>
                    </div>  
                </form>
            
            </div>
        </div>
    </div>
</div>