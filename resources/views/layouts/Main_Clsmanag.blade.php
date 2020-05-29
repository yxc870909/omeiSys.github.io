<div id="bk-clsmanag">
	<!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        @foreach($tabs as $item)
        <li role="presentation" class="{{$item['sel']}}"><a href="{{$item['link']}}" aria-controls="{{$item['val']}}" role="tab" data-toggle="tab">{{$item['word']}}</a></li>
        @endforeach

        <!-- Modal btn -->
        <div class="addbtn" align="right">
            <a class="modal_btn btn" data-toggle="modal" data-target="#Add_activity"></a>
            <a class="modal_btn btn" data-toggle="modal" data-target="#Add_centeractivity"></a>
        </div>        
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        @foreach($tabs as $item)
        <div role="tabpanel" class="tab-pane {{$item['sel']}}" id="{{$item['val']}}">
            @if($item['val'] == 'cls')
                @include('layouts.Tab_Clsmanag_activity')
            @elseif($item['val'] == 'center')
                @include('layouts.Tab_Clsmanag_center')
            @endif
        </div>
        @endforeach 
    </div>

    @include('layouts.Modal_Clsmanag_addactivity')
    @include('layouts.Modal_Clsmanag_addcenteractivity')
</div>