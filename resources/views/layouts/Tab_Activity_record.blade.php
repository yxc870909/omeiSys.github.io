<div style="height:20px"></div>
<div class="panel-group" id="Details" role="tablist" aria-multiselectable="true">
    @foreach($data as $d)
    @if($d['type'] == $item['title'])
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#temple" href="#{{$d['id']}}_" aria-expanded="false" aria-controls="@{{href}}">
                    {{$d['add_date']}}
                </a>
             </h4>
        </div>
        <div id="{{$d['id']}}_" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                
                <label for="inputEmail3" class="col-sm-12" >操持：</label>
                <p style="padding-left: 40px;">
                    @foreach($d['preside'] as $a) {{$a['name']}}、@endforeach
                </p>
                <label for="inputEmail3" class="col-sm-12" >聖歌：</label>
                @for($i=0; $i<count($d['course_title']); $i++)
                <p style="padding-left: 40px;">
                    {{$d['song_lecturer'][$i]['name']}}&nbsp;-&nbsp;{{$d['song_title'][$i]}}
                </p>
                @endfor
                <label for="inputEmail3" class="col-sm-12" >課程：</label>

                @for($i=0; $i<count($d['song_title']); $i++)
                <p style="padding-left: 40px;">
                    {{$d['course_lecturer'][$i]['name']}}&nbsp;-&nbsp;{{$d['course_title'][$i]}}
                </p>
                @endfor

            </div>
        </div>
    </div>
    @endif
    @endforeach

</div>