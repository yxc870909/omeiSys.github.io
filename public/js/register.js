var register = $('#register'),
	rigister_box = register.find('form[name="rigister_box"]');

$(rigister_box).find('.search').on('click', function() {
	
    $.ajax({
        type : 'POST',
        url : '/doShowUsers',
        data : {
        	_token : $(rigister_box).find('input[name="_token"]').val(),
        	search: $(rigister_box).find('input[name="search"]').val()
        },
        dataType:'json',
        success : function(res) {
            if(res.status=='success') {

                rigister_box.find('.ask').hide();
                rigister_box.find('input[name="upid"]').val('');
                $(rigister_box).find('.register').addClass('disabled');

                for(var key in $(rigister_box).find('.search_table tr')) {
                    $(rigister_box).find('.search_table tr').remove();
                }
                for(var key in res.data) {
                    $(rigister_box).find('.search_table').append('<tr data-upid="'+res.data[key]['id']+'" data-area="'+res.data[key]['area_word']+'"><th>'+res.data[key]['gender']+'</th><th>'+res.data[key]['first_name']+res.data[key]['last_name']+'</th><th>'+res.data[key]['mobile']+'</th><th>'+res.data[key]['addr']+'</th></tr>');
                }                            
            }
            else {
                alert('找不到資料。');
            }
            console.log(res);
        },
        error: function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

$(rigister_box).find('.search_table').delegate('tr', 'click',function(){
    rigister_box.find('input[name="upid"]').val($(this).data('upid'));
    rigister_box.find('.ask').text('請問是 '+$(this).data('area')+' '+$(this).find('th').eq(1).text()+' 前賢嗎?');
    rigister_box.find('.ask').show();
    
    $(rigister_box).find('.register').removeClass('disabled');
});


$(rigister_box).find('.register').on('click', function() {
    $.ajax({
        type : 'POST',
        url : '/doRegisterUser',
        data : $(rigister_box).serialize(),
        dataType:'json',
        success : function(res) {
            $(rigister_box).find('div').eq(0).removeClass('has-error');
            $(rigister_box).find('div').eq(2).removeClass('has-error');
            $(rigister_box).find('div').eq(4).removeClass('has-error');
            $(rigister_box).find('.error-account').text('');
            $(rigister_box).find('.error-password').text('');
            $(rigister_box).find('.error-confirm').text('');
            $(rigister_box).find('.error-upid').text('');
            
            if(res.status=='success') {
                alert('註冊成功，請至信箱收取認証信開通帳號');
                window.location.assign('/');
            }
            else if(res.status=='used') {
            	alert('該位道親身分已有人使用。');
            }
            else if(res.status=='regitsted') {
                alert('此帳號已經有人使用。');
            }
            else if(res.status=='fail') {
                alert('系統忙碌中, 請稍候再試。');
            }
            else {                

                if('account' in res) {
                    $(rigister_box).find('div').eq(0).addClass('has-error');
                    $(rigister_box).find('.error-account').text(res.account);
                }
                if('password' in res) {
                    $(rigister_box).find('div').eq(2).addClass('has-error');
                    $(rigister_box).find('.error-password').text(res.password);
                }
                if('confirm' in res) {
                    $(rigister_box).find('div').eq(4).addClass('has-error');
                    $(rigister_box).find('.error-confirm').text(res.confirm);
                }
                if('upid' in res) {
                    $(rigister_box).find('.error-upid').text(res.upid);
                }
            }
            console.log(res);
        },
        error: function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});