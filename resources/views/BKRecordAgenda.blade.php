<!doctype html>
<!--[if IE 8]> <html class="ie8" lang="zh-TW"> <![endif]-->
<!--[if gt IE 8]> <![endif]-->
<html lang="zh-TW">

<head>
    @include('layouts.meta')    
    @include('layouts.link')
    <link rel="stylesheet" type="text/css" href="/css/sub-menu.css">
    <link rel="stylesheet" type="text/css" href="/css/search_bar.css">
    <link rel="stylesheet" type="text/css" href="/fonts/icomoon/style.css">
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
	        		@include('layouts.Main_RecordAgenda')
	        	</div>
	        </div>
	        @include('layouts.footer')
		</div>
	</div>

	@include('layouts.bootstrapStrip')
	<script type="text/javascript" src="/js/bk-recordagenda.js" ></script>
</body>