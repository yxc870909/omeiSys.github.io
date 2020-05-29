var personnel = $('#bk-personnel');

var personnel_view = personnel.find('form[name="personnel_view"]'),
    personnel_edit = personnel.find('form[name="personnel_edit"]'),
    searchBar = personnel.find('.search_bar'),
	add_box = personnel.find('form[name="add-user-box"]'),
	confirm_registation = personnel.find('#confirm_registation'), 
	doAddGroups = personnel.find('form[name="doAddGroups"]');

$(add_box).find('.input-group.date').datepicker({format: "yyyy年mm月dd日"});


//ddl
ddl(searchBar, 'area');
ddl(searchBar, 'group');
ddl(searchBar, 'position');
ddl(searchBar, 'work');
ddl(add_box, 'area');
ddl(add_box, 'temple');
ddl(add_box, 'mm');
ddl(add_box, 'dd');
ddl(add_box, 'hh');
ddl(add_box, 'edu');
ddl(add_box, 'skill');
ddl(doAddGroups, 'year');
ddl(doAddGroups, 'area');
ddl(doAddGroups, 'group');


//personnel view
personnel.find('.personnel_table tr').on('click', function() {

    var id = $(this).data('val');
    $.ajax({
        type : 'GET',
        url : '/doGetUserData2',
        data : { upid : id },
        dataType:'json',
        success : function(res) {
            var y = new Date().getFullYear();
            $(personnel_view).find('label[name="first_name"]').text(res['first_name']);
            $(personnel_view).find('label[name="last_name"]').text(res['last_name']);
            $(personnel_view).find('label[name="phone"]').text(res['phone']);
            $(personnel_view).find('label[name="mobile"]').text(res['mobile']);
            $(personnel_view).find('label[name="year"]').text(res['year']);
            $(personnel_view).find('label[name="edu"]').text(res['edu_word']);
            $(personnel_view).find('label[name="skill"]').text(res['skill_word']);
            $(personnel_view).find('label[name="father"]').text(res['father']);
            $(personnel_view).find('label[name="mother"]').text(res['mother']);
            $(personnel_view).find('label[name="spouse"]').text(res['spouse']);
            $(res['brosis']).each(function(i, val) {
                $(personnel_view).find('label[name="brosis"]').append(val['word']+', ');
            });
            $(res['child']).each(function(i, val) {
                $(personnel_view).find('label[name="child"]').append(val['word']+', ');
            });
            $(res['relative']).each(function(i, val) {
                $(personnel_view).find('label[name="relative"]').append(val['word']+', ');
            });
            $(personnel_view).find('label[name="addr"]').text(res['addr']);
            $(personnel_view).find('label[name="name"]').text(res['name']);
            $(personnel_view).find('label[name="Dianchuanshi"]').text(res['Dianchuanshi']);
            $(personnel_view).find('label[name="Introducer"]').text(res['Introducer']);
            $(personnel_view).find('label[name="Guarantor"]').text(res['Guarantor']);
            $(personnel_view).find('label[name="work"]').text(res['work_word']);
            $(personnel_view).find('label[name="position"]').text(res['position_word']);
            $(personnel_view).find('label[name="group"]').text(res['groups']);
            
            $(personnel_view).find('a[name="Introducer"]').on('click', function() {
                window.open('/RecordIntroducer?upid='+id+'&year='+y);
            });

            $(personnel_view).find('a[name="Guarantor"]').on('click', function() {
                window.open('/RecordGuarantor?upid='+id+'&year='+y);
            });

            $(personnel_view).find('a[name="agenda"]').on('click', function() {
                window.open('/RecordAgenda?upid='+id+'&year='+y);
            });

            $(personnel_view).find('a[name="join"]').on('click', function() {
                window.open('/RecordJoin?upid='+id+'&year='+y);
            });

            $(personnel_view).find('a[name="teatch"]').on('click', function() {
                window.open('/RecorGroup?upid='+id);
            });

            $(personnel_view).find('a[name="activity"]').on('click', function() {
                window.open('/RecordActivity?upid='+id+'&year='+y);
            });

            $(personnel_view).find('a[name="teatch"]').on('click', function() {
                window.open('/RecordTeatch?upid='+id+'&year='+y);
            });
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//personnel edit
personnel.find('.personnel_table .edit').on('click', function() {
    
    var id =  $(this).data('val');
    $.ajax({
        type : 'GET',
        url : '/doGetPersonnel_edit',
        data : { upid : id },
        dataType:'json',
        success : function(res) {
            // console.log(res);
            $(personnel_edit).find('.level label').remove();
            $(res['type']).each(function(i, val) {
                var contxt = '<label class="radio-inline">' +
                                  '<input type="radio" name="radio-type" id="radio'+i+'" value="'+val['value']+'" '+val['checked']+'>' + 
                                  val['word'] +
                             '</label>';
                $(personnel_edit).find('.level').append(contxt);
            });
            $(personnel_edit).find('input[name="upid"]').val(res['upid']);
            $(personnel_edit).find('input[name="first_name"]').val(res['first_name']);
            $(personnel_edit).find('input[name="last_name"]').val(res['last_name']);
            $(personnel_edit).find('input[name="phone"]').val(res['phone']);
            $(personnel_edit).find('input[name="mobile"]').val(res['mobile']);
            $(personnel_edit).find('input[name="year"]').val(res['year']);

            $(personnel_edit).find('.edu label').remove();
            $(res['edu']).each(function(i, val) {
                var contxt = '<label class="radio-inline">' +
                                  '<input type="radio" name="radio-edu" id="radio'+i+'" value="'+val['value']+'" '+val['checked']+'>' + 
                                  val['word'] +
                             '</label>';
                $(personnel_edit).find('.edu').append(contxt);
            });

            $(personnel_edit).find('.skill label').remove();
            $(res['skill']).each(function(i, val) {
                var contxt = '<label class="radio-inline">' +
                                  '<input type="radio" name="radio-skill" id="radio'+i+'" value="'+val['value']+'" '+val['checked']+'>' + 
                                  val['word'] +
                             '</label>';
                $(personnel_edit).find('.skill').append(contxt);
            });

            $(personnel_edit).find('input[name="father"]').val(res['father']).data('upid', res['father_id']);
            $(personnel_edit).find('input[name="mother"]').val(res['mother']).data('upid', res['mother_id']);
            $(personnel_edit).find('input[name="spouse"]').val(res['spouse']).data('upid', res['spouse_id']);

            $(res['brosis']).each(function(i, val) {
                var contxt = '<p data-upid="'+val['id']+'">'+val['word']+'<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>';
                $(personnel_edit).find('.brosis-list').append(contxt);
            });

            $(res['child']).each(function(i, val) {
                var contxt = '<p data-upid="'+val['id']+'">'+val['word']+'<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>';
                $(personnel_edit).find('.child-list').append(contxt);
            });

            $(res['relative']).each(function(i, val) {
                var contxt = '<p data-upid="'+val['id']+'">'+val['word']+'<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>';
                $(personnel_edit).find('.relative-list').append(contxt);
            });



            $(personnel_edit).find('textarea[name="addr"]').val(res['addr']);
            $(personnel_edit).find('input[name="temple"]').val(res['name']);
            $(personnel_edit).find('input[name="Dianchuanshi"]').val(res['Dianchuanshi']);
            $(personnel_edit).find('input[name="Introducer"]').val(res['Introducer']);
            $(personnel_edit).find('input[name="Guarantor"]').val(res['Guarantor']);
            $(personnel_edit).find('input[name="work"]').val(res['work']);

            $(personnel_edit).find('.position label').remove();
            $(res['position']).each(function(i, val) {
                var contxt = '<label class="checkbox-inline">' +
                                  '<input type="checkbox" id="position'+i+'" name="position[]" value="'+val['value']+'" '+val['checked']+'> ' +
                                  val['word'] +
                             '</label>';
                $(personnel_edit).find('.position').append(contxt);
            });
            $(personnel_edit).find('input[name="group"]').val(res['groups']);
            // console.log(res);
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//close
p_close(personnel_edit);


//search User
search_user(personnel_edit, 'father');
search_user(personnel_edit, 'mother');
search_user(personnel_edit, 'spouse');

add_workers(personnel_edit, 'brosis');
add_workers(personnel_edit, 'child');
add_workers(personnel_edit, 'relative');

//save personnel edit
personnel.find('button[name="saveChange"]').on('click', function() {
    var father = $(personnel_edit).find('input[name="father"]').data('upid'),
        mother = $(personnel_edit).find('input[name="mother"]').data('upid'),
        spouse = $(personnel_edit).find('input[name="spouse"]').data('upid'),
        brosis = Array(),
        child = Array(),
        relative = Array();

    brosis = getWorkers(personnel_edit, 'brosis', brosis);
    child = getWorkers(personnel_edit, 'child', child);
    relative = getWorkers(personnel_edit, 'relative', relative);

    var index = 0;
    var position = Array();
    $(personnel_edit).find('input[name="position[]"]').each(function(i, val) {
        if($(val).prop('checked')) {
            position[index] = $(val).val();
            index++;
        }
    });

    var data = [];
    if($(personnel_edit).find('input[name="radio-type"]:checked').val().length > 0) {
        data = {
            _token : $(personnel_edit).find('input[name="_token"]').val(),
            type : $(personnel_edit).find('input[name="radio-type"]:checked').val(),
            upid : $(personnel_edit).find('input[name="upid"]').val(),
            first_name: $(personnel_edit).find('input[name="first_name"]').val(),
            last_name: $(personnel_edit).find('input[name="last_name"]').val(),
            phone: $(personnel_edit).find('input[name="phone"]').val(),
            mobile: $(personnel_edit).find('input[name="mobile"]').val(),
            year: $(personnel_edit).find('input[name="year"]').val(),
            edu: $(personnel_edit).find('input[name="radio-edu"]:checked').val(),
            skill: $(personnel_edit).find('input[name="radio-skill"]:checked').val(),
            father : father, 
            mother : mother,
            spouse : spouse,
            brosis : brosis,
            child : child,
            relative : relative,
            addr: $(personnel_edit).find('textarea[name="addr"]').val(),
            position: position
        };
    }
    else {
        data = {
            _token : $(personnel_edit).find('input[name="_token"]').val(),
            upid : $(personnel_edit).find('input[name="upid"]').val(),
            first_name: $(personnel_edit).find('input[name="first_name"]').val(),
            last_name: $(personnel_edit).find('input[name="last_name"]').val(),
            phone: $(personnel_edit).find('input[name="phone"]').val(),
            mobile: $(personnel_edit).find('input[name="mobile"]').val(),
            year: $(personnel_edit).find('input[name="year"]').val(),
            edu: $(personnel_edit).find('input[name="radio-edu"]:checked').val(),
            skill: $(personnel_edit).find('input[name="radio-skill"]:checked').val(),
            father : father, 
            mother : mother,
            spouse : spouse,
            brosis : brosis,
            child : child,
            relative : relative,
            addr: $(personnel_edit).find('textarea[name="addr"]').val(),
            position: position
        };
    }

    $.ajax({
        type : 'POST',
        url : '/doSavePersonnel_edit',
        data : data,
        dataType:'json',
        success : function(res) {
            alert('修改成功');
            window.location.reload();
            // console.log(res);
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//close
p_close(add_box);

//select area
$(add_box).find('.area li').on('click', function() {
    var area = $(this).data('val');
    $.ajax({
         type : 'get',
        url : '/doGetTempleByArea',
        data : { area: area },
        dataType:'json',
        success : function(res) {            
            $(add_box).find('.temple li').remove();
            $(res).each(function(i,val) {
                $(add_box).find('.temple ul').append('<li role="presentation" data-val="'+val['id']+'"><a role="menuitem" tabindex="-1">'+val['name']+'壇</a></li>');
            });
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});


add_workers(add_box,'Dianchuanshi');
add_workers(add_box,'upper');
add_workers(add_box,'lowwer');
add_workers(add_box,'action');
add_workers(add_box,'support');
add_workers(add_box,'service1');
add_workers(add_box,'service2');
add_workers(add_box,'towel');
add_workers(add_box,'traffic');
add_workers(add_box,'cooker');
add_workers(add_box,'uplow');
add_workers(add_box,'add');
add_workers(add_box,'peper');
add_workers(add_box,'aegis');
add_workers(add_box,'translation');
add_workers(add_box,'sambo');
add_workers(add_box,'Introduction');
add_workers(add_box,'preside');
add_workers(doAddGroups,'location');
add_workers(doAddGroups,'leader');
add_workers(doAddGroups,'deputy_leader');
add_workers(doAddGroups,'member');

//隱藏辦事選項
$('input[name="radio-type"]').change(function() {
    if($(this).val() == 'single') {
        $(add_box).find('.worker').css('display', 'none');
        $(add_box).find('.Dianchuanshi_out').css('display', 'block');
        $(confirm_registation).find('.worker').css('display', 'none');
    }
    else {
        $(add_box).find('.worker').css('display', 'block');
        $(add_box).find('.Dianchuanshi_out').css('display', 'none');
        $(confirm_registation).find('.worker').css('display', 'block');
    }
});

//search User
search_user(add_box, 'Introducer');
search_user(add_box, 'Guarantor');


//增加人員row
$(add_box).find('button[name="add-user-btn"]').on('click', function() {
	
	var name = $(add_box).find('input[name="name"]').val(),
        gender = $(add_box).find('input[name="sex_type"]:checked').val(),
        gender_val = $(add_box).find('input[name="sex_type"]:checked').val(),
        Dianchuanshi = $('input[name="radio-type"]:checked').val()=='single' ? $(add_box).find('input[name="Dianchuanshi_out"]').val() : $(add_box).find('.Dianchuanshi-list p').eq(0).text(),
        Introducer = $(add_box).find('input[name="Introducer"]').val(),
        I_upid = $(add_box).find('input[name="Introducer"]').data('upid'),
        Guarantor = $(add_box).find('input[name="Guarantor"]').val(),
        G_upid = $(add_box).find('input[name="Guarantor"]').data('upid'),
        year = $(add_box).find('input[name="year"]').val(),
        mobile = $(add_box).find('input[name="mobile"]').val(),
        phone = $(add_box).find('input[name="phone"]').val(),
        edu = $(add_box).find('button[name="edu"]').text(),
        edu_val = $(add_box).find('input[name="edu"]').val(),
        skill = $(add_box).find('button[name="skill"]').text(),
        skill_val = $(add_box).find('input[name="skill"]').val(),
        addr = $(add_box).find('input[name="addr"]').val(),
        close = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    
        if(gender == 'male') gender = '乾';
        else if(gender == 'female') gender = '坤';
        else if(gender == 'boy') gender = '童';
        else if(gender == 'girl') gender = '女';

        $(add_box).find('input[name="name"]').parent().removeClass('has-error');
        $(add_box).find('input[name="Introducer"]').parent().parent().removeClass('has-error');
        $(add_box).find('input[name="Guarantor"]').parent().parent().removeClass('has-error');
        $(add_box).find('input[name="year"]').parent().removeClass('has-error');
        $(add_box).find('input[name="addr"]').parent().removeClass('has-error');

    var flag = true;
    if(name == '') {
        $(add_box).find('input[name="name"]').parent().addClass('has-error');
        flag = false;
    }
    if(!Introducer > 0) {
        $(add_box).find('input[name="Introducer"]').parent().parent().addClass('has-error');
        flag = false;
    }
    if(!Guarantor > 0) {
        $(add_box).find('input[name="Guarantor"]').parent().parent().addClass('has-error');
        flag = false;
    }
    if(phone == '' && mobile == '') {
        alert('手機、市話請擇一選填');
        flag = false;
    }
    if(year == '') {
        $(add_box).find('input[name="year"]').parent().addClass('has-error');
        flag = false;
    }
    if(addr == '') {
        $(add_box).find('input[name="addr"]').parent().addClass('has-error');
        flag = false;
    }

    if(flag) {
        $(add_box).find('.table').append('<tr class="table_box"><th>'+name+'</th><th data-val="'+gender_val+'">'+gender+'</th><th>'+Dianchuanshi+'</th><th data-upid="'+I_upid+'">'+Introducer+'</th><th data-upid="'+G_upid+'">'+Guarantor+'</th><th>'+year+'</th><th>'+mobile+'</th><th>'+phone+'</th><th data-val="'+edu_val+'">'+edu+'</th><th data-val="'+skill_val+'">'+skill+'</th><th>'+addr+'</th><th>'+close+'</th></tr>');
    }
});


//新增求到資料 save
$(add_box).find('button[name="add-user-save"]').on('click', function() {
    
    var flag = true;
 	var Dianchuanshi = $('input[name="radio-type"]:checked').val()=='single' ? $(add_box).find('input[name="Dianchuanshi_out"]').val() : $(add_box).find('.Dianchuanshi-list p').eq(0).text().split("×")[0],
        upper = $(add_box).find('.upper-list p').eq(0).text().split("×")[0],
        lowwer = $(add_box).find('.lowwer-list p').eq(0).text().split("×")[0],
        add = $(add_box).find('.add-list p').eq(0).text().split("×")[0],
        peper = $(add_box).find('.peper-list p').eq(0).text().split("×")[0],
        translation = $(add_box).find('.translation-list p').eq(0).text().split("×")[0],
        uplow = $(add_box).find('.uplow-list p').eq(0).text().split("×")[0],
        aegis = $(add_box).find('.aegis-list p').eq(0).text().split("×")[0],
        sambo = $(add_box).find('.sambo-list p').eq(0).text().split("×")[0]
        Introduction = $(add_box).find('.Introduction-list p').eq(0).text().split("×")[0],
        type = $(add_box).find('input[name="radio-type"]:checked').val();

    var action = Array(),
        support = Array(),
        service1 = Array(),
        service2 = Array(),
        towel = Array(),
        traffic = Array(),
        cooker = Array(),
        preside = Array();        

    var tb = '',
    	location = $(add_box).find('button[name="area"]').text() + ' ' +
    				$(add_box).find('button[name="temple"]').text(),
    	date1 = $(add_box).find('input[name="add_date"]').val(),
    	date2 = $(add_box).find('input[name="yyy"]').val() + '年歲次' + 
    			$(add_box).find('input[name="yy"]').val() + 
    			$(add_box).find('button[name="mm"]').text() + 
    			$(add_box).find('button[name="dd"]').text() +
    			$(add_box).find('button[name="hh"]').text();

    preside = getWorkers_word(add_box, "preside", preside, ', ');
    $(confirm_registation).find('.Dianchuanshi').text('點傳師: ');
    $(confirm_registation).find('.preside').text('操持: ');

    $(confirm_registation).find('.location').text(location);
    $(confirm_registation).find('.date1').text(date1);
    $(confirm_registation).find('.date2').text(date2);
    $(confirm_registation).find('.Dianchuanshi').append(Dianchuanshi);    
    $(confirm_registation).find('.preside').append(preside);

    $(confirm_registation).find('.table').eq(0).find('.table_box').remove();
    $(confirm_registation).find('.table').eq(1).find('.table_box').remove();
    $(confirm_registation).find('.table').eq(2).find('.table_box').remove();
    $(confirm_registation).find('.table').eq(3).find('.table_box').remove();
    $(confirm_registation).find('.table').eq(4).find('.table_box').remove();

    //授課
    tb = '<tr class="table_box"><th>'+sambo+'</th><th>'+Introduction+'</th></tr>';
    $(confirm_registation).find('.table').eq(0).append(tb);
    //禮節
    action = getWorkers_word(add_box, "action", action);
    support = getWorkers_word(add_box, "support", support);
   	tb = '<tr class="table_box"><th>'+upper+'</th><th>'+lowwer+'</th><th>'+action+'</th><th>'+support+'</th></tr>';
    $(confirm_registation).find('.table').eq(1).append(tb);
    //文書
    tb = '<tr class="table_box"><th>'+add+'</th><th>'+peper+'</th><th>'+translation+'</th></tr>';
    $(confirm_registation).find('.table').eq(2).append(tb);
    //服務
    service1 = getWorkers_word(add_box, "service1", service1);
    service2 = getWorkers_word(add_box, "service2", service2);
    towel = getWorkers_word(add_box, "towel", towel);
    tb = '<tr class="table_box"><th>'+service1+'</th><th>'+service2+'</th><th>'+towel+'</th><th>'+uplow+'</th></tr>';
    $(confirm_registation).find('.table').eq(3).append(tb);
    //後勤
    traffic = getWorkers_word(add_box, "traffic", traffic);
    cooker = getWorkers_word(add_box, "cooker", cooker);
    tb = '<tr class="table_box"><th>'+traffic+'</th><th>'+cooker+'</th><th>'+aegis+'</th></tr>';
    $(confirm_registation).find('.table').eq(4).append(tb);

    //joiner
    $(confirm_registation).find('.joiner .table thead').remove();
    $(confirm_registation).find('.joiner .table tr').remove();
    var tableHtml = $(add_box).find('.table').html();
    $(confirm_registation).find('.joiner .table').append(tableHtml);
    

    if(type == 'multi') {
        if(!Dianchuanshi > 0) {
            $(add_box).find('.error-Dianchuanshi').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!upper > 0) {
            $(add_box).find('.error-upper').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!lowwer > 0) {
            $(add_box).find('.error-lowwer').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!add > 0) {
            $(add_box).find('.error-add').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!peper > 0) {
            $(add_box).find('.error-peper').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!sambo > 0) {
            $(add_box).find('.error-sambo').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(!Introduction > 0) {
            $(add_box).find('.error-Introduction').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(action == '') {
            $(add_box).find('.error-action').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(support == '') {
            $(add_box).find('.error-support').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(peper == '') {
            $(add_box).find('.error-peper').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
        if(preside == '') {
            $(add_box).find('.error-preside').text('* 該欄位項目尚未新增辦事人員');
            flag = false;
        }
    }
    
    
    if(!flag) {
        $(confirm_registation).modal('toggle');
        $(confirm_registation).modal('hide');
    }
});

//新增求到資料 confirm save
$(confirm_registation).find('.save').on('click', function() {
	var Dianchuanshi = $('input[name="radio-type"]:checked').val()=='single' ? $(add_box).find('input[name="Dianchuanshi_out"]').val() : $(add_box).find('.Dianchuanshi-list p').eq(0).data('upid'),
        upper = $(add_box).find('.upper-list p').eq(0).data('upid'),
        lowwer = $(add_box).find('.lowwer-list p').eq(0).data('upid'), 
        uplow = $(add_box).find('.uplow-list p').eq(0).data('upid'), 
        add = $(add_box).find('.add-list p').eq(0).data('upid'),
        peper = $(add_box).find('.peper-list p').eq(0).data('upid'), 
        aegis = $(add_box).find('.aegis-list p').eq(0).data('upid'),
        translation = $(add_box).find('.translation-list p').eq(0).data('upid'),
        type = $(add_box).find('input[name="radio-type"]:checked').val();

	var action = Array(),
        support = Array(),
        service1 = Array(),
        service2 = Array(),
        towel = Array(),
        traffic = Array(),
        cooker = Array(),
        sambo = Array(),
        Introduction = Array(),
        preside = Array();

        action = getWorkers(add_box, "action", action);
        support = getWorkers(add_box, "support", support);
        service1 = getWorkers(add_box, "service1", service1);
        service2 = getWorkers(add_box, "service2", service2);
        towel = getWorkers(add_box, "towel", towel);
        traffic = getWorkers(add_box, "traffic", traffic);
        cooker = getWorkers(add_box, "cooker", cooker);
        sambo = getWorkers(add_box, "sambo", sambo);
        Introduction = getWorkers(add_box, "Introduction", Introduction);
        preside = getWorkers(add_box, "preside", preside);

    var name = Array(),
        gender = Array(),
        Dianchuanshi = Array(),
        Introducer = Array(),
        Guarantor = Array(),
        year = Array(),
        mobile = Array(),
        phone = Array(),
        edu = Array(),
        skill = Array(),
        addr = Array();
    for(var i=0; i<$(add_box).find('.table_box').length; i++) {
        name[i] = $(add_box).find('.table_box').eq(i).find('th').eq(0).text();
        gender[i] = $(add_box).find('.table_box').eq(i).find('th').eq(1).data('val');
        if($('input[name="radio-type"]:checked').val()=='single')
            Dianchuanshi[i] = $(add_box).find('input[name="Dianchuanshi_out"]').val()
        else
            Dianchuanshi[i] = $(add_box).find('.Dianchuanshi-list p').eq(0).data('upid');
        Introducer[i] = $(add_box).find('.table_box').eq(i).find('th').eq(3).data('upid');
        Guarantor[i] = $(add_box).find('.table_box').eq(i).find('th').eq(4).data('upid');
        year[i] = $(add_box).find('.table_box').eq(i).find('th').eq(5).text();
        mobile[i] = $(add_box).find('.table_box').eq(i).find('th').eq(6).text();
        phone[i] = $(add_box).find('.table_box').eq(i).find('th').eq(7).text();
        edu[i] = $(add_box).find('.table_box').eq(i).find('th').eq(8).data('val');
        skill[i] = $(add_box).find('.table_box').eq(i).find('th').eq(9).data('val');
        addr[i] = $(add_box).find('.table_box').eq(i).find('th').eq(10).text();
    }

    if($(add_box).find('.table_box').length > 0) {
        $.ajax({
            type : 'POST',
            url : '/doAddUser',
            data : {
                    _token : $(add_box).find('input[name="_token"]').val(),
                    area: $(add_box).find('input[name="area"]').val(),
                    tid: $(add_box).find('input[name="temple"]').val(),
                    type: type,
                    Dianchuanshi: Dianchuanshi,
                    add_date: $(add_box).find('input[name="add_date"]').val(),
                    yyy: $(add_box).find('input[name="yyy"]').val(),
                    yy: $(add_box).find('input[name="yy"]').val(),
                    mm: $(add_box).find('input[name="mm"]').val(),
                    dd: $(add_box).find('input[name="dd"]').val(),
                    hh: $(add_box).find('input[name="dd"]').val(),
                    upper: upper,
                    lowwer: lowwer,
                    action: action,
                    support: support,
                    service1: service1,
                    service2: service2,
                    towel: towel,
                    traffic: traffic,
                    cooker: cooker,
                    sambo: sambo,
                    Introduction: Introduction,
                    preside: preside,
                    uplow: uplow,
                    add: add,
                    peper: peper,
                    aegis: aegis,
                    translation: translation,                
                    name: name,
                    gender: gender,
                    Introducer: Introducer,
                    Guarantor: Guarantor,
                    year: year,
                    mobile: mobile,
                    phone: phone,
                    edu: edu,
                    skill: skill,   
                    addr: addr
            },
            dataType:'json',
            success : function(res) {
                console.log(res);
                if(res=='success'){
                    alert('新增成功');
                    window.location.reload();
                }
                else {
                    if('area' in res) 
                        $(add_box).find('.error-area').text('* 該欄位項目尚未選擇');
                    if('tid' in res) 
                        $(add_box).find('.error-temple').text('* 該欄位項目尚未選擇');
                    if('add_date' in res || 'yyy' in res || 'yy' in res || 'mm' in res || 'dd' in res || 'hh' in res) 
                        $(add_box).find('.error-time').text('* 開班時間尚有未選擇項目');
                    if('Dianchuanshi' in res) 
                        $(add_box).find('.error-Dianchuanshi').text(res.Dianchuanshi);
                    if('upper' in res) 
                        $(add_box).find('.error-upper').text(res.upper);
                    if('lowwer' in res) 
                        $(add_box).find('.error-lowwer').text(res.lowwer);
                    if('add' in res) 
                        $(add_box).find('.error-add').text(res.add);
                    if('peper' in res) 
                        $(add_box).find('.error-peper').text(res.peper);
                    if('sambo' in res) 
                        $(add_box).find('.error-sambo').text(res.sambo);
                    if('Introduction' in res) 
                        $(add_box).find('.error-Introduction').text(res.Introduction);
                    if('action' in res) 
                        $(add_box).find('.error-action').text(res.action);
                    if('support' in res) 
                        $(add_box).find('.error-support').text(res.support);
                    if('peper' in res) 
                        $(add_box).find('.error-peper').text(res.peper);
                    if('preside' in res) 
                        $(add_box).find('.error-preside').text(res.preside);

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



//增加Group人員row
$(doAddGroups).find('button[name="add"]').on('click', function() {

	var year = $(doAddGroups).find('input[name="year"]').val(),
		area_word = $(doAddGroups).find('button[name="area"]').text(),
		area = $(doAddGroups).find('input[name="area"]').val(),
		group_word = $(doAddGroups).find('button[name="group"]').text(),
		group = $(doAddGroups).find('input[name="group"]').val(),
		leader = $(doAddGroups).find('.leader-list p').eq(0).data('upid'),
		leader_word = $(doAddGroups).find('.leader-list p').eq(0).text().split("×")[0],
        deputy_leader = $(doAddGroups).find('.deputy_leader-list p').eq(0).data('upid');
        deputy_leader_word = $(doAddGroups).find('.deputy_leader-list p').eq(0).text().split("×")[0];

    
    var flag = true;
    if($(doAddGroups).find('.table_box').length > 0) {
    	var item_year,item_area,item_group;
    	
		$.each($(doAddGroups).find('.table_box'), function(index, tr) {
			item_year = $(this).find('th').eq(0).text(),
			item_area = $(this).find('th').eq(1).data('val'),
			item_group = $(this).find('th').eq(2).data('val');

			if(item_year == year && item_area == area && item_group == group) {
				alert('該年度區域的'+group_word+'已經存在');
				flag = false;
			}
		});	
	}

    if(year == '') {
        $(doAddGroups).find('.error-year').text('* 該欄位項目尚未選擇');
        flag = false;
    }
    if(area == '') {
        $(doAddGroups).find('.error-area').text('* 該欄位項目尚未選擇');
        flag = false;
    }
    if(group == '') {
        $(doAddGroups).find('.error-group').text('* 該欄位項目尚未選擇');
        flag = false;
    }
    if(!leader > 0) {
        $(doAddGroups).find('.error-leader').text('* 該欄位項目尚未新增辦事人員');
        flag = false;
    }

	if(flag) {
		var member = Array();
		    member = getGroupMembers(doAddGroups, "member", member);

	    var member_wordAry = []
	    	member_upidAry = [];
	    $.each(member, function(index, object){
	    	member_wordAry[index] = object.text().split("×")[0] + '<br>';
	    	member_upidAry[index] = object.data('upid');
	    });

		var close = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';

		$(doAddGroups).find('.table').append('<tr class="table_box"><th>'+year+'</th><th data-val="'+area+'">'+area_word+'</th><th data-val="'+group+'">'+group_word+'</th><th data-upid="'+leader+'">'+leader_word+'</th><th data-upid="'+deputy_leader+'">'+deputy_leader_word+'</th><th data-upid="['+member_upidAry.join()+']">'+member_wordAry.join("")+'</th><th>'+close+'</th></tr>');

        //reset
        $(doAddGroups).find('button[name="year"]').text('選擇年度');
        $(doAddGroups).find('input[name="year"]').val('');
        $(doAddGroups).find('button[name="area"]').text('選擇佛堂區域');
        $(doAddGroups).find('input[name="area"]').val('');
        $(doAddGroups).find('button[name="group"]').text('選擇負責組別');
        $(doAddGroups).find('input[name="group"]').val('');

        $(doAddGroups).find('.location-list p').remove();
        $(doAddGroups).find('input[name="leader"]').val('');
        $(doAddGroups).find('input[name="leader"]').parent().removeClass('has-success').removeClass('has-erroe');
        $(doAddGroups).find('.leader-list p').remove();
        $(doAddGroups).find('input[name="deputy_leader"]').val('');
        $(doAddGroups).find('input[name="deputy_leader"]').parent().removeClass('has-success').removeClass('has-erroe');
        $(doAddGroups).find('.deputy_leader-list p').remove();
        $(doAddGroups).find('input[name="member"]').val('');
        $(doAddGroups).find('input[name="member"]').parent().removeClass('has-success').removeClass('has-erroe');
        $(doAddGroups).find('.member-list p').remove();

	}

    if($(doAddGroups).find('.table_box').length > 0) 
        $(doAddGroups).find('.group-data').css('display', 'block');
});

//close
$(doAddGroups).on('click','.close', function(){
        $(this).parent('p').remove();
        $(this).parent('th').parent('tr').remove();

    if($(doAddGroups).find('.table_box').length == 0) 
        $(doAddGroups).find('.group-data').css('display', 'none');
});

//get group member list
function getGroupMembers(el, cls, obj) {
	for(var index in $(el).find('.'+cls+'-list p').text().toString()) {
            var txt = $(el).find('.'+cls+'-list p').eq(index).text();   
            if(txt) obj[index] = $(el).find('.'+cls+'-list p').eq(index);      
        }
    return obj;
}

//group save
$(doAddGroups).find('.save').on('click', function() {

    var groups = [];
    $.each($(doAddGroups).find('.table_box'), function(index, obj) {

        groups[index] = {
            'year': $(obj).find('th').eq(0).text(),
            'area': $(obj).find('th').eq(1).data('val'),
            'group': $(obj).find('th').eq(2).data('val'),
            'leader': $(obj).find('th').eq(3).data('upid'),
            'deputy_leader': $(obj).find('th').eq(4).data('upid'),
            'member': $(obj).find('th').eq(5).data('upid')
        };
    });

    $.ajax({
        type : 'POST',
        url : '/doAddGroup',
        data : {
                _token : $(doAddGroups).find('input[name="_token"]').val(),
                data : groups
        },
        dataType:'json',
        success : function(res) {
                if(res=='success'){
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
});