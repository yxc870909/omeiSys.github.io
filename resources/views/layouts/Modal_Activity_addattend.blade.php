<div class="add_attend modal fade bs-example-modal-lg" id="Add_attend" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3>新增出席<h3/>
            </div>
            <div class="modal-body">
                
                <form class="form-horizontal" name="attend-box" role="form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="panel-group" id="register" role="tablist" aria-multiselectable="true">
            
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="inputEmail3">選擇班程</label>
                                <div class="mm dropdown">
                                    <input type="hidden" name="mm" value="" >
                                    <button class="btn btn-default dropdown-toggle" type="button" name="mm" data-toggle="dropdown" aria-expanded="true">
                                        
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    </ul>
                                </div>                                
                            </div>
                        </div>
                        <hr> 
            
                        <label class="col-sm-12" >操持：</label>
                        <p class="preside" style="padding-left: 40px;">--</p>

                        <label class="col-sm-12" >聖歌：</label>
                        <div class="song" style="padding-left: 40px;"><p>--</p></div>
                        
                        <label class="col-sm-12" >課程：</label>
                        <div class="course" style="padding-left: 40px;"><p>--</p></div>
                                    
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#register" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                      新增班員
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">                                
                                    @include('layouts.Modal_Activity_addattend_joiner')                                
                                </div>
                            </div>
                        </div>
                        <hr />
                                    
                        <div class="form-group">
                            <div class="col-sm-12">                                
                                <h4>學員名單</h4>
                                <table class="table table-hover">                                 
                                </table>
                             </div>
                        </div>
                                    
                        <div style="height:10px"></div>
                        <div align="right">
                            <button type="button" class="save btn btn-primary right disabled" aria-expanded="fales">送出</button>
                        </div>
                                    
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</div>