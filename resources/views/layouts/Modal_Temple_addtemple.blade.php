<!--add_temple-->
<div class="modal fade bs-example-modal-lg" id="add_temple" tabindex="-1" role="dialog" aria-labelledby="mymdallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dimdiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3>新增佛堂<h3/>
            </div>
            <div class="modal-body">                            
                <form class="form-horizontal" name="doAddTemple" role="form">

                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-2">
                            <label><addr class="required">*</addr> 佛壇性質</label>
                            <div class="temple_type dropdown">
                                <input type="hidden" name="temple_type" value="public" >
                                <button class="btn btn-default dropdown-toggle" type="button" name="temple_type" data-toggle="dropdown" aria-expanded="true">
                                  公共佛堂
                                  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                  @foreach($temple_types['data'] as $item) 
                                  <li role="presentation" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['word']}}</a></li>
                                  @endforeach
                                </ul>
                            </div>                                       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-2">
                            <label><addr class="required">*</addr> 佛堂名稱</label>
                            <input type="text" class="form-control" name="name" placeholder="ex: 啟賢">
                        </div> 
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-2">
                            <label><addr class="required">*</addr> 佛堂地址</label>
                        </div>
                        <div class="col-md-10 col-md-offset-2">
                            <div class="row">
                                <div class="area col-xs-2">
                                    <div class="area dropdown">
                                        <input type="hidden" name="area" value="" >
                                        <button class="btn btn-default dropdown-toggle" type="button" name="area" data-toggle="dropdown" aria-expanded="true">
                                          選擇區域
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                          @foreach($areas['data'] as $item)
                                          <li role="presentation" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['word']}}</a></li>
                                          @endforeach
                                        </ul>
                                    </div> 
                                </div>                                
                            </div>
                            <div class="error-area" style="color: red"></div> 
                        </div>

                        <div class="col-md-8 col-md-offset-2">
                            <textarea class="form-control" rows="3" name="addr" placeholder="詳細地址"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-2">
                            <label><addr class="required">*</addr> 電話</label>
                            <input type="text" class="form-control" name="phone" placeholder="">
                        </div>

                        <div class="col-md-4">
                            
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-2">
                            <label><addr class="required">*</addr> 壇主</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="main1" data-upid="" placeholder="輸入姓名或email">
                                        <span class="input-group-btn">
                                          <button class="main1 btn btn-primary" type="button" >新增</button>
                                        </span>
                                     </div>
                                </div>
                            </div>                            
                        </div>

                        <div class="main1-list col-md-4" style="margin-top: 25px;">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-2">
                            <div class="error-main1" style="color: red; margin-top: 15px; margin-top: 0;"></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                            <label><addr class="required">*</addr> 開壇日期</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="start_date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                            <label><addr class="required">*</addr> 歲次</label>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="yyy" placeholder="西元年">
                                </div>
                                <label  class="col-md-1 control-label" style="padding-left: 0; text-align: left;">年</label>
                                        
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="yy" placeholder="ex: 子丑">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                            <div class="row">                                
                                <div class="col-md-5 col-sm-5">
                                    <div class="mm dropdown">
                                        <input type="hidden" name="mm" value="" >
                                        <button class="btn btn-default dropdown-toggle" type="button" name="mm" data-toggle="dropdown" aria-expanded="true">
                                            農曆 - 月
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            @foreach($lunar_month as $item)
                                            <li role="presentation" data-val="{{$item}}"><a role="menuitem" tabindex="-1" href="#">{{$item}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>                                
                                </div>
                                            
                                <div class="col-md-3 col-sm-3">
                                    <div class="dd dropdown">
                                        <input type="hidden" name="dd" value="" >
                                        <button class="btn btn-default dropdown-toggle" type="button" name="dd" data-toggle="dropdown" aria-expanded="true">
                                            農曆 - 日
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            @foreach($lunar_day as $item)
                                            <li role="presentation" data-val="{{$item}}"><a role="menuitem" tabindex="-1" href="#">{{$item}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>                                
                                </div>
                            </div>
                            <div class="error-time" style="color: red"></div>
                        </div>                        
                    </div>

                    <div class="checkbox col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2">
                        <label>
                            是否為書籍存放處 
                            <input type="checkbox" name="bookstore" style="top: 6px;">
                        </label>
                    </div>

                    <div class="checkbox col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2">
                        <label>
                            是否有開壇訓
                            <input type="checkbox" name="training" style="top: 6px;">
                        </label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12" align="right">
                            <button type="button" class="btn btn-success right" name="saveAddTemple" aria-expanded="fales">新增佛堂</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>