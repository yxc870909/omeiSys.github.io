<div style="height:20px"></div>
<div class="panel-group" id="Details" role="tablist" aria-multiselectable="true">
    @foreach($data as $item)
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#temple" href="#{{$item['id']}}" aria-expanded="false" aria-controls="@{{href}}">
                    {{$item['add_date']}}
                </a>
                <button type="button" class="close" data-dismiss="modal" data-id="{{$item['id']}}"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
             </h4>
        </div>
        <div id="{{$item['id']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                @include('layouts.Tab_ClsDetail_searchlist_content', array($item))
            </div>
        </div>
    </div>
    @endforeach

</div>