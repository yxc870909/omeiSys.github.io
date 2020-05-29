<div id="bk-bookssubscription">
	<!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        @foreach($tab as $item)
        <li role="presentation" class="{{$item['active']}}"><a href="#{{$item['id']}}" aria-controls="{{$item['id']}}" role="tab" data-toggle="tab">{{$item['title']}}</a></li>
        @endforeach
                        
        <div align="right">
            <a class="add_book_btn btn" data-toggle="modal" data-target="#Add_book"></a>
        </div>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        @foreach($tab as $item)
        <div role="tabpanel" class="tab-pane {{$item['active']}}" id="{{$item['id']}}">
            @if($item['id'] == 'set')
                @include('layouts.Tab_BooksSubscription_setbook')
            @elseif($item['id'] == 'add')
                @include('layouts.Tab_BooksSubscription_add')
            @elseif($item['id'] == 'count')
                @include('layouts.Tab_BooksSubscription_count')
            @elseif($item['id'] == 'distribute')
                @include('layouts.Tab_BooksSubscription_distribute')
            @endif
        </div>
        @endforeach
    </div>

    @include('layouts.Modal_BooksSubscription_setCount')
    @include('layouts.Modal_BooksSubscription_editStatus')
    @include('layouts.Modal_BooksSubscription_addbook')
    @include('layouts.Modal_BooksSubscription_editbook')
    @include('layouts.Modal_BooksSubscription_viewbook')
</div>