<div id="bk-temple">
	<div role="tabpanel">

	    <!-- Nav tabs -->
	    <ul class="nav nav-tabs" role="tablist">
	        
	        <li role="presentation" class="active"><a href="#list" aria-controls="list" role="tab" data-toggle="tab">搜尋</a></li>
	        
	        <div align="right">
	        	@if($btnShow)
	            <a class="add_temple_btn btn" data-toggle="modal" data-target="#add_temple"></a>
	            @endif
	        </div>
	    </ul>
	    
		<form action="/Temple" method="GET">
			<div class=" forom-horizontal search_bar">
		    	<div class="form-group">
		    		<div class="col-md-2 col-sm-2">
		    			<div class="area dropdown">
			                <input type="hidden" name="area" value="<?php if(@isset($_GET['area']))echo $_GET['area'];@endisset ?>" >
			                <button class="btn btn-default dropdown-toggle" type="button" name="area" data-toggle="dropdown" aria-expanded="true">
			                    {{$areas['word']}}
			                    <span class="caret"></span>
			                </button>
			                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			                	@foreach($areas['data'] as $item)                 
			                    <li role="presentation" class="{{$item['active']}}" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1">{{$item['word']}}</a></li>
			                    @endforeach
			                </ul>
			            </div>
		    		</div>

		    		<div class="col-md-2 col-sm-2">
			        	<div class="temple_name dropdown">
			                <input type="hidden" name="temple_name" value="<?php if(@isset($_GET['temple_name']))echo $_GET['temple_name'];@endisset ?>" >
			                <button class="btn btn-default dropdown-toggle" type="button" name="temple_name" data-toggle="dropdown" aria-expanded="true">
			                    {{$operating['word']}}
			                    <span class="caret"></span>
			                </button>
			                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			                	@foreach($operating['data'] as $item)                 
			                    <li role="presentation" class="{{$item['active']}}" data-val="{{$item['id']}}"><a role="menuitem" tabindex="-1">{{$item['name']}}壇</a></li>
			                    @endforeach
			                </ul>
			            </div>
			        </div>

			        <div class="col-md-2 col-sm-2">
			        	<div class="temple_type dropdown">
			                <input type="hidden" name="temple_type" value="<?php if(@isset($_GET['temple_type']))echo $_GET['temple_type'];@endisset ?>" >
			                <button class="btn btn-default dropdown-toggle" type="button" name="temple_type" data-toggle="dropdown" aria-expanded="true">
			                    {{$temple_types['word']}}
			                    <span class="caret"></span>
			                </button>
			                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			                	@foreach($temple_types['data'] as $item)                 
			                    <li role="presentation" class="{{$item['active']}}" data-val="{{$item['value']}}"><a role="menuitem" tabindex="-1">{{$item['word']}}</a></li>
			                    @endforeach
			                </ul>
			            </div>
			        </div>
			        		                
			        <div class="col-md-6 col-sm-6">
			            <div class="input-group">
			            	
						    <div class="search_type input-group-btn">
						    	<input type="hidden" name="search_type" value="<?php if(@isset($_GET['search_type']))echo $_GET['search_type'];@endisset ?>" >
						    	<input type="hidden" name="addr" value="" >
						        <button type="button" class="btn btn-default dropdown-toggle" name="search_type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						        	{{$optionType['word']}} 
						        	<span class="caret"></span>
						        </button>
						        <ul class="dropdown-menu">
						        	@foreach($optionType['data'] as $item)
						        	<li data-val="{{$item['value']}}"><a>{{$item['word']}}</a></li>
						        	@endforeach
						        </ul>
						    </div>

			                <input type="text" class="form-control" name="search_word" value="<?php if(@isset($_GET['search_word']))echo $_GET['search_word'];@endisset ?>" placeholder="" />
			                <span class="input-group-btn">
			                    <button class="btn btn-default" type="submit">搜尋</button>
			                </span>
			            </div>
			        </div>
		    	</div>
		    </div>
		</form>
	    
	    
	    
                
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="list">
            	
            	<div style="height:20px"></div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>名稱</th>
                            <th>區域</th>
                            <th>壇主姓名</th>
                            <th>電話</th>
                            <th>詳細地址</th>
                            <th></th>
                        </tr>
                    </thead>
                    @foreach($temples as $item)
                    <tr>
                        <th class="edit" data-tid="{{$item['id']}}">
                        @if($editShow || $item['show'])
                        <span class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="modal" data-target="#edit_temple"></span>
                        @endif
                        </th>
                        <th>{{$item['name']}}</th>
                        <th>{{$item['area']}}</th>
                        <th>{{$item['user_name']}}</th>
                        <th>{{$item['phone']}}</th>
                        <th>{{$item['addr']}}</th>
                        <th><a href="#" data-toggle="modal" data-target="#cls_view"></a></th>
                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>

    <nav aria-label="Page navigation" style="text-align: center;">
	  <ul class="pagination">
	    <li class="{{$Previous}}">
	      <a href="/Temple?page=1" aria-label="Previous">
	        <span aria-hidden="true">&laquo;</span>
	      </a>
	    </li>
	    @foreach($page as $item)
	    <li class="{{$item['active']}}"><a href="{{$item['link']}}">{{$item['count']}}</a></li>
	    @endforeach
	    <li class="{{$Next}}">
	      <a href="/Temple?page={{$pageCount}}" aria-label="Next">
	        <span aria-hidden="true">&raquo;</span>
	      </a>
	    </li>
	  </ul>
	</nav>

    @include('layouts.Modal_Temple_addtemple', array($areas, $temple_types))
    @include('layouts.Modal_Temple_edittemple', array($areas, $temple_types))
</div>