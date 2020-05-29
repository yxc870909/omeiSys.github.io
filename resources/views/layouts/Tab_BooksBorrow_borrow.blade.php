<div class="work-box" style="margin-top: 20px;">
    <form class="form-horizontal" name="doAddBorrow" role="form">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        
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
            <div class="col-md-5">
                <input type="hidden" name="scann_upid">
                <div class="input-group">
                    <input type="text" class="form-control" name="scann_search" placeholder="輸入領書人姓名或email">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="scann_search" type="button">搜尋</button>
                    </span>
                </div>
            </div>
            <div class="col-md-5">
                <input type="text" name="scann_number" value="" style="position: absolute;top: -2000px;left: -2000px;">
                <p class="scan_ready" style="color: #1db501;margin: 0;margin-top: 12px;display: none;">已蒐尋到會員資料，請掃描書籍條碼</p>
            </div>
        </div>

        <div class="form-group key_mode" style="display: none;">
            <div class="col-md-5">
                <input type="hidden" name="key_upid">
                <div class="input-group">
                    <input type="text" class="form-control" name="key_search" placeholder="輸入領書人姓名或email">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="key_search" type="button">搜尋</button>
                    </span>
                </div>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control" name="key_number" value="" placeholder="輸入書籍編號">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-primary right" name="key_input" aria-expanded="fales">輸入</button>
            </div>
        </div>
        
        <div class="group-data" style="display: none;">
            <table class="table borrow_table">
                
            </table>
            <div align="right" style="margin-top: 20px;">
                <button type="button" class="save btn btn-primary right" aria-expanded="fales">送出</button>
            </div>
        </div>
        
    </form>
</div>