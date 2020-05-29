<div id="bk-personnel">
	<div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            @foreach($tabs as $item)
            <li role="presentation" class="{{$item['sel']}}"><a href="{{$item['link']}}" aria-controls="{{$item['val']}}" role="tab" data-toggle="tab">{{$item['word']}}</a></li>            
            @endforeach
            <div align="right">
                <a class="add_temple_btn btn" data-toggle="modal" data-target="#add_temple"></a>
            </div>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="list">@include('layouts.Tab_Personnel_searchlist', array($users))</div>
            <div role="tabpanel" class="tab-pane" id="registation">@include('layouts.Tab_Personnel_adduser', array($areas, $lunar_month, $lunar_day, $lunar_hour, $operating))</div>
            <div role="tabpanel" class="tab-pane" id="work">@include('layouts.Tab_Personnel_work', array($yearly,$areas, $groups))</div>
        </div>
    </div>

    @include('layouts.Modal_Personnel_view')
    @include('layouts.Modal_Personnel_edit')
    @include('layouts.Modal_Personnel_saveadduser')
    @include('layouts.Modal_Personnel_savework')
</div>