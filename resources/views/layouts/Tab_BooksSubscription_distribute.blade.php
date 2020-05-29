<div style="height:20px"></div>

<form class="form-horizontal" name="book_distribute">
	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	@foreach($block_area as $area)
	{{$area['word']}}
	<hr style="margin-top: 0; margin-bottom: 10px;">
	@foreach($block_temple as $temple)
	@if($area['value'] == $temple['area'])
	<div class="panel panel-default" style="margin-bottom: 8px;">
	    <div class="panel-heading" role="tab" id="headingTwo">
	        <h4 class="panel-title">
	            <a class="collapsed  open" data-id="{{$temple['id']}}" data-toggle="collapse" data-parent="#temple" href="#{{$temple['id']}}" aria-expanded="false" aria-controls="">
	                {{$temple['name']}}
	            </a>
	         </h4>
	    </div>
	    <div id="{{$temple['id']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
	        <div class="panel-body">

	            <table class="table table-hover">
	            	@foreach($block_book as $book)
	            	@if($book->tid == $temple['id'])
	            	<tr data-spid="{{$book->spid}}" data-tid="{{$book->tid}}">
	            		<td style="font-size: 16px;">{{$book->attribute}}</td>
		            	<td style="font-size: 16px;">{{$book->word}}</td>
		            	<td style="font-size: 16px;">{{$book->title}}</td>
		            	<td style="width: 20%;">
		            		<div>
		            			<input class="form-control" type="number" name="count" value="{{$book->count}}" {{$book->disabled}}>
		            		</div>		            		
		            	</td>
		            	@if($book->disabled == '')
		            	<td style="max-width: 55px;">
		            		<button type="button" class="btn btn-primary right" name="tr_save" aria-expanded="fales">結案</button>
		            	</td>
		            	@endif
	            	</tr>
	            	@endif
	            	@endforeach
	            </table>

	        </div>
	    </div>
	</div>
	@endif
	@endforeach
	@endforeach
</form>

