//ddl function
function ddl(el, cls) {
    $(el).on('click','.'+cls+' li',function(){
        $(el).find('button[name="'+cls+'"]').text($(this).text());
        $(el).find('button[name="'+cls+'"]').append('<span class="caret"></span>');
        $(el).find('input[name="'+cls+'"]').val($(this).data('val'));
        $(el).find('.'+cls+' li').removeClass();
        $(this).addClass('active');
    });
}

//close
function p_close(el) {
	$(el).on('click','.close', function(){
	    $(this).parent('p').remove();
	    $(this).parent('th').parent('tr').remove();
	});
}

//增加辦事人員 function
function add_workers(el,name)
{
    var check = ["Dianchuanshi","Dianchuanshi2","upper","lowwer","uplow","add","peper","aegis","translation","sambo", "Introduction", "location", "leader","deputy_leader"];

    $(el).find('.' + name).on('click',function(){
        if(check.includes(name)) {
            if($(el).find('.'+name+'-list p').length > 0) {
                alert('該項目最多一位');
                return;
            }
        }

        $.ajax({
            type : 'GET',
            url : '/doAddUser_worker',
            data : { search : $(el).find('input[name="'+name+'"]').val(), },
            dataType:'json',
            success : function(res) {
                    if(res.status=='success') {
                        $(el).find('.'+name+'-list').append('<p data-upid="'+res.data.id+'">'+res.data.first_name+res.data.last_name+'<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></p>');      
                        $(el).find('input[name="'+name+'"]').parent('div').addClass('has-success');

                        $(el).find('.error-'+name).text('');
                    }
                    else if(res.status=='more-fail') {
                        $(el).find('input[name="Dianchuanshi"]').parent('div').addClass('has-error');
                        alert('查到多筆同樣姓名，請以帳號搜尋使用者');
                    }
                    else if(res.status=='unfind') {
                        $(el).find('input[name="Dianchuanshi"]').parent('div').addClass('has-error');
                        alert('找不到該使用者');
                    }
                    //console.log(res);
                },
            error: function(res) {
                    alert('系統忙碌中, 請稍候再試。');
                }
        });
    });
}

//get worker list - upid to array
function getWorkers(el, cls, obj) {
    for(var index in $(el).find('.'+cls+'-list p').text().toString()) {
            var txt = $(el).find('.'+cls+'-list p').eq(index).text();   
            if(txt) obj[index] = $(el).find('.'+cls+'-list p').eq(index).data('upid');      
        }
    return obj;
}
function getWorkers_course(el, cls, obj) {
	for(var index in $(el).find('.'+cls+'-list p').text().toString()) {
            var txt = $(el).find('.'+cls+'-list p').eq(index).text();
            if(txt) 
            	obj[index] = $(el).find('.'+cls+'-list p').eq(index).text().split(' - ')[1].split("×")[0];
        }
    return obj;
}
function getWorkers_course_title(el, cls, obj) {
    var ob = [];
    for(var index in $(el).find('.'+cls+'-list p').text().toString()) {
            var txt = $(el).find('.'+cls+'-list p').eq(index).text();
            if(txt) 
                ob[index] = txt.split(' - ')[1].split("×")[0];
        }
    return ob;
}
//含完整姓名
function getWorkers_word(el, cls, obj, separator = '<br>') {
	for(var index in $(el).find('.'+cls+'-list p').text().toString()) {
            var txt = $(el).find('.'+cls+'-list p').eq(index).text();   
            if(txt) obj[index] = $(el).find('.'+cls+'-list p').eq(index).text().split("×")[0];      
        }

    return obj.join(separator);
}

//search User
function search_user(el, cls) {

	$(el).find('.'+cls).on('click', function() {
	    $.ajax({
	        type : 'POST',
	        url : '/doSearchUser',
	        data : {
	                _token : $(el).find('input[name="_token"]').val(),
	                search : $(el).find('input[name="'+cls+'"]').val(),
	        },
	        dataType:'json',
	        success : function(res) {

	                $(el).find('.input-group').removeClass('has-error');

	                if(res.status == 'success') {
	                        $(el).find('input[name="'+cls+'"]').data('upid',res.data.id);
	                        $(el).find('input[name="'+cls+'"]').val(res.data.first_name + res.data.last_name);
	                        $(el).find('input[name="'+cls+'"]').parent('div').addClass('has-success');
	                }
	                else if(res == 'more-fail') {
	                        alert('查到多筆同樣姓名，請以帳號搜尋使用者');
	                        $(el).find('.input-group').addClass('has-error');
	                }
	                else if(res == 'unfind') {
	                        alert('找不到該使用者');
	                        $(el).find('.input-group').eq(0).addClass('has-error');
	                }
	                // console.log(res);
	        },
	        error : function(res) {
	                document.write(res.responseText);
	                console.log(res);
	        }
	    });
	});
}