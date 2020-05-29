<div id='bk-agenda'>
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
            <div role="tabpanel" class="tab-pane active" id="list">@include('layouts.Tab_Agenda_searchlist', array($users, $dispatch))</div>
            <div role="tabpanel" class="tab-pane" id="registation">@include('layouts.Tab_Agenda_addcls', array($areas, $operating, $edus, $skills))</div>
        </div>
    </div>

    @include('layouts.Modal_Agenda_view')
    @include('layouts.Modal_Agenda_saveadd')
</div>