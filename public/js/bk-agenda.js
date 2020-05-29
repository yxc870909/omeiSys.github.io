var agenda = $('#bk-agenda');
var searchBar = agenda.find('.search_bar'),
    view_box = agenda.find('form[name="view-box"]'),
	worker_box = agenda.find('form[name="worker-box"]'),
	confirm_agenda = agenda.find('#confirm_agenda');

$(agenda).find('.input-group.date input[name="start"]').datepicker({format: "yyyy年mm月dd日"});
$(agenda).find('.input-group.date input[name="end"]').datepicker({format: "yyyy年mm月dd日"});
$(worker_box).find('.input-group.date').datepicker({format: "yyyy年mm月dd日"});


ddl(agenda, 'type');
ddl(worker_box, 'area');
ddl(worker_box, 'temple');
ddl(worker_box, 'edu');
ddl(worker_box, 'skill');
ddl(worker_box, 'mm');
ddl(worker_box, 'dd');
ddl(worker_box, 'hh');


//agenda view
$(agenda).find('.agenda_table tr').on('click', function() {

    var id = $(this).data('val');
    $.ajax({
        type : 'GET',
        url : '/doGetAgenda',
        data : { id : id },
        dataType:'json',
        success : function(res) {console.log(res);
            if(res.status == 'success') {
                $(view_box).find('.location').text(res.data.name);
                $(res.data.preside).each(function(i,val) {
                    $(view_box).find('.preside p').remove();
                    $(view_box).find('.preside').append('<p style="padding-left: 40px;">' + val + '</p>');
                });

                $(view_box).find('.course p').remove();
                $(res.data.course).each(function(i,val) {
                    $(view_box).find('.course').append('<p style="padding-left: 40px;">' + val + '</p>');
                });

                $(view_box).find('.song p').remove();
                $(res.data.song).each(function(i,val) {
                    $(view_box).find('.song').append('<p style="padding-left: 40px;">' + val + '</p>');
                });                
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});



//select area
$(worker_box).find('.area li').on('click', function() {
    var area = $(this).data('val');
    $.ajax({
         type : 'get',
        url : '/doGetTempleByArea',
        data : { area: area },
        dataType:'json',
        success : function(res) {            
            $(worker_box).find('.temple li').remove();
            $(res).each(function(i,val) {
                $(worker_box).find('.temple ul').append('<li role="presentation" data-val="'+val['id']+'"><a role="menuitem" tabindex="-1">'+val['name']+'壇</a></li>');
            });
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});


//close
p_close(worker_box);


add_workers(worker_box,'Dianchuanshi');
add_workers(worker_box,'Dianchuanshi2');
add_workers(worker_box,'upper');
add_workers(worker_box,'lowwer');
add_workers(worker_box,'action');
add_workers(worker_box,'preside');
add_workers(worker_box,'support');
add_workers(worker_box,'counseling');
add_workers(worker_box,'write');
add_workers(worker_box,'towel');
add_workers(worker_box,'music');
add_workers(worker_box,'service1');
add_workers(worker_box,'traffic');
add_workers(worker_box,'affairs');
add_workers(worker_box,'cooker');
add_workers(worker_box,'uplow');
add_workers(worker_box,'sambo');
add_workers(worker_box,'add');
add_workers(worker_box,'aegis');
add_workers(worker_box,'flower');
add_workers(worker_box,'accounting');

$(worker_box).find('.course').on('click', function() {
	learn(worker_box, 'course_title', 'course_lecturer', 'course');
});
$(worker_box).find('.song').on('click', function() {
	learn(worker_box, 'song_title', 'song_lecturer', 'song');
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
                        $(el).find('.'+list+'-list').append('<p data-upid="'+res.data.id+'">'+res.data.first_name+res.data.last_name+' - <a style="cursor: default; text-decoration:none;">'+cls_name+'</a><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>');
                        $(el).find('input[name="'+course+'"]').parent('div').addClass('has-success');

                        if(list == 'course')
                            $(worker_box).find('.error-course').text('');
                        if(list == 'song')
                            $(worker_box).find('.error-song').text('');
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

//redio change
$(worker_box).find('input[name="inDB"]').on('change', function(e) {
    var redio_val = '';
    $('input[name="inDB"]:checked').each(function () {
        redio_val = $(this).val() ;
    });
    
    if(redio_val == 'yes') {
        $(worker_box).find('.out-member').css('display','none');
        $(worker_box).find('.quickSearch_box').css('display','block');
    }
    else {
        $(worker_box).find('.out-member').css('display','block');
        $(worker_box).find('.quickSearch_box').css('display','none');
    }
});
//redio click
$(worker_box).find('input[name="inDB"]').on('click', function() {
	console.log($(this).val());
	if($(this).val() == 'no')
		$(worker_box).find('.quick_table tr').remove();
});

//quick search
$(worker_box).find('.quick').on('click',function(){
    $.ajax({
        type: 'POST',
        url: '/doShowUsers',
        data: {
        	_token : $(worker_box).find('input[name="_token"]').val(),
            search: $(worker_box).find('input[name="quickSearch"]').val(),
        },
        dataType: 'json',
        success: function(res) {
            if(res.status == 'success') {
                var close = '';
                //var close = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                
                $(worker_box).find('.quick_table tr').remove();
                for(var index in res.data) {
                    $(worker_box).find('.quick_table').append('<tr data-upid="'+res.data[index].id+'"><th style="cursor: pointer;">'+res.data[index].first_name+res.data[index].last_name+'/'+res.data[index].name+'/'+res.data[index].addr+'</th><th>'+close+'</th></tr>');
                }                
            }
            console.log(res);
        },
        error: function(res) {
            
        }
    });
});

//click user item
$(worker_box).find('.quick_table').delegate('tr','click',function(){

    $.ajax({
        type: 'POST',
        url: 'doGetUserData',
        data: {
        	_token : $(worker_box).find('input[name="_token"]').val(),
            upid: $(this).data('upid'),
        },
        dataType: 'json',
        success: function(res) {
            if(res.status == 'success') {
                $(worker_box).find('input[name="quickSearch"]').removeClass('has-error');
                $(worker_box).find('input[name="name"]').removeClass('has-error');
                $(worker_box).find('input[name="year"]').removeClass('has-error');
                $(worker_box).find('input[name="phone"]').removeClass('has-error');
                $(worker_box).find('input[name="mobile"]').removeClass('has-error');
                $(worker_box).find('input[name="addr"]').removeClass('has-error');
                
                $(worker_box).find('input[name="upid"]').val(res.data.id);
                $(worker_box).find('input[name="name"]').val(res.data.first_name+res.data.last_name);
                $(worker_box).find('input[name="year"]').val(res.data.year);
                $(worker_box).find('input[name="other_temple"]').val(res.data.name);
                $(worker_box).find('input[name="phone"]').val(res.data.phone);
                $(worker_box).find('input[name="mobile"]').val(res.data.mobile);
                $(worker_box).find('input[name="edu"]').val(res.data.edu);
                $(worker_box).find('button[name="edu"]').text(res.data.edu_word);
                $(worker_box).find('button[name="edu"]').append('<span class="caret"></span>');
                $(worker_box).find('input[name="skill"]').val(res.data.skill);
                $(worker_box).find('button[name="skill"]').text(res.data.skill_word);
                $(worker_box).find('button[name="skill"]').append('<span class="caret"></span>');
                $(worker_box).find('input[name="addr"]').val(res.data.addr);
            }
            else if(res == 'unfind') {
                $(worker_box).find('input[name="quickSearch"]').addClass('has-error');
                alert('找不到使用者');
            }
            console.log(res);
        },
        error: function(res) {
            
        }
    });
});

//search User
search_user(worker_box, "Introducer");
search_user(worker_box, "Guarantor");


//隱藏辦事選項
$('input[name="cls_type"]').change(function() {
    if($(this).val() == 'three') {
        $(worker_box).find('.worker').css('display', 'none');
        $(confirm_agenda).find('.worker').css('display', 'none');
    }
    else {
        $(worker_box).find('.worker').css('display', 'block');
        $(confirm_agenda).find('.worker').css('display', 'block');
    }
});

//增加人員row
$(worker_box).find('button[name="add-user-btn"]').on('click', function() {

	var name = $(worker_box).find('input[name="name"]').val(),
        gender = $(worker_box).find('input[name="sex_type"]:checked').val(),
        gender_val = $(worker_box).find('input[name="sex_type"]:checked').val(),
        Introducer = $(worker_box).find('input[name="Introducer"]').val(),
        I_upid = $(worker_box).find('input[name="Introducer"]').data('upid'),
        Guarantor = $(worker_box).find('input[name="Guarantor"]').val(),
        G_upid = $(worker_box).find('input[name="Guarantor"]').data('upid'),
        year = $(worker_box).find('input[name="year"]').val(),
        mobile = $(worker_box).find('input[name="mobile"]').val(),
        phone = $(worker_box).find('input[name="phone"]').val(),
        edu = $(worker_box).find('button[name="edu"]').text(),
        edu_val = $(worker_box).find('input[name="edu"]').val(),
        skill = $(worker_box).find('button[name="skill"]').text(),
        skill_val = $(worker_box).find('input[name="skill"]').val(),
        addr = $(worker_box).find('input[name="addr"]').val(),
        remark = $(worker_box).find('input[name="remark"]').val(),
        other_temple = $(worker_box).find('input[name="other_temple"]').val(),
        close = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    
    if(gender == 'male') gender = '乾';
    else if(gender == 'female') gender = '坤';
    else if(gender == 'boy') gender = '童';
    else if(gender == 'girl') gender = '女';

    $(worker_box).find('input[name="Introducer"]').parent().parent().removeClass('has-error');
    $(worker_box).find('input[name="Guarantor"]').parent().parent().removeClass('has-error');

    var flag = true;
    if(name == '') {
        $(worker_box).find('input[name="name"]').parent().addClass('has-error');
        flag = false;
    }
    if(!Introducer > 0) {
        $(worker_box).find('input[name="Introducer"]').parent().parent().addClass('has-error');
        flag = false;
    }
    if(!Guarantor > 0) {
        $(worker_box).find('input[name="Guarantor"]').parent().parent().addClass('has-error');
        flag = false;
    }
    if(phone == '' && mobile == '') {
        alert('手機、市話請擇一選填');
        flag = false;
    }
    if(year == '') {
        $(worker_box).find('input[name="year"]').parent().addClass('has-error');
        flag = false;
    }
    if(addr == '') {
        $(worker_box).find('input[name="addr"]').parent().addClass('has-error');
        flag = false;
    }

    if(flag) {
        $(worker_box).find('.table').append('<tr class="table_box"><th>'+name+'</th><th data-val="'+gender_val+'">'+gender+'</th><th data-upid="'+I_upid+'">'+Introducer+'</th><th data-upid="'+G_upid+'">'+Guarantor+'</th><th>'+year+'</th><th>'+mobile+'</th><th style="display: none;">'+phone+'</th><th data-val="'+edu_val+'">'+edu+'</th><th data-val="'+skill_val+'">'+skill+'</th><th>'+addr+'</th><th>'+remark+'</th><th style="display: none;">'+other_temple+'</th><th>'+close+'</th></tr>');
    }
});

//新增求到資料 save
$(worker_box).find('button[name="add-agenda-save"]').on('click', function() {
	
    var Introducer = Array(),
        Guarantor = Array();
    for(var i=0; i<$(worker_box).find('.table_box').length; i++) {
        Introducer[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(2).data('upid');
        Guarantor[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(3).data('upid');   
    }
    Introducer = getWorkers(worker_box, "Introducer", Introducer);
    Guarantor = getWorkers(worker_box, "Guarantor", Guarantor);

    var flag = true;
 	var Dianchuanshi = $(worker_box).find('.Dianchuanshi-list p').eq(0).text().split("×")[0],
 		Dianchuanshi2 = $(worker_box).find('.Dianchuanshi2-list p').eq(0).text().split("×")[0],
        upper = $(worker_box).find('.upper-list p').eq(0).text().split("×")[0],
        lowwer = $(worker_box).find('.lowwer-list p').eq(0).text().split("×")[0],
        uplow = $(worker_box).find('.uplow-list p').eq(0).text().split("×")[0],
        sambo = $(worker_box).find('.sambo-list p').eq(0).text().split("×")[0],
        add = $(worker_box).find('.add-list p').eq(0).text().split("×")[0],
        aegis = $(worker_box).find('.aegis-list p').eq(0).text().split("×")[0],
        flower = $(worker_box).find('.flower-list p').eq(0).text().split("×")[0];
    var action = Array(),
    	preside = Array(),
        support = Array(),
        counseling = Array(),
        write = Array(),        
        towel = Array(),
        music = Array(),
        translation = Array(),
        service1 = Array(),
        traffic = Array(),
        affairs = Array(),
        cooker = Array(),
        accounting = Array(),
        course = Array(),
        song = Array();    

    var tb = '',
    	location = $(worker_box).find('button[name="area"]').text() + ' ' +
    				$(worker_box).find('button[name="temple"]').text(),
    	cls_type = $(worker_box).find('input[name="cls_type"]:checked').val(),
    	date1 = $(worker_box).find('input[name="add_date"]').val(),
    	date2 = $(worker_box).find('input[name="yyy"]').val() + '年歲次' + 
    			$(worker_box).find('input[name="yy"]').val() + 
    			$(worker_box).find('button[name="mm"]').text() + 
    			$(worker_box).find('button[name="dd"]').text();

    preside = getWorkers_word(worker_box, "preside", preside, ', ');
    $(confirm_agenda).find('.Dianchuanshi').text('主班經理: ');
    $(confirm_agenda).find('.Dianchuanshi2').text('助班經理: ');
    $(confirm_agenda).find('.preside').text('操持: ');

    $(confirm_agenda).find('.location').text(location);
    $(confirm_agenda).find('.cls_type').append(cls_type=='one' ? '一天法會' : (cls_type=='recls' ? '複 習 班' : '三天法會'));
    $(confirm_agenda).find('.date1').text(date1);
    $(confirm_agenda).find('.date2').text(date2);
    $(confirm_agenda).find('.Dianchuanshi').append(Dianchuanshi);
    $(confirm_agenda).find('.Dianchuanshi2').append(Dianchuanshi2);
    $(confirm_agenda).find('.preside').append(preside);

    $(confirm_agenda).find('.table').eq(0).find('.table_box').remove();
    $(confirm_agenda).find('.table').eq(1).find('.table_box').remove();
    $(confirm_agenda).find('.table').eq(2).find('.table_box').remove();
    $(confirm_agenda).find('.table').eq(3).find('.table_box').remove();
    $(confirm_agenda).find('.table').eq(4).find('.table_box').remove();

    //授課
    course = getWorkers_word(worker_box, "course", course);
    song = getWorkers_word(worker_box, "song", song);
    tb = '<tr class="table_box"><th>'+sambo+'</th><th>'+course+'</th>><th>'+song+'</th></tr>';
    $(confirm_agenda).find('.table').eq(0).append(tb);
    //禮節
    action = getWorkers_word(worker_box, "action", action);
    support = getWorkers_word(worker_box, "support", support);
   	tb = '<tr class="table_box"><th>'+upper+'</th><th>'+lowwer+'</th><th>'+action+'</th><th>'+support+'</th></tr>';
    $(confirm_agenda).find('.table').eq(1).append(tb);
    //文書
    write = getWorkers_word(worker_box, "write", write);
    music = getWorkers_word(worker_box, "music", music);
    accounting = getWorkers_word(worker_box, "accounting", accounting);
    tb = '<tr class="table_box"><th>'+add+'</th><th>'+accounting+'</th><th>'+write+'</th><th>'+music+'</th></tr>';
    $(confirm_agenda).find('.table').eq(2).append(tb);
    //服務
    service1 = getWorkers_word(worker_box, "service1", service1);
    towel = getWorkers_word(worker_box, "towel", towel);
    tb = '<tr class="table_box"><th>'+service1+'</th><th>'+support+'</th><th>'+towel+'</th><th>'+uplow+'</th></tr>';
    $(confirm_agenda).find('.table').eq(3).append(tb);
    //後勤
    traffic = getWorkers_word(worker_box, "traffic", traffic);
    cooker = getWorkers_word(worker_box, "cooker", cooker);
    affairs = getWorkers_word(worker_box, "affairs", affairs);
    tb = '<tr class="table_box"><th>'+traffic+'</th><th>'+cooker+'</th><th>'+aegis+'</th><th>'+affairs+'</th><th>'+flower+'</th></tr>';
    $(confirm_agenda).find('.table').eq(4).append(tb);

    //regitster
    $(confirm_agenda).find('.joiner .table thead').remove();
    $(confirm_agenda).find('.joiner .table tr').remove();
    var tableHtml = $(worker_box).find('.table').html();
    $(confirm_agenda).find('.joiner .table').append(tableHtml);

    if(cls_type != 'three') {
        if(!Dianchuanshi > 0) {
            $(worker_box).find('.error-Dianchuanshi').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!upper > 0) {
            $(worker_box).find('.error-upper').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!lowwer > 0) {
            $(worker_box).find('.error-lowwer').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(action == '') {
            $(worker_box).find('.error-action').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(preside == '') {
            $(worker_box).find('.error-preside').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(support == '') {
            $(worker_box).find('.error-support').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(write == '') {
            $(worker_box).find('.error-write').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(towel == '') {
            $(worker_box).find('.error-towel').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(music == '') {
            $(worker_box).find('.error-music').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(service1 == '') {
            $(worker_box).find('.error-service1').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(cooker == '') {
            $(worker_box).find('.error-cooker').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!uplow > 0) {
            $(worker_box).find('.error-uplow').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!sambo > 0) {
            $(worker_box).find('.error-sambo').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!add > 0) {
            $(worker_box).find('.error-add').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(accounting == '') {
            $(worker_box).find('.error-accounting').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(course == '') {
            $(worker_box).find('.error-course').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(song == '') {
            $(worker_box).find('.error-song').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
    }
    

    if(!flag) {
        $(confirm_agenda).modal('toggle');
        $(confirm_agenda).modal('hide');
    }

});

//新增求到資料 confirm save
$(confirm_agenda).find('.save').on('click', function() {

    var Dianchuanshi = $(worker_box).find('.Dianchuanshi-list p').eq(0).data('upid'),
 		Dianchuanshi2 = $(worker_box).find('.Dianchuanshi2-list p').eq(0).data('upid'),
        upper = $(worker_box).find('.upper-list p').eq(0).data('upid'),
        lowwer = $(worker_box).find('.lowwer-list p').eq(0).data('upid'),
        uplow = $(worker_box).find('.uplow-list p').eq(0).data('upid'),
        sambo = $(worker_box).find('.sambo-list p').eq(0).data('upid'),
        add = $(worker_box).find('.add-list p').eq(0).data('upid'),
        aegis = $(worker_box).find('.aegis-list p').eq(0).data('upid'),
        flower = $(worker_box).find('.flower-list p').eq(0).data('upid');

    var action = Array(),
    	preside = Array(),
        support = Array(),
        counseling = Array(),
        write = Array(),        
        towel = Array(),
        music = Array(),
        service1 = Array(),
        traffic = Array(),
        affairs = Array(),
        cooker = Array(),
        accounting = Array(),
        course = Array(),
        song = Array(),
        Introducer = Array(),
        Guarantor = Array();

        action = getWorkers(worker_box, "action", action);
        preside = getWorkers(worker_box, "preside", preside);
        support = getWorkers(worker_box, "support", support);
        counseling = getWorkers(worker_box, "counseling", counseling);
        write = getWorkers(worker_box, "write", write);
        towel = getWorkers(worker_box, "towel", towel);
        music = getWorkers(worker_box, "music", music);
        service1 = getWorkers(worker_box, "service1", service1);
        traffic = getWorkers(worker_box, "traffic", traffic);
        affairs = getWorkers(worker_box, "affairs", affairs);
        cooker = getWorkers(worker_box, "cooker", cooker);
        accounting = getWorkers(worker_box, "accounting", accounting);
        course_title = getWorkers_course_title(worker_box, "course", course);
        course = getWorkers(worker_box, "course", course);
        song_title = getWorkers_course_title(worker_box, "song", song);
        song = getWorkers(worker_box, "song", song);

    var name = Array(),
        gender = Array(),
        year = Array(),
        mobile = Array(),
        phone = Array(),
        edu = Array(),
        skill = Array(),
        addr = Array(),
        remark = Array();

    for(var i=0; i<$(worker_box).find('.table_box').length; i++) {
        name[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(0).text();
        gender[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(1).data('val');
        Introducer[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(2).data('upid');
        Guarantor[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(3).data('upid');
        year[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(4).text();
        mobile[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(5).text();
        phone[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(6).text();
        edu[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(7).data('val');
        skill[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(8).data('val');
        addr[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(9).text();
        remark[i] = $(worker_box).find('.table_box').eq(i).find('th').eq(10).text();
    }

    if($(worker_box).find('.table_box').length > 0) {
        $.ajax({
            type : 'POST',
            url : '/doAddAgenda',
            data : {
                    _token : $(worker_box).find('input[name="_token"]').val(),
                    area: $(worker_box).find('input[name="area"]').val(),
                    tid: $(worker_box).find('input[name="temple"]').val(),
                    cls_type: $(worker_box).find('input[name="cls_type"]:checked').val(),
                    Dianchuanshi: Dianchuanshi,
                    Dianchuanshi2: Dianchuanshi2,
                    add_date: $(worker_box).find('input[name="add_date"]').val(),
                    yyy: $(worker_box).find('input[name="yyy"]').val(),
                    yy: $(worker_box).find('input[name="yy"]').val(),
                    mm: $(worker_box).find('input[name="mm"]').val(),
                    dd: $(worker_box).find('input[name="dd"]').val(),
                    upper: upper,
                    lowwer: lowwer,
                    action: action,
                    preside: preside,
                    support: support,
                    counseling: counseling,
                    write: write,                
                    towel: towel,                
                    music: music,
                    service1: service1,
                    traffic: traffic,
                    affairs: affairs,
                    cooker: cooker,
                    accounting: accounting,
                    course_title: course_title,
                    course: course,
                    song_title: song_title,
                    song: song,

                    sambo: sambo,
                    uplow: uplow,
                    add: add,
                    aegis: aegis,
                    flower: flower,

                    inDB: $(worker_box).find('input[name="inDB"]:checked').val(),
                    app: $(worker_box).find('input[name="app"]:checked').val(),
                    name: name,
                    gender: gender,
                    Introducer: Introducer,
                    Guarantor: Guarantor,
                    year: year,
                    other_temple: $(worker_box).find('input[name="other_temple"]').val(),
                    mobile: mobile,
                    phone: phone,
                    edu: edu,
                    skill: skill,   
                    addr: addr,
                    remark: remark
            },
            dataType:'json',
            success : function(res) {
                if(res=='success'){
                    alert('新增成功');
                    window.location.reload();
                }
                else {
                    if('area' in res) 
                        $(worker_box).find('.error-area').text('* 該欄位項目尚未選擇');
                    if('tid' in res) 
                        $(worker_box).find('.error-temple').text('* 該欄位項目尚未選擇');
                    if('add_date' in res || 'yyy' in res || 'yy' in res || 'mm' in res || 'dd' in res || 'hh' in res) 
                        $(worker_box).find('.error-time').text('* 開班時間尚有未選擇項目');
                    if('Dianchuanshi' in res) 
                        $(worker_box).find('.error-Dianchuanshi').text(res.Dianchuanshi);
                    if('upper' in res) 
                        $(worker_box).find('.error-upper').text(res.upper);
                    if('lowwer' in res) 
                        $(worker_box).find('.error-lowwer').text(res.lowwer);
                    if('action' in res) 
                        $(worker_box).find('.error-action').text(res.action);
                    if('preside' in res) 
                        $(worker_box).find('.error-preside').text(res.preside);
                    if('support' in res) 
                        $(worker_box).find('.error-support').text(res.support);
                    if('write' in res) 
                        $(worker_box).find('.error-write').text(res.write);
                    if('towel' in res) 
                        $(worker_box).find('.error-towel').text(res.towel);
                    if('music' in res) 
                        $(worker_box).find('.error-music').text(res.music);
                    if('service1' in res) 
                        $(worker_box).find('.error-service1').text(res.service1);
                    if('cooker' in res) 
                        $(worker_box).find('.error-cooker').text(res.cooker);
                    if('uplow' in res) 
                        $(worker_box).find('.error-uplow').text(res.uplow);
                    if('sambo' in res) 
                        $(worker_box).find('.error-sambo').text(res.sambo);
                    if('add' in res) 
                        $(worker_box).find('.error-add').text(res.add);                                  
                    if('accounting' in res) 
                        $(worker_box).find('.error-accounting').text(res.accounting);

                    alert('尚有欄位未填妥');
                }
                console.log(res);
            },
            error : function(res) {
                document.write(res.responseText);
                console.log(res);
            }
        });
    }
    else
        alert('掛號人員最少一人');
	
});