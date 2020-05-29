var clsDeatil = $('#bk-clsdetail'),
	clsItem = clsDeatil.find('.panel');
var edit_box = clsDeatil.find('form[name="edit-activity-box"]');

$(edit_box).find('.input-group.date').datepicker({format: "yyyy-mm-dd"});

//close
$(edit_box).on('click','.close', function(){
    $(this).parent('p').remove();
    $(this).parent('th').parent('tr').remove();
});


ddl(edit_box, 'type');
//ddl function
function ddl(el, cls) {
	$(el).on('click','.'+cls+' li',function(){
        $(el).find('button[name="'+cls+'"]').text($(this).text());
        $(el).find('button[name="'+cls+'"]').append('<span class="caret"></span>');
        $(el).find('input[name="'+cls+'"]').val($(this).data('val'));
    });
}


add_workers(edit_box,'preside');

$(edit_box).find('.course').on('click', function() {
	learn(edit_box, 'course_title', 'course_lecturer', 'course');
});
$(edit_box).find('.song').on('click', function() {
	learn(edit_box, 'song_title', 'song_lecturer', 'song');
});
//帶課function
function learn(el,course,lecturer,list)
{
	if($(el).find('input[name="'+course+'"]').val() == '')
         $(el).find('input[name="'+course+'"]').parent('div').addClass('has-error');

    if($(el).find('input[name="'+lecturer+'"]').val() == '')
        $(el).find('input[name="'+lecturer+'"]').parent('div').addClass('has-error');

    if($(el).find('input[name="'+course+'"]').val() != '' && $(el).find('input[name="'+lecturer+'"]').val() != '')
    {
    	$.ajax({
    		type : 'POST',
            url : '/doSearchUser',
            data : {
            	_token : $(el).find('input[name="_token"]').val(),
                search: $(el).find('input[name="'+lecturer+'"]').val(),
            },
            dataType:'json',
            success : function(res) {
            	
                    if(res.status=='success') {
                        $(el).find('input[name="'+lecturer+'"]').parent('div').removeClass('has-error');
                        $(el).find('input[name="'+course+'"]').parent('div').removeClass('has-error');
                        
                        var cls_name = $(el).find('input[name="'+course+'"]').val();
                        $(el).find('input[name="'+lecturer+'"]').data('upid',res.data.id);
                        $(el).find('input[name="'+lecturer+'"]').val(res.data.first_name+res.data.last_name);
                        $(el).find('input[name="'+lecturer+'"]').parent('div').addClass('has-success');
                        $(el).find('.'+list+'-list').append('<p data-upid="'+res.data.id+'">'+res.data.first_name+res.data.last_name+' - <a style="cursor: default; text-decoration:none;">'+cls_name+'</a><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>');
                        $(el).find('input[name="'+course+'"]').parent('div').addClass('has-success');
                    }
                    else if(res=='more-fail') {
                        $(el).find('input[name="'+lecturer+'"]').parent('div').addClass('has-error');
                        alert('查到多筆同樣姓名，請以帳號搜尋使用者');
                    }
                    else if(res=='unfind') {
                        $(el).find('input[name="'+lecturer+'"]').parent('div').addClass('has-error');
                        alert('找不到該使用者');
                    }
                
                    // console.log(res);
                },
            error: function(res) {
                    alert('系統忙碌中, 請稍候再試。');
                }
    	});
    }
}

//刪除課程
$(clsItem).on('click', '.close', function() {
	
	if(confirm('確定要刪除該課程')) {
		$.ajax({
			type : 'DELETE',
	        url : '/doDelActivity',
	        data : { 
	        	_token : $(edit_box).find('input[name="_token"]').val(),
	        	id : $(this).data('id')
	         },
	        dataType:'json',
	        success : function(res) {
	        	if(res == 'success') {
	        		alert('刪除成功');
	        		window.location.reload();
	        	}
	        },
	        error : function(res) {
	        	document.write(res.responseText);
        		console.log(res);
	        }
		});
	}
});


//注入課程資料
$(clsDeatil).find('#Details .edit').on('click',function() {
	
	$.ajax({
		type : 'GET',
        url : '/doGetActivityData',
        data : { id : $(this).data('id') },
        dataType:'json',
        success : function(res) {
        	if(res.status == 'success') {

        		for(var obj_index in res.data) {

        			$(edit_box).data('id', res.data[0]['id']);
        			$(edit_box).find('input[name="add_date"]').val(res.data[0]['add_date']);
        			$(edit_box).find('button[name="type"]').text(res.data[0]['type']);
			        $(edit_box).find('button[name="type"]').append('<span class="caret"></span>');
			        $(edit_box).find('input[name="type"]').val(res.data[0]['typeID']);                                                                                        

        			//preside
        			$(edit_box).find('.preside-list p').remove();
        			for(var field_index in res.data[obj_index].song_title) {
        				upid = res.data[obj_index].song_lecturer[field_index]['id'];
        				preside = res.data[obj_index].preside[field_index]['name'];

        				$(edit_box).find('.preside-list').append('<p data-upid="'+upid+'">'+preside+'<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>');
        			}

        			//song
        			$(edit_box).find('.song-list p').remove();
        			for(var field_index in res.data[obj_index].song_title) {
        				upid = res.data[obj_index].song_lecturer[field_index]['id'];
        				song_lecturer = res.data[obj_index].song_lecturer[field_index]['name'];
        				song_title = res.data[obj_index].song_title[field_index];

        				$(edit_box).find('.song-list').append('<p data-upid="'+upid+'">'+song_lecturer+' - <a style="cursor: default; text-decoration:none;">'+song_title+'</a><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>');
        			}

        			//course
        			$(edit_box).find('.course-list p').remove();
        			for(var field_index in res.data[obj_index].course_title) {
        				upid = res.data[obj_index].course_lecturer[field_index]['id'];
        				course_lecturer = res.data[obj_index].course_lecturer[field_index]['name'];
        				course_title = res.data[obj_index].course_title[field_index];

        				$(edit_box).find('.course-list').append('<p data-upid="'+upid+'">'+course_lecturer+' - <a style="cursor: default; text-decoration:none;">'+course_title+'</a><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>');
        			}
        		}

        	}
        	console.log(res);
        },
        error : function(res) {
        	document.write(res.responseText);
        	console.log(res);
        }
	});
});

$(edit_box).find('.save').on('click', function() {
	
	var preside = Array(),
		course = Array(),
        song = Array(),
        course_title = Array(),
        song_title = Array();

	preside = getWorkers(edit_box, "preside", preside);
	course_title = getWorkers_course_title(edit_box, "course", course);
    course = getWorkers(edit_box, "course", course);
    song_title = getWorkers_course_title(edit_box, "song", song);
    song = getWorkers(edit_box, "song", song);

	$.ajax({
		type : 'POST',
        url : '/doUpdateActivityData',
        data : { 
        	_token : $(edit_box).find('input[name="_token"]').val(),
        	id : $(edit_box).data('id'),
        	add_date : $(edit_box).find('input[name="add_date"]').val(),
        	type : $(edit_box).find('input[name="type"]').val(),
        	preside : preside,
        	course_title : course_title,
        	song_title : song_title,
        	course : course,
        	song : song,
         },
        dataType:'json',
        success : function(res) {
        	if(res == 'success') {
        		alert('修改成功');
                window.location.reload();
        	}
        	// console.log(res);
        },
        error : function(res) {
        	document.write(res.responseText);
        	console.log(res);
        }
	});
});
