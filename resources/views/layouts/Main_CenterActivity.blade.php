<div id="bk-centeractivity">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        @foreach($tabs as $item)
        <li role="presentation" class="{{$item['active']}}"><a href="#{{$item['id']}}" aria-controls="{{$item['id']}}" role="tab" data-toggle="tab">{{$item['title']}}</a></li>
        @endforeach
        <div align="right">
            @if($btnShow)
            <a class="add_activity_btn btn" data-toggle="modal" data-target="#Add_attend"></a>
            @endif
        </div>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        @foreach($tabs as $item)
            <div role="tabpanel" class="tab-pane {{$item['active']}}" id="{{$item['id']}}">
                @include('layouts.Tab_CenterActivity_searchlist')
            </div>
        @endforeach
    </div>

    @include('layouts.Modal_CenterActivity_addattend')
</div>