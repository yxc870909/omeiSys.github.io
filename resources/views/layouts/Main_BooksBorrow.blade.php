<div id="bk-booksborrow">
	<!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        @foreach($tab as $item)
        <li role="presentation" class="{{$item['active']}}"><a href="#{{$item['id']}}" aria-controls="{{$item['id']}}" role="tab" data-toggle="tab">{{$item['title']}}</a></li>
        @endforeach
                        
        <div align="right">
            @if($btnShow)
            <a class="add_book_btn btn" data-toggle="modal" data-target="#Add_book"></a>
            @endif
        </div>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        @foreach($tab as $item)
        <div role="tabpanel" class="tab-pane {{$item['active']}}" id="{{$item['id']}}">
            @if($item['id'] == 'library')
                @include('layouts.Tab_BooksBorrow_library')
            @elseif($item['id'] == 'record')
                @include('layouts.Tab_BooksBorrow_record')
            @elseif($item['id'] == 'myrecord')
                @include('layouts.Tab_BooksBorrow_myrecord')
            @elseif($item['id'] == 'borrow')
                @include('layouts.Tab_BooksBorrow_borrow')
            @endif
        </div>
        @endforeach
    </div>

    @include('layouts.Modal_BooksBorrow_addbook')
    @include('layouts.Modal_BooksBorrow_editbook')
    @include('layouts.Modal_BooksBorrow_count')
    @include('layouts.Modal_BooksBorrow_viewbook')
    @include('layouts.Modal_BooksBorrow_editrecord')
</div>