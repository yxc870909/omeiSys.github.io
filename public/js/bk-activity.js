var bk_activity = $('#bk-activity');
var add_attend = bk_activity.find('form[name="attend-box"]');

var tabTxt = '';


addTabNameToddl(bk_activity , add_attend, 'mm');
getMonthDdl(add_attend, 'mm',false);

// getActivityContent(add_attend);
// getActivityUser(tabTxt);
$(bk_activity).find('.nav-tabs li').on('click', function() {
	
	// addTabNameToddl(bk_activity , add_attend, 'mm');	

	tabTxt = $(this).text();
	getMonthDdl(add_attend, 'mm',true);
	// getActivityContent(add_attend);
});

//取得最近兩個月課程之ddl
function getMonthDdl(el,cls, bool) {
	$.ajax({
		type: 'GET',
        url: '/dogetActivityLastTwoMonthData',
        data: { type : tabTxt },
        dataType: 'json',
        success: function(res) {
        	if(res.status == 'success') {
        		$(el).find('.mm li').remove();

        		$(el).find('input[name="'+cls+'"]').val(res.data[0].id);
        		// if(bool)
        		// 	$(el).find('button[name="'+cls+'"]').text(res.data[0].add_date+tabTxt);
        		// else
        		    $(el).find('button[name="'+cls+'"]').text("請選擇班程月份");
        		for(var index in res.data) {
        			var mon = res.data[index].add_date;
        			$(el).find('.mm ul').append('<li role="presentation" data-val="'+res.data[index].id+'"><a role="menuitem" tabindex="-1" href="#">'+mon+tabTxt+'</a></li>');
        		}
        	}
        	// console.log(res);
        },
        error: function(res) {
        	document.write(res.responseText);
        	console.log(res);
        }
	});
}

//依點選tab項目更新ddl
function addTabNameToddl(el, to,cls) {
	$(el).find('.nav-tabs li').each(function() {
		if($(this).hasClass('active')) {
			var first = $(to).find('.'+cls+' li').eq(0).data('val');
				tabTxt = $(this).text();
		}	
	});
}

//mm額外有function 所以獨立出來
$(add_attend).on('click','.mm li',function(){
    $(add_attend).find('button[name="mm"]').text($(this).text());
    $(add_attend).find('button[name="mm"]').append('<span class="caret"></span>');
    $(add_attend).find('input[name="mm"]').val($(this).data('val'));
    getActivityContent(add_attend);
});


ddl(add_attend, 'edu');
ddl(add_attend, 'skill');

//add attend注入內容
function getActivityContent(el)
{	
	$.ajax({
		type: 'GET',
        url: '/doGetLastActivityData',
        data: { 
        	id : $(el).find('input[name="mm"]').val(),
        },
        dataType: 'json',
        success: function(res) {console.log(res);
        	if(res.status == 'success') {
        		for(var obj_index in res.data) {

        			//preside
        			$(el).find('.preside').text('');
        			for(var field_index in res.data[obj_index].song_title) {
        				upid = res.data[obj_index].song_lecturer[field_index]['id'];
        				preside = res.data[obj_index].preside[field_index]['name'];

        				$(el).find('.preside').append('<p>'+preside+'</p>');
        			}

        			//song
        			$(el).find('.song p').remove();
        			for(var field_index in res.data[obj_index].song_title) {
        				upid = res.data[obj_index].song_lecturer[field_index]['id'];
        				song_lecturer = res.data[obj_index].song_lecturer[field_index]['name'];
        				song_title = res.data[obj_index].song_title[field_index];

        				$(el).find('.song').append('<p>'+song_lecturer+' - <a style="cursor: default; text-decoration:none;">'+song_title+'</a></p>');
        			}

        			//course
        			$(el).find('.course p').remove();
        			for(var field_index in res.data[obj_index].course_title) {
        				upid = res.data[obj_index].course_lecturer[field_index]['id'];
        				course_lecturer = res.data[obj_index].course_lecturer[field_index]['name'];
        				course_title = res.data[obj_index].course_title[field_index];

        				$(el).find('.course').append('<p>'+course_lecturer+' - <a style="cursor: default; text-decoration:none;">'+course_title+'</a></p>');
        			}
        		}
        		getActivityUser(tabTxt);
        	}
        	// console.log(res);
        },
        error: function(res) {
        	document.write(res.responseText);
        	console.log(res);
        }
	});
}

//取得該編號班程的學員名單
function getActivityUser(tabTxt)
{
	$.ajax({
		type: 'GET',
        url: '/doGetActivityUser',
        data: { 
        	type : tabTxt
        },
        dataType: 'json',
        success: function(res) {

        	$(add_attend).find('.table tr').remove();
        	for(var obj_index in res.data) {
        		$(add_attend).find('.table').append('<tr data-id="'+res.data[obj_index].id+'"><th><input type="checkbox" class="ckb"></th><th class="'+res.data[obj_index].gender+'">('+res.data[obj_index].count+'/'+res.data[obj_index].total+')'+res.data[obj_index].name+'</th><th>'+res.data[obj_index].addr+'</th><th><div class="'+res.data[obj_index].inDB+'"><span class="icon-checkmark"></span></div></th><th><button type="button" class="close" data-dismiss=""><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></th></tr>');
        	}
            $(add_attend).find('.save').removeClass('disabled');
        	// console.log(res.data);
        },
        error: function(res) {
        	document.write(res.responseText);
        	console.log(res);
        }
	});
}


//redio change
$(add_attend).find('input[name="inDB"]').on('change', function(e) {
    var redio_val = '';
    $('input[name="inDB"]:checked').each(function () {
        redio_val = $(this).val() ;
    });
    
    if(redio_val == 'yes') {
        $(add_attend).find('.out-member').css('display','none');
        $(add_attend).find('.quickSearch_box').css('display','block');
    }
    else {
        $(add_attend).find('.out-member').css('display','block');
        $(add_attend).find('.quickSearch_box').css('display','none');
    }
    $(add_attend).find('button[name="add-user-btn"]').data('val', 0);
});
//redio click
$(add_attend).find('input[name="inDB"]').on('click', function() {
	console.log($(this).val());
	if($(this).val() == 'no')
		$(add_attend).find('.quick_table tr').remove();
});

//quick search
$(add_attend).find('.quick').on('click',function(){
    $.ajax({
        type: 'POST',
        url: '/doShowUsers',
        data: {
        	_token : $(add_attend).find('input[name="_token"]').val(),
            search: $(add_attend).find('input[name="quickSearch"]').val(),
        },
        dataType: 'json',
        success: function(res) {
            if(res.status == 'success') {
                var close = '';
                //var close = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                
                $(add_attend).find('.quick_table tr').remove();
                for(var index in res.data) {
                    $(add_attend).find('.quick_table').append('<tr data-upid="'+res.data[index].id+'"><th style="cursor: pointer;">'+res.data[index].first_name+res.data[index].last_name+'&nbsp&nbsp('+res.data[index].addr+')</th><th>'+close+'</th></tr>');
                }
                
            }
            console.log(res);
        },
        error: function(res) {
            
        }
    });
});

//click user item
$(add_attend).find('.quick_table').delegate('tr','click',function(){

    $.ajax({
        type: 'POST',
        url: 'doGetUserData',
        data: {
        	_token : $(add_attend).find('input[name="_token"]').val(),
            upid: $(this).data('upid'),
        },
        dataType: 'json',
        success: function(res) {
            if(res.status == 'success') {
                $(add_attend).find('input[name="quickSearch"]').removeClass('has-error');
                $(add_attend).find('input[name="name"]').removeClass('has-error');
                $(add_attend).find('input[name="year"]').removeClass('has-error');
                $(add_attend).find('input[name="phone"]').removeClass('has-error');
                $(add_attend).find('input[name="mobile"]').removeClass('has-error');
                $(add_attend).find('input[name="addr"]').removeClass('has-error');
                
                $(add_attend).find('input[name="upid"]').val(res.data.id);
                $(add_attend).find('input[name="name"]').val(res.data.first_name+res.data.last_name);
                $(add_attend).find('input[name="year"]').val(res.data.year);
                $(add_attend).find('input[name="sex_type"][value="'+res.data.gender+'"]').attr('checked',true);
                $(add_attend).find('input[name="other_temple"]').val(res.data.name);
                $(add_attend).find('input[name="phone"]').val(res.data.phone);
                $(add_attend).find('input[name="mobile"]').val(res.data.mobile);
                $(add_attend).find('input[name="edu"]').val(res.data.edu);
                $(add_attend).find('button[name="edu"]').text(res.data.edu_word);
                $(add_attend).find('button[name="edu"]').append('<span class="caret"></span>');
                $(add_attend).find('input[name="skill"]').val(res.data.skill);
                $(add_attend).find('button[name="skill"]').text(res.data.skill_word);
                $(add_attend).find('button[name="skill"]').append('<span class="caret"></span>');
                $(add_attend).find('input[name="addr"]').val(res.data.addr);

                $(add_attend).find('button[name="add-user-btn"]').data('val', res.data.id);
            }
            else if(res == 'unfind') {
                $(add_attend).find('input[name="quickSearch"]').addClass('has-error');
                alert('找不到使用者');
            }
            // console.log(res);
        },
        error: function(res) {
            
        }
    });
});

//增加人員row
$(add_attend).find('button[name="add-user-btn"]').on('click', function() {

    var name = $(add_attend).find('input[name="name"]').val(),
        mobile = $(add_attend).find('input[name="mobile"]').val(),
        phone = $(add_attend).find('input[name="phone"]').val(),
        addr = $(add_attend).find('input[name="addr"]').val();

    var flag = true;
    if(name == '') {
        $(add_attend).find('input[name="name"]').parent().addClass('has-error');
        flag = false;
    }
    if(phone == '' && mobile == '') {
        alert('手機、市話請擇一選填');
        flag = false;
    }
    if(addr == '') {
        $(add_attend).find('input[name="addr"]').parent().addClass('has-error');
        flag = false;
    }

    if(flag) {

        var upid = $(this).data('val');
        $.ajax({
            type: 'POST',
            url: '/doAddActivityUser',
            data: { 
                _token : $(add_attend).find('input[name="_token"]').val(),
                aid : $(add_attend).find('input[name="mm"]').val(),
                upid : upid,
                name : $(add_attend).find('input[name="name"]').val(),
                gender : $(add_attend).find('input[name="sex_type"]:checked').val(),
                mobile : $(add_attend).find('input[name="mobile"]').val(),
                phone : $(add_attend).find('input[name="phone"]').val(),
                year : $(add_attend).find('input[name="year"]').val(),
                addr : $(add_attend).find('input[name="addr"]').val(),
                edu : $(add_attend).find('input[name="edu"]').val(),
                skill : $(add_attend).find('input[name="skill"]').val(),
                inDB : $(add_attend).find('input[name="inDB"]:checked').val(),
            },
            dataType: 'json',
            success: function(res) {
                if(res.status == 'success') {
                    
                    var close = '<button type="button" class="close" data-dismiss=""><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                    $(add_attend).find('.table').append('<tr data-id="'+res.data.id+'"><th><input type="checkbox" class="ckb" checked></th><th class="'+res.data.gender+'">'+res.data.name+'</th><th>'+res.data.addr+'</th><th><div class="'+res.data.inDB+'"><span class="icon-checkmark"></span></div></th><th>'+close+'</th></tr>');
                }
                else if(res == 'already exists') {
                    alert('該位學員已經在名單上');
                }
                console.log(res);
            },
            error: function(res) {
                document.write(res.responseText);
                console.log(res);
            }
        });
    }

	
});

deleteActivityUser(add_attend);
//刪除該課程的學員
function deleteActivityUser(el)
{
	$(el).on('click', '.close', function() {
		if(confirm('該位學員的出席紀錄將全部被刪除，確定要繼續執行嗎?')) {

			var tr = $(this).parent('th').parent('tr');
			$.ajax({
				type: 'Delete',
		        url: '/doDeleteActivityUser',
		        data: { 
		        	_token : $(el).find('input[name="_token"]').val(),
		        	id : $(this).parent().parent().data('id'),
                    aid : $(el).find('input[name="mm"]').val(),
		        },
		        dataType: 'json',
		        success: function(res) {console.log(res);
		        	if(res == 'success') { console.log(res);
    					$(tr).remove();
    					getActivityUser(tabTxt);
		        	}
		        	// console.log(res);
		        },
		        error: function(res) {
		        	document.write(res.responseText);
		        	console.log(res);
	        	}
			});
		}
		
	});
}

//新增簽到紀錄
$(add_attend).on('click', '.save', function() {

	var tr_ckb = $(add_attend).find('.table .ckb');	
	var attendID = [],
		i = 0;

	for(var index in tr_ckb) {		
		if(tr_ckb[index].checked) {
			attendID[i] = tr_ckb.eq(index).parent().parent().data('id');
			i++
		}
	}

	$.ajax({
		type: 'post',
        url: '/doAddActivityAttend',
        data: { 
        	_token : $(add_attend).find('input[name="_token"]').val(),
        	aid : $(add_attend).find('input[name="mm"]').val(),
        	attendID : attendID,
        },
        dataType: 'json',
        success: function(res) {console.log(res);
        	if(res == 'success') {
        		alert('簽到成功');
                $(add_attend).find('#edit_temple').css('display','none');
                window.location.reload();
        	}
        },
        error : function(res) {
        	document.write(res.responseText);
		    console.log(res);
        }
	});
});