var member = $('#bk-member');

var form_editProfile = member.find('form[name="doEditProfile"]'), 
    form_ChangPsw = member.find('form[name="doChangPsw"]'),
	saveChangPsw_btn = member.find('button[name="saveChangPsw"]'),
    member_view = member.find('form[name="member_view"]'),
    edit_faimly = member.find('form[name="edit_faimly"]');


//儲存變更
$(form_editProfile).find('button[name="save"]').on('click', function() {
    $.ajax({
        type : 'POST',
        url : '/doEditprofile',
        data : $(form_editProfile).serialize(),
        dataType:'json',
        success : function(res) {
            if(res == 'success') {
                alert('修改成功');
               window.location.reload();   
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//變更密碼
$(saveChangPsw_btn).on('click', function() {
	$.ajax({
		type : 'POST',
        url : '/doChangePsw',
        data : $(form_ChangPsw).serialize(),
        dataType:'json',
        success : function(res) {

        	var inputs = $(member).find('#PasswodReset .form-group');
        	$(inputs).each(function (index) {
    			$(member).find('#PasswodReset .form-group').eq(index).removeClass('has-error');
    		});

        	if(res == 'success') {
        		alert('密碼變更成功');
        		$(member).find('#PasswodReset').removeClass('in');
        	}
        	else if(res == 'old passwor is error') { 
        		alert('舊密碼輸入錯誤');         		
        		$(inputs).eq(0).addClass('has-error');
        	}
        	else if(res == 'Repeat with old password') { 
        		alert('與舊密碼重複'); 
        		$(inputs).eq(1).addClass('has-error');
        	}
        	else if(res == 'confirm passwor is error') { 
        		alert('輸入內容與新密碼不相符'); 
        		$(inputs).eq(2).addClass('has-error');
        	}
        	console.log(res);
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
	});
});

//user檢視
$(member).find('.faimly_link').on('click', function() {

    var id = $(this).data('val');
    $.ajax({
        type : 'GET',
        url : '/doGetUserData2',
        data : { upid : id },
        dataType:'json',
        success : function(res) {
            console.log(res);
            var y = new Date().getFullYear();
            $(member_view).find('label[name="first_name"]').text(res['first_name']);
            $(member_view).find('label[name="last_name"]').text(res['last_name']);
            $(member_view).find('label[name="phone"]').text(res['phone']);
            $(member_view).find('label[name="mobile"]').text(res['mobile']);
            $(member_view).find('label[name="year"]').text(res['year']);
            $(member_view).find('label[name="edu"]').text(res['edu_word']);
            $(member_view).find('label[name="skill"]').text(res['skill_word']);
            $(member_view).find('label[name="father"]').text(res['father']);
            $(member_view).find('label[name="mother"]').text(res['mother']);
            $(member_view).find('label[name="spouse"]').text(res['spouse']);

            $(member_view).find('label[name="brosis"]').text('');
            $(member_view).find('label[name="child"]').text('');
            $(member_view).find('label[name="relative"]').text('');
            $(res['brosis']).each(function(i, val) {
                $(member_view).find('label[name="brosis"]').append(val['word']+', ');
                console.log(i);
            });
            $(res['child']).each(function(i, val) {
                $(member_view).find('label[name="child"]').append(val['word']+', ');
            });
            $(res['relative']).each(function(i, val) {
                $(member_view).find('label[name="relative"]').append(val['word']+', ');
            });
            $(member_view).find('label[name="addr"]').text(res['addr']);
            $(member_view).find('label[name="name"]').text(res['name']);
            $(member_view).find('label[name="Dianchuanshi"]').text(res['Dianchuanshi']);
            $(member_view).find('label[name="Introducer"]').text(res['Introducer']);
            $(member_view).find('label[name="Guarantor"]').text(res['Guarantor']);
            $(member_view).find('label[name="work"]').text(res['work_word']);
            $(member_view).find('label[name="position"]').text(res['position_word']);
            $(member_view).find('a[name="agenda"]').attr('href', '/RecordAgenda?upid='+id+'&year='+y);
            $(member_view).find('a[name="join"]').attr('href', '/RecordJoin?upid='+id+'&year='+y);
            $(member_view).find('a[name="group"]').attr('href', '/RecorGroup?upid='+id);
            $(member_view).find('a[name="activity"]').attr('href', '/RecordActivity?upid='+id+'&year='+y);
            $(member_view).find('a[name="teatch"]').attr('href', '/RecordTeatch?upid='+id+'&year='+y);
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//get faimly
$(member).find('a[name="edit_faimly"]').on('click', function() {
    $.ajax({
        type : 'GET',
        url : '/doGetFaimly',
        data : { upid : $(member).find('input[name="upid"]').val() },
        dataType:'json',
        success : function(res) {
            console.log(res);
            $(edit_faimly).find('input[name="father"]').val(res['father']);
            $(edit_faimly).find('input[name="father"]').data('upid', res['father_id']);

            $(edit_faimly).find('input[name="mother"]').val(res['mother']);
            $(edit_faimly).find('input[name="mother"]').data('upid', res['mother_id']);

            $(edit_faimly).find('input[name="spouse"]').val(res['spouse']);
            $(edit_faimly).find('input[name="spouse"]').data('upid', res['spouse_id']);
            
            $(edit_faimly).find('.brosis-list p').remove();
            for(var index in res.brosis) {
                id = res.brosis[index].id;
                word = res.brosis[index].word;

                $(edit_faimly).find('.brosis-list').append('<p data-upid="'+id+'">'+word+'<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>');
            }

            $(edit_faimly).find('.child-list p').remove();
            for(var index in res.relative) {
                id = res.child[index].id;
                word = res.child[index].word;

                $(edit_faimly).find('.child-list').append('<p data-upid="'+id+'">'+word+'<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>');
            }

            $(edit_faimly).find('.relative-list p').remove();
            for(var index in res.relative) {
                id = res.relative[index].id;
                word = res.relative[index].word;

                $(edit_faimly).find('.relative-list').append('<p data-upid="'+id+'">'+word+'<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>');
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});


//search User
search_user(edit_faimly, "father");
search_user(edit_faimly, "mother");
search_user(edit_faimly, "spouse");

add_workers(edit_faimly, 'brosis');
add_workers(edit_faimly, 'child');
add_workers(edit_faimly, 'relative');

//close
p_close(edit_faimly);

//update faimly
$(edit_faimly).find('button[name="save"]').on('click', function() {

    var father = $(edit_faimly).find('input[name="father"]').data('upid'),
        mother = $(edit_faimly).find('input[name="mother"]').data('upid'),
        spouse = $(edit_faimly).find('input[name="spouse"]').data('upid'),
        brosis = Array(),
        child = Array(),
        relative = Array();


    brosis = getWorkers(edit_faimly, 'brosis', brosis);
    child = getWorkers(edit_faimly, 'child', child);
    relative = getWorkers(edit_faimly, 'relative', relative);

    $.ajax({
        type : 'POST',
        url : '/doUpdateFaimly',
        data : { 
            _token : $(member).find('input[name="_token"]').val(),
            upid : $(member).find('input[name="upid"]').val(),
            father : father, 
            mother : mother,
            spouse : spouse,
            brosis : brosis,
            child : child,
            relative : relative
        },
        dataType:'json',
        success : function(res) {
            if(res == 'success') {
                alert('更新成功');
                window.location.reload();
            }
            console.log(res);
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });

});
