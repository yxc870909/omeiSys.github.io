<!doctype html>
<!--[if IE 8]> <html class="ie8" lang="zh-TW"> <![endif]-->
<!--[if gt IE 8]> <![endif]-->
<html lang="zh-TW">

<head>
    @include('layouts.meta')    
    @include('layouts.link')
    <title>登入</title>    
</head>
<body>
	<div style="height:100px"></div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
			@include('layouts.register')		
		</div>	
	</div>

	@include('layouts.bootstrapStrip');
	<script type="text/javascript" src="/js/register.js"></script>
</body>