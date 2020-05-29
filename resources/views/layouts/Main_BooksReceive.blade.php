<div id="bk-booksreceive">
	<!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        @foreach($tab as $item)
        <li role="presentation" class="{{$item['active']}}"><a href="#{{$item['id']}}" aria-controls="{{$item['id']}}" role="tab" data-toggle="tab">{{$item['title']}}</a></li>
        @endforeach
                        
        <div align="right">
            <a class="add_attend_btn btn" data-toggle="modal" data-target="#Add_attend"></a>
        </div>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        @foreach($tab as $item)
        <div role="tabpanel" class="tab-pane {{$item['active']}}" id="{{$item['id']}}">
            @if($item['id'] == 'receive')
                @include('layouts.Tab_BooksReceive_receive')
            @elseif($item['id'] == 'record')
                @include('layouts.Tab_BooksReceive_record')
            @elseif($item['id'] == 'myrecord')
                @include('layouts.Tab_BooksReceive_myrecord')
            @endif
        </div>
        @endforeach
    </div>

    @include('layouts.Modal_BooksReceive_editbook')
    @include('layouts.Modal_BooksBorrow_count')
    @include('layouts.Modal_BooksReceive_viewbook') 
    @include('layouts.Modal_BooksReceive_editrecord')    
</div>