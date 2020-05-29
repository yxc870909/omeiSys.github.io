<div style="height:20px"></div>

@foreach($areas as $area)
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed  open" data-id="{{$area['value']}}" data-toggle="collapse" data-parent="#temple" href="#{{$area['value']}}" aria-expanded="false" aria-controls="">
                {{$area['word']}}
            </a>
         </h4>
    </div>
    <div id="{{$area['value']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">

            <table class="count_table table table-hover">
            	@foreach($subBookCount as $book)
            	@if($area['value'] == $book->area)
                <tr data-toggle="modal" data-target="#edit_status" data-sbid="{{$book->sbid}}" data-spid="{{$book->spid}}">
                	<td style="font-size: 16px;">{{$book->attribute}}</td>
                	<td style="font-size: 16px;">{{$book->word}}</td>
                	<td style="font-size: 16px;">{{$book->title}}</td>
                	<td class="{{$book->color}}" style="font-size: 16px;">{{$book->status}}</td>
                	<td style="width: 20%;">
                		<input class="form-control" type="number" name="" value="{{$book->count}}" {{$book->disabled}}>
                	</td>
                </tr>
                @endif
                @endforeach
            </table>

        </div>
    </div>
</div>
@endforeach

<div align="right">
    <button type="button" class="btn btn-primary right" name="update_ap" aria-expanded="fales">送出</button>
</div>