<div class="modal fade" id="PasswodReset" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">變更密碼</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="doChangPsw" role="form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label class="col-md-3 control-label" name="aa">舊密碼</label>
                        <div class="col-md-6">
                            <input class="form-control" type="password" name="oldPsw" placeholder="" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">新密碼</label>
                        <div class="col-md-6">
                            <input class="form-control" type="password" name="newPsw" placeholder="" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">確認新密碼</label>
                        <div class="col-md-6">
                            <input class="form-control" type="password" name="confirmPsw" placeholder="" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                <button type="button" class="btn btn-primary" name="saveChangPsw">儲存變更</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->