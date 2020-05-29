<label class="col-sm-12" >操持：</label>
<p style="padding-left: 40px;">
	@foreach($item['preside'] as $a) {{$a['name']}}、@endforeach
</p>
<label class="col-sm-12" >聖歌：</label>
@for($i=0; $i<count($item['song_title']); $i++)
<p style="padding-left: 40px;">
	{{$item['song_lecturer'][$i]['name']}}&nbsp;-&nbsp;{{$item['song_title'][$i]}}
</p>
@endfor
<label class="col-sm-12" >課程：</label>

@for($i=0; $i<count($item['course_title']); $i++)
<p style="padding-left: 40px;">
	{{$item['course_lecturer'][$i]['name']}}&nbsp;-&nbsp;{{$item['course_title'][$i]}}
</p>
@endfor

<div class="form-group">
    <div class="col-md-12" align="right">
        <button type="button" class="edit btn btn-primary right" data-id="{{$item['id']}}" aria-expanded="fales"  data-toggle="modal" data-target="#Edit_activity">編輯資料</button>
    </div>
</div>