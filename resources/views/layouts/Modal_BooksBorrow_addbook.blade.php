<div class="modal fade bs-example-modal-lg" id="Add_book" tabindex="-1" role="dialog" aria-labelledby="mymdallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dimdiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4>新增書籍</h4>
            </div>
            <div class="modal-body">
                

                <form class="form-horizontal" name="add_book" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label class="col-md-1">館藏地點</label>
                        <div class="col-md-8">
                            <div class="temple dropdown">
                                <input type="hidden" name="temple" value="" >
                                <button class="btn btn-default dropdown-toggle" type="button" name="temple" data-toggle="dropdown" aria-expanded="true">
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
                    </div>
                    
                    <hr>
                    <div class="panel panel-default col-md-6">
                        <div class="panel-body">                            
                            <div class="form-group">
                                <label class="col-md-4">是否借閱</label>
                                <div class="col-md-8">
                                    <input type="checkbox" name="is_borrow">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">* 櫃位編號</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="location" value="" placeholder="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">* 書名/刊名</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="book_name" value="" placeholder="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">* 數量</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="count" value="" placeholder="">
                                </div>
                            </div>



                            <div class="img-box">
                                <input type="text" name="fileName" value="" style="display: none;">
                                <input type="file" name="upload" id="upload" value="" style="display: none;">
                                <span class="icon-cancel-circle" style="display: none;"></span>
                                <label class="upload" for="upload">
                                    +
                                </label>
                                <img id="img" src="">
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-default col-md-6">
                        <div class="panel-body">
                            
                            <div class="form-group">
                                <label class="col-md-4">* 類別</label>
                                <div class="col-md-3">
                                    <div class="type dropdown">
                                        <input type="hidden" name="type" value="" >
                                        <button class="btn btn-default dropdown-toggle" type="button" name="type" data-toggle="dropdown" aria-expanded="true">
                                          請選擇
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            @foreach($book_type as $item)
                                             <li role="presentation" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['word']}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="error-type" style="color: red"></div> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">* 語文</label>
                                <div class="col-md-3">
                                    <div class="lan dropdown">
                                        <input type="hidden" name="lan" value="" >
                                        <button class="btn btn-default dropdown-toggle" type="button" name="lan" data-toggle="dropdown" aria-expanded="true">
                                          請選擇
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            @foreach($lans as $item)
                                             <li role="presentation" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1" href="#">{{$item['word']}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>                                    
                                </div>
                                <div class="col-md-5">
                                    <div class="error-lan" style="color: red"></div> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">作者/編者/譯者</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="author" value="" placeholder="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">ISBN</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="isbn" value="" placeholder="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">出版年</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="pub_year" value="" placeholder="西元年">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">版次</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="version" value="" placeholder="">
                                </div>
                            </div>
            
                            <div class="form-group">
                                <label class="col-md-4">卷/冊次</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="no" value="" placeholder="">
                                </div>
                            </div>
            
                            <div class="form-group">
                                <label class="col-md-4">價格</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="price" value="" placeholder="新台幣">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">* 購置時間</label>
                                <div class="col-md-8">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="buy_date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div align="right">
                        <button type="button" class="btn btn-primary right" name="save" aria-expanded="fales">送出</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>