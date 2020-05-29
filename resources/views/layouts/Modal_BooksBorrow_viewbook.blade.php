<div class="modal fade bs-example-modal-md" id="view_Borrowbook" tabindex="-1" role="dialog" aria-labelledby="mymdallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dimdiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4>書籍資訊</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" name="view_book">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="id">
                    <label>地點 : </label>
                    <label name="temple"></label>

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
                </form>
            </div>
        </div>
    </div>
</div>