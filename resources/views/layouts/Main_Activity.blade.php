<div id="bk-activity">
	<!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        @foreach($tab as $item)
        <li role="presentation" class="{{$item['active']}}"><a href="#{{$item['id']}}" aria-controls="{{$item['id']}}" role="tab" data-toggle="tab">{{$item['title']}}</a></li>
        @endforeach
                        
        <div align="right">
            @if($btnShow)
            <a class="add_attend_btn btn" data-toggle="modal" data-target="#Add_attend"></a>
            @endif
        </div>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        @if($id != null)
            @foreach($tab as $item)
            <div role="tabpanel" class="tab-pane {{$item['active']}}" id="{{$item['id']}}">@include('layouts.Tab_Activity_record')</div>
            @endforeach
        @else 
            @foreach($tab as $item)
            <div role="tabpanel" class="tab-pane {{$item['active']}}" id="{{$item['id']}}">
                @include('layouts.Tab_Activity_searchlist')
            </div>
            @endforeach
        @endif
    </div>

    @include('layouts.Modal_Activity_addattend')
</div>