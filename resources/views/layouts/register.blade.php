<div id="register">
    <h2>Step1: 輸入您的帳號密碼</h2>
    <hr>
    <form name="rigister_box">
    	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="form-group string required">
            <label class="string required col-sm-2 control-label" for="account">
                <addr class="required">*</addr> 帳號
            </label>
            <input type="text" class="string required form-control" id="account" name="account" placeholder="">
            <div class="error-account" style="color: red"></div>
        </div>

        <div class="form-group string required">
            <label class="string required col-sm-2 control-label" for="password">
                <addr class="required">*</addr> 密碼
            </label>
            <input type="password" class="string required form-control" id="password" name="password" placeholder="">
            <div class="error-password" style="color: red"></div>
        </div>

        <div class="form-group string required">
            <label class="string required col-sm-2 control-label" for="confirm">
                <addr class="required">*</addr> 確認密碼
            </label>
            <input type="password" class="string required form-control" id="confirm" name="confirm" placeholder="">
            <div class="error-confirm" style="color: red"></div>
        </div>
        

        <h2>Step2: 請問您是?</h2>
        <hr>
        <br />
        <div class="row">
            <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="輸入姓名或手機">
                    <span class="input-group-btn">
                      <button class="search btn btn-default" type="button" >搜尋</button>
                    </span>
                 </div>
            </div>
        </div>
        <div class="error-upid" style="color: red"></div>

        <br />
        <table class="search_table table table-hover"></table>            
        <br />
        <input type="hidden" name="upid" />
        <div align="right">
            <h3 class="ask" style="display: none;">請問是 湖口區 王小明 前賢嗎?</h3>                        
            <div class="btn-group">
                <button type="button" class="btn btn-success register disabled" >是的，我要註冊</button>
            </div>                      
        </div>                                                      
    </form>
</div>