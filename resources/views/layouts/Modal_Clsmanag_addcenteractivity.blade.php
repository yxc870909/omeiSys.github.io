<div class="modal fade bs-example-modal-lg" id="Add_centeractivity" tabindex="-1" role="dialog" aria-labelledby="mymdallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dimdiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3>新增中心班程<h3/>
            </div>
            <div class="modal-body">
                
                <form class="form-horizontal" name="add-centeractivity-box" role="form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="inputEmail3">選擇日期</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" name="add_date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>                           
                        </div>
            
                        <div class="col-md-3">
                            <label>選擇班程</label>
                            <div class="type dropdown">
                                <input type="hidden" name="type" value="">
                                <button class="btn btn-default dropdown-toggle" type="button" name="type" data-toggle="dropdown" aria-expanded="true">
                                    選擇班程
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    @foreach($c_ddlActivity as $item)
                                    <li role="presentation" data-val="{{$item['id']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['title']}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="error-type" style="color: red;"></div>                              
                        </div> 
                    </div>
                    <hr> 
            
                    <div align="right" style="margin-top: 20px;">
                        <button type="button" class="save btn btn-primary right" aria-expanded="fales">新增班程</button>
                    </div>  
                </form>
            
            </div>
        </div>
    </div>
</div>