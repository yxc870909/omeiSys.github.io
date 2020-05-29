var bk_clsmanage = $('#bk-clsmanag');
var add_box = $('form[name="add-activity-box"]');
var center_add = $('form[name="add-centeractivity-box"]');

$(add_box).find('.input-group.date').datepicker({format: "yyyy年mm月dd日"});
$(center_add).find('.input-group.date').datepicker({format: "yyyy年mm月dd日"});

var tab_li = $(bk_clsmanage).find('.nav-tabs li'),
    addbtn = $(bk_clsmanage).find('.addbtn a');
    
$(addbtn).eq(0).css('display', 'block');
$(addbtn).eq(1).css('display', 'none');

$(tab_li).eq(0).on('click', function() {
    $(addbtn).eq(0).css('display', 'block');
    $(addbtn).eq(1).css('display', 'none');
});

$(tab_li).eq(1).on('click', function() {
    $(addbtn).eq(0).css('display', 'none');
    $(addbtn).eq(1).css('display', 'block');
});



rowHref(bk_clsmanage);
function rowHref(el) {
    $(el).find(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
}

//close
$(add_box).on('click','.close', function(){
    $(this).parent('p').remove();
    $(this).parent('th').parent('tr').remove();
});

ddl(add_box, 'type');
ddl(add_box, 'temple');
ddl(center_add, 'type');


add_workers(add_box,'preside');


$(add_box).find('.course').on('click', function() {
	learn(add_box, 'course_title', 'course_lecturer', 'course');
});
$(add_box).find('.song').on('click', function() {
	learn(add_box, 'song_title', 'song_lecturer', 'song');
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

                        if(list == 'course')
                            $(el).find('.error-course').text('');
                        if(list == 'song')
                            $(el).find('.error-song').text('');
                    }
                    else if(res=='more-fail') {
                        $(el).find('input[name="'+lecturer+'"]').parent('div').addClass('has-error');
                        alert('查到多筆同樣姓名，請以帳號搜尋使用者');
                    }
                    else if(res=='unfind') {
                        $(el).find('input[name="'+lecturer+'"]').parent('div').addClass('has-error');
                        alert('找不到該使用者');
                    }
                
                    console.log(res);
                },
            error: function(res) {
                    alert('系統忙碌中, 請稍候再試。');
                }
    	});
    }
}


//add activity save
$(add_box).find('.save').on('click', function() {

    var flag = true;
	var preside = Array(),
		course = Array(),
        song = Array(),
        course_title = Array(),
        song_title = Array();

    add_date = $(add_box).find('input[name="add_date"]').val();
    type = $(add_box).find('input[name="type"]').val();
    temple = $(add_box).find('input[name="temple"]').val();
	preside = getWorkers(add_box, "preside", preside);
	course_title = getWorkers_course_title(add_box, "course", course);
    course = getWorkers(add_box, "course", course);
    song_title = getWorkers_course_title(add_box, "song", song);
    song = getWorkers(add_box, "song", song);

    $(add_box).find('input[name="add_date"]').parent().parent().removeClass('has-error');
    $(add_box).find('.error-type').text('');
    $(add_box).find('.error-temple').text('');
    $(add_box).find('.error-preside').text('');
    $(add_box).find('.error-course').text('');
    $(add_box).find('.error-song').text('');

    if(!add_date > 0) {
        $(add_box).find('input[name="add_date"]').parent().parent().addClass('has-error');
        flag = false;
    }
    if(!temple > 0) {
        $(add_box).find('.error-temple').text('* 該欄位項目尚未選擇');
        flag = false;
    }
    if(!type > 0) {
        $(add_box).find('.error-type').text('* 該欄位項目尚未選擇');
        flag = false;
    }
    if(preside == '') {
        $(add_box).find('.error-preside').text('* 該欄位項目尚未新增辦事人員');
        flag = false;
    }
    if(course == '') {
        $(add_box).find('.error-course').text('* 該欄位項目尚未新增辦事人員');
        flag = false;
    }

    if(flag) {
        $.ajax({
            type : 'POST',
                url : '/doAddActivity',
                data : { 
                    _token : $(add_box).find('input[name="_token"]').val(),
                    add_date : add_date,
                    temple : temple,
                    type : type,
                    preside : preside,
                    course_title : course_title,
                    song_title : song_title,
                    course : course,
                    song : song,
                 },
                dataType:'json',
                success : function(res) {
                    if(res == 'success') {
                        alert('新增成功');
                        window.location.reload();
                    }
                    console.log(res);
                },
                error : function(res) {
                    document.write(res.responseText);
                    console.log(res);
                }
        });
    }
	
});


//add center activity save
$(center_add).find('.save').on('click', function() {

    var flag = true;
    add_date = $(center_add).find('input[name="add_date"]').val();
    type = $(center_add).find('input[name="type"]').val();

    $(center_add).find('input[name="add_date"]').parent().parent().removeClass('has-error');
    $(center_add).find('.error-type').text('');
    if(!add_date > 0) {
        $(center_add).find('input[name="add_date"]').parent().parent().addClass('has-error');
        flag = false;
    }
    if(!type > 0) {
        $(center_add).find('.error-type').text('* 該欄位項目尚未選擇');
        flag = false;
    }

    if(flag) {
        $.ajax({
            type : 'POST',
                url : '/doAddCenterActivity',
                data : { 
                    _token : $(center_add).find('input[name="_token"]').val(),
                    add_date : $(center_add).find('input[name="add_date"]').val(),
                    type : $(center_add).find('input[name="type"]').val(),
                 },
                dataType:'json',
                success : function(res) {
                    if(res == 'success') {
                        alert('新增成功');
                        window.location.reload();
                    }
                    console.log(res);
                },
                error : function(res) {
                    document.write(res.responseText);
                    console.log(res);
                }
        });
    }
    
});