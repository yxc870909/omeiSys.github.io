<div id="login">
    <form class="form-horizontal" action="/login" method="post" role="form" > 
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="panel panel-info">
            <div class="panel-heading"  align="center">峨眉書院道務資訊系統</div>
            <div class="panel-body">
                <div class="input-group">
                    <span class="input-group-addon">帳號</span>
                    <input type="text" class="form-control" name="account" placeholder="account">
                </div>
                @if($errors->has('account'))
                <div style="margin-left: 60px; color: red">{{$errors->first('account')}}</div>
                @else
                <br />
                @endif
                <div class="input-group">
                    <span class="input-group-addon">密碼</span>
                    <input type="password" class="form-control" name="password" placeholder="password">
                </div>
                @if($errors->has('password'))
                <div style="margin-left: 60px; color: red">{{$errors->first('password')}}</div>
                @else
                <br />
                @endif
                <div align="right">
                    <button type="submit" class="login btn btn-success right" aria-expanded="fales">登入</button>
                </div>
            </div>
        </div>

        <br />
        <div class="btn-group btn-group-justified" role="group" >
            <div class="btn-group">
                <a type="button" class="register btn btn-primary" href="/Register" aria-expanded="fales">註冊</a>
            </div>                
        </div>
    </form>
</div>