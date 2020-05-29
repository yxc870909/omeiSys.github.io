<div class="add_attend modal fade bs-example-modal-lg" id="Count" tabindex="-1" role="dialog" aria-labelledby="mymdallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dimdiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3>書籍盤點<h3/>
            </div>
            <div class="modal-body">
                
                <form class="form-horizontal" name="count_book" role="form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="panel-group" id="register" role="tablist" aria-multiselectable="true">
                        <input type="text" name="scann_number" style="position: absolute;top: -2000px;left: -2000px;">

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="mode dropdown">
                                    <input type="hidden" name="mode" value="" >
                                    <button class="btn btn-default dropdown-toggle" type="button" name="mode" data-toggle="dropdown" aria-expanded="true">
                                      選擇模式
                                      <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="presentation" data-val="scann"><a role="menuitem" tabindex="-1" href="#">掃描模式</a></li>
                                        <li role="presentation" data-val="key"><a role="menuitem" tabindex="-1" href="#">輸入模式</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-group scann_mode" style="display: none;">
                            <div class="col-md-2">
                                <div class="scann_temple dropdown">
                                    <input type="hidden" name="scann_temple" value="" >
                                    <button class="btn btn-default dropdown-toggle" type="button" name="scann_temple" data-toggle="dropdown" aria-expanded="true">
                                      選擇佛堂
                                      <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        @foreach($bookStore as $item)
                                         <li role="presentation" data-val="{{$item['id']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['name']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="error-temple" style="color: red"></div> 
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="scann_location" placeholder="輸入櫃位編號">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary right" name="scann_ready" aria-expanded="fales">確定</button>
                            </div>
                        </div>

                        <div class="form-group key_mode" style="display: none;">
                            <div class="col-md-2">
                                <div class="key_temple dropdown">
                                    <input type="hidden" name="key_temple" value="" >
                                    <button class="btn btn-default dropdown-toggle" type="button" name="key_temple" data-toggle="dropdown" aria-expanded="true">
                                      選擇佛堂
                                      <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        @foreach($bookStore as $item)
                                         <li role="presentation" data-val="{{$item['id']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['name']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="error-temple" style="color: red"></div> 
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="key_location" placeholder="輸入櫃位編號">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="key_number" placeholder="輸入書籍編號">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary right" name="key_ready" aria-expanded="fales">盤點</button>
                            </div>
                        </div>

                        <hr> 
                        <center class="info-txt">
                            <div class="ready" style="text-align: center; display: none;"><p class="bg-info">請掃描書籍條碼</p></div>
                            <div class="error" style="text-align: center;  display: none;"><p class="bg-danger">該書籍不屬於此櫃位</p></div>
                        </center>

                        <table class="table">
                        </table>
                                    
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</div>