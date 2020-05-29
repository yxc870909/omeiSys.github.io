<div id="bk-clsdetail">
	<!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#aa" aria-controls="aa" role="tab" data-toggle="tab">{{$tabTitle}}</a></li>
        
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="aa">@include('layouts.Tab_ClsDetail_searchlist')</div>
    </div>

    @include('layouts.Modal_ClsDetail_edit')
</div>
