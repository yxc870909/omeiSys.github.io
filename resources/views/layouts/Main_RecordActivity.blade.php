<div id="bk-recordgroup">
    <ul class="nav nav-tabs" role="tablist">
        @foreach($tabs as $tab)
        <li role="presentation" class="{{$tab['active']}}"><a href="{{$tab['link']}}" aria-controls="{{$tab['val']}}" role="tab" data-toggle="tab">{{$tab['word']}}</a></li>
        @endforeach
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        @foreach($tabs as $item)
        <div role="tabpanel" class="tab-pane {{$item['active']}}" id="{{$item['val']}}">
            @if($item['val'] == 'agenda')
                @include('layouts.Tab_RecordActivity_agenda')
            @elseif($item['val'] == 'regist')
                @include('layouts.Tab_RecordActivity_regist')
            @endif
        </div>
        @endforeach 
    </div>


</div>
    