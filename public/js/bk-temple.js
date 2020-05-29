var temple = $('#bk-temple');

var searchBar = temple.find('.search_bar'),
    form_AddTemple = temple.find('form[name="doAddTemple"]'),
    form_EditTemple = temple.find('form[name="doEditTemple"]'),
	saveAddTemple = temple.find('button[name="saveAddTemple"]'),
    saveEditTemple = temple.find('button[name="saveEditTemple"]');

$(form_AddTemple).find('.input-group.date').datepicker({format: "yyyy年mm月dd日"});
$(form_EditTemple).find('.input-group.date').datepicker({format: "yyyy年mm月dd日"});

//ddl
ddl(searchBar, 'area');
ddl(searchBar, 'temple_type');
ddl(searchBar, 'temple_name');
ddl(searchBar, 'search_type');
ddl(form_AddTemple, 'temple_type');
ddl(form_AddTemple, 'area');
ddl(form_AddTemple, 'mm');
ddl(form_AddTemple, 'dd');
ddl(form_AddTemple, 'hh');
ddl(form_EditTemple, 'temple_type');
ddl(form_EditTemple, 'area');
ddl(form_EditTemple, 'mm');
ddl(form_EditTemple, 'dd');
ddl(form_EditTemple, 'hh');

//close
p_close(form_AddTemple);
p_close(form_EditTemple);

//增加辦事人員
add_workers(form_AddTemple,'main1');
add_workers(form_EditTemple,'main1');


$(saveAddTemple).on('click', function() {

    var main1 = Array();
    main1 = getWorkers(form_AddTemple, "main1", main1);

	$.ajax({
		type : 'POST',
        url : '/doAddTemple',
        data : $(form_AddTemple).serialize()+'&upid='+main1,
        dataType:'json',
        success : function(res) {

            $(form_AddTemple).find('input[name="name"]').parent().removeClass('has-error');
            $(form_AddTemple).find('textarea[name="addr"]').parent().removeClass('has-error');
            $(form_AddTemple).find('input[name="phone"]').parent().removeClass('has-error');
            $(form_AddTemple).find('input[name="main1"]').parent().parent().removeClass('has-error');
            $(form_AddTemple).find('input[name="start_date"]').parent().removeClass('has-error');
            $(form_AddTemple).find('input[name="yyy"]').parent().removeClass('has-error');
            $(form_AddTemple).find('input[name="yy"]').parent().removeClass('has-error');
            $(form_AddTemple).find('.error-area').text('');
            $(form_AddTemple).find('.error-time').text('');
            console.log(res);
        	if(res == 'success') {
                    alert('新增成功');
                    $(temple).find('#add_temple').css('display','none');
                    window.location.reload();
                }
                else if(res == 'fail') {
                        alert('出現預期外的錯誤,請通知管理員');
                }
                else {
                    if('name' in res) 
                        $(form_AddTemple).find('input[name="name"]').parent().addClass('has-error');
                    if('addr' in res) 
                        $(form_AddTemple).find('textarea[name="addr"]').parent().addClass('has-error');
                    if('phone' in res) 
                        $(form_AddTemple).find('input[name="phone"]').parent().addClass('has-error');
                    if('upid' in res) 
                        $(form_AddTemple).find('.error-main1').text('尚未新增項目');
                    if('start_date' in res) 
                        $(form_AddTemple).find('input[name="start_date"]').parent().addClass('has-error');
                    if('yyy' in res) 
                        $(form_AddTemple).find('input[name="yyy"]').parent().addClass('has-error');
                    if('yy' in res) 
                        $(form_AddTemple).find('input[name="yy"]').parent().addClass('has-error');
                    if('area' in res) 
                        $(form_AddTemple).find('.error-area').text('* 該欄位項目尚未選擇');
                    if('mm' in res || 'dd' in res) 
                        $(form_AddTemple).find('.error-time').text('* 農曆時辰尚有未選擇項目');
                }
        },
        error : function(res) {
                document.write(res.responseText);
        	console.log(res);
        }
	});
});



//getData
$(temple).find('.edit').on('click', function() {
    $.ajax({
        type : 'GET',
        url : '/doGetTemplInfo',
        data : {
            tid : $(this).data('tid'),
        },
        dataType:'json',
        success : function(res) {
            $(form_EditTemple).find('input[name="tid"]').val(res.id);
            $(form_EditTemple).find('button[name="temple_type"]').text(res.type_word);
            $(form_EditTemple).find('button[name="temple_type"]').append('<span class="caret"></span>');
            $(form_EditTemple).find('input[name="temple_type"]').val(res.type);
            $(form_EditTemple).find('input[name="name"]').val(res.name);
            $(form_EditTemple).find('input[name="addr"]').val(res.addr);

            $(form_EditTemple).find('button[name="area"]').text(res.area_word);
            $(form_EditTemple).find('button[name="area"]').append('<span class="caret"></span>');
            $(form_EditTemple).find('input[name="area"]').val(res.area);
            $(form_EditTemple).find('textarea[name="addr"]').val(res.addr);
            $(form_EditTemple).find('input[name="phone"]').val(res.phone);
            $(form_EditTemple).find('input[name="main1"]').data('upid',res.upid);
            $(form_EditTemple).find('input[name="start_date"]').val(res.start_date);
            $(form_EditTemple).find('input[name="yyy"]').val(res.start_date2 != '' ? res.yyy : '');
            $(form_EditTemple).find('input[name="yy"]').val(res.start_date2 != '' ? res.yy : '');
            $(form_EditTemple).find('input[name="mm"]').val(res.start_date2 != '' ? res.mm : '');         
            $(form_EditTemple).find('input[name="dd"]').val(res.start_date2 != '' ? res.dd : '');          
            $(form_EditTemple).find('input[name="hh"]').val(res.start_date2 != '' ? res.hh : '');
            if(res.start_date2 != '') {
                $(form_EditTemple).find('button[name="mm"]').text(res.mm);
                $(form_EditTemple).find('button[name="dd"]').text(res.dd);
                $(form_EditTemple).find('button[name="hh"]').text(res.hh);
                $(form_EditTemple).find('button[name="mm"]').append('<span class="caret"></span>');
                $(form_EditTemple).find('button[name="dd"]').append('<span class="caret"></span>');
            }

            $(form_EditTemple).find('.main1-list p').remove();
            for(var key in res.user_name) {
                $(form_EditTemple).find('.main1-list').append('<p data-upid="'+key+'">'+res.user_name[key]+'<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>');
            }
            
            $(form_EditTemple).find('input[name="bookstore"]').attr('checked', res.bookstore=='true' ? true : false);
            $(form_EditTemple).find('input[name="training"]').attr('checked', res.training=='true' ? true : false);            
            //console.log(res);
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});


$(saveEditTemple).on('click', function() {
    var main1 = Array();
    main1 = getWorkers(form_EditTemple, "main1", main1);

    $.ajax({
        type : 'POST',
            url : '/doEditTemple',
            data : $(form_EditTemple).serialize()+'&upid='+main1,
            dataType:'json',
            success : function(res) {
                console.log(res);
                $(form_EditTemple).find('input[name="name"]').parent().removeClass('has-error');
                $(form_EditTemple).find('textarea[name="addr"]').parent().removeClass('has-error');
                $(form_EditTemple).find('input[name="phone"]').parent().removeClass('has-error');
                $(form_EditTemple).find('input[name="main1"]').parent().parent().removeClass('has-error');
                $(form_EditTemple).find('input[name="start_date"]').parent().removeClass('has-error');
                $(form_EditTemple).find('input[name="yyy"]').parent().removeClass('has-error');
                $(form_EditTemple).find('input[name="yy"]').parent().removeClass('has-error');
                $(form_EditTemple).find('.error-area').text('');
                $(form_EditTemple).find('.error-time').text('');

                if(res == 'success') {
                        alert('修改成功');
                        $(temple).find('#edit_temple').css('display','none');
                        window.location.reload();
                }
                else if(res == 'fail') {
                        alert('出現預期外的錯誤,請通知管理員');
                }
                else {
                    if('name' in res) 
                        $(form_EditTemple).find('input[name="name"]').parent().addClass('has-error');
                    if('addr' in res) 
                        $(form_EditTemple).find('textarea[name="addr"]').parent().addClass('has-error');
                    if('phone' in res) 
                        $(form_EditTemple).find('input[name="phone"]').parent().addClass('has-error');
                    if('upid' in res) 
                        $(form_EditTemple).find('.error-main1').text('尚未新增項目');
                    if('start_date' in res) 
                        $(form_EditTemple).find('input[name="start_date"]').parent().addClass('has-error');
                    if('yyy' in res) 
                        $(form_EditTemple).find('input[name="yyy"]').parent().addClass('has-error');
                    if('yy' in res) 
                        $(form_EditTemple).find('input[name="yy"]').parent().addClass('has-error');
                    if('area' in res) 
                        $(form_EditTemple).find('.error-area').text('* 該欄位項目尚未選擇');
                    if('mm' in res || 'dd' in res) 
                        $(form_EditTemple).find('.error-time').text('* 農曆時辰尚有未選擇項目');
                }
                // console.log(res);
            },
            error : function(res) {
                document.write(res.responseText);
                console.log(res);
            }
    });
});