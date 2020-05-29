<!doctype html>
<!--[if IE 8]> <html class="ie8" lang="zh-TW"> <![endif]-->
<!--[if gt IE 8]> <![endif]-->
<html lang="zh-TW">

<head>
    @include('layouts.meta')    
    @include('layouts.link')
    <link rel="stylesheet" type="text/css" href="/css/sub-menu.css">
    <title>Login</title>    
</head>
<body>
	
	<div style="height:100px"></div>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div align="right">
				@include('layouts.account_head') / <a href="/logout">登出</a>
			</div>
        	<div style="height:10px"></div>

	        <div class="row">
	        	<div class="col-md-3">
	        		@include('layouts.menu')
	        	</div>
	        	<div class="col-md-9">
	        		<hr>
	        		<iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showCalendars=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=egaa37phgpr4p458bmga4vbg9g%40group.calendar.google.com&amp;color=%23182C57&amp;ctz=Asia%2FTaipei" style="border-width:0;" width="100%" height="700" frameborder="0" scrolling="no"></iframe>
	        	</div>
	        </div>
		</div>
	</div>


</body>