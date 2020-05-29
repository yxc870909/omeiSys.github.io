var bookssubscription = $('#bk-bookssubscription');
var set_book = bookssubscription.find('form[name="set_book"]'),
    edit_status = bookssubscription.find('form[name="edit_status"]'),
    book_distribute = bookssubscription.find('form[name="book_distribute"]'),
    add_book = bookssubscription.find('form[name="add_book"]'),
    edit_book = bookssubscription.find('form[name="edit_book"]'),
    view_book = bookssubscription.find('form[name="view_book"]'),
    edit_record = bookssubscription.find('form[name="edit_record"]');

$(bookssubscription).find('.input-group.date input[name="start"]').datepicker({format: "yyyy年mm月dd日"});
$(bookssubscription).find('.input-group.date input[name="end"]').datepicker({format: "yyyy年mm月dd日"});
$(edit_book).find('.input-group.date').datepicker({format: "yyyy年mm月dd日"});

ddl(bookssubscription, 'year');
ddl(bookssubscription, 'type');
ddl(edit_status, 'status');
ddl(add_book, 'temple');
ddl(add_book, 'type');
ddl(add_book, 'type2');
ddl(add_book, 'lan');
ddl(edit_book, 'temple');
ddl(edit_book, 'type');
ddl(edit_book, 'type2');
ddl(edit_book, 'lan');
ddl(edit_record, 'status');
//ddl function
function ddl(el, cls) {
	$(el).on('click','.'+cls+' li',function(){
        $(el).find('button[name="'+cls+'"]').text($(this).text());
        $(el).find('button[name="'+cls+'"]').append('<span class="caret"></span>');
        $(el).find('input[name="'+cls+'"]').val($(this).data('val'));
    });
}

//get area book count
$(bookssubscription).on('click', '.areaCount', function() {
    var year = $(bookssubscription).find('input[name="year"]').val(),
        area = $(this).data('val');

    $(set_book).find('input[name="year"]').val(year);
    $(set_book).find('input[name="area"]').val(area);

    $.ajax({
        type : 'GET',
        url : '/doGetSubscriptionCount',
        data : { 
            year : year,
            area : area
         },
        dataType:'json',
        success : function(res) {
            console.log(res);
            for(var index in res) {
                $(set_book).find('input[name="' + res[index].type + '"]').val(res[index].count);
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });

});

//save area book count
$(set_book).on('click', 'button[name="save"]', function() {
    
    $.ajax({
        type : 'POST',
        url : '/doSaveSubscriptionCount',
        data : $(set_book).serialize(),
        dataType:'json',
        success : function(res) {
            if(res == 'success') {
                alert('編輯成功');
                window.location.reload();
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//get book data
$(bookssubscription).on('click', '.count_table tr', function() {

    var sbid = $(this).data('sbid'),
        spid = $(this).data('spid');
    $.ajax({
        type : 'GET',
        url : '/doGetSubScriptionBookData',
        data : { id : sbid, },
        dataType:'json',
        success : function(res) {
            console.log(res);
            if(res.status == 'success') {

                $(edit_status).find('.status li').each(function() {     
                           
                    if($(this).data('val') == res.data[0].status) {

                        $(edit_status).find('button[name="status"]').text($(this).text());
                        $(edit_status).find('button[name="status"]').append('<span class="caret"></span>');
                        if(res.data[0].status == 'process') {
                            $(edit_status).find('input[name="status"]').val(res.data[0].status);                            
                        }
                        else {
                            $(edit_status).find('button[name="status"]').addClass('disabled');
                            $(edit_status).find('button[name="save"]').addClass('disabled');
                        }
                    }
                });

                $(edit_status).find('label[name="temple"]').text(res.data[0].name);
                $(edit_status).find('label[name="cat"]').text(res.data[0].attribute);

                var lan = "";
                if(res.data[0].lan =='tran_chinese')
                    lan = '中文';
                $(edit_status).find('label[name="lan"]').text(lan);

                $(edit_status).find('label[name="title"]').text(res.data[0].title);

                if(res.data[0].img.length > 0) {
                    $(edit_status).find('#img').attr('src', '/upload/subscription/'+res.data[0].img);   
                }

                $(edit_status).find('p[name="return_date"]').addClass('gray');
                $(edit_status).find('input[name="sbid"]').val(sbid);
                $(edit_status).find('input[name="spid"]').val(spid);
                $(edit_status).find('label[name="author"]').text(res.data[0].author);
                $(edit_status).find('label[name="isbn"]').text(res.data[0].isbn);
                $(edit_status).find('label[name="pub_year"]').text(res.data[0].pub_year);
                $(edit_status).find('label[name="version"]').text(res.data[0].version);
                $(edit_status).find('label[name="no"]').text(res.data[0].no);
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//search user
$(edit_status).find('button[name="search"]').on('click', function() {

    $.ajax({
        type : 'POST',
        url : '/doSearchUser',
        data : { 
            _token : $(edit_status).find('input[name="_token"]').val(),
            search : $(edit_status).find('input[name="search"]').val(), 
        },
        dataType:'json',
        success : function(res) {
            if(res.status == 'success') {
                $(edit_status).find('input[name="search"]').parent().addClass('has-success');
                $(edit_status).find('input[name="upid"]').val(res.data.id);
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//edit application status
$(edit_status).find('button[name="save"]').on('click', function() {

     $.ajax({
        type : 'POST',
        url : '/doEditSubscriptionRecord',
        data : $(edit_status).serialize(),
        dataType:'json',
        success : function(res) {
            if(res == 'success') {
                alert('變更成功');
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

//分發書籍
$(bookssubscription).on('click', 'button[name="tr_save"]', function() {
    var tr_obj = $(this).parent().parent();
    var tid = tr_obj.data('tid'),
        spid = tr_obj.data('spid'),
        count = tr_obj.find('td input[name="count"]').val();

    $.ajax({
        type : 'POST',
        url : '/doSaveTempleReceive',
        data : {
            _token : $(book_distribute).find('input[name="_token"]').val(),
            tid : tid,
            spid : spid,
            count : count
        },
        dataType:'json',
        success : function(res) {

            $(tr_obj).find('input[name="count"]').parent().removeClass('has-error');
            if(res == 'success') {
                alert('分發成功');
                $(tr_obj).find('input[name="count"]').attr('disabled', true);
                $(tr_obj).find('td').eq(4).remove();
            }
            else if(res == 'Inventory shortage') {
                alert('庫存不足');
                $(tr_obj).find('input[name="count"]').parent().addClass('has-error');
            }
            else {
                $(tr_obj).find('input[name="count"]').parent().addClass('has-error');
            }
            console.log(res);
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});



//get book category type2
$(add_book).on('click', '.type li', function() {
	$.ajax({
		type : 'GET',
        url : '/doGetSubscriptionType',
        data : { type : $(this).text()},
        dataType:'json',
        success : function(res) {
        	$(add_book).find('.type2 ul li').remove();
        	for(var index in res) {
        		$(add_book).find('.type2 ul').append('<li role="presentation" data-val="'+res[index].value+'"><a role="menuitem" tabindex="-1" href="#">'+res[index].word+'</a></li>');
        	}        	
        },
        error : function(res) {
        	document.write(res.responseText);
        	console.log(res);
        }
	});
});

//add 上傳圖片至tmp
$(add_book).on('click', '.upload', function() {

	$(add_book).find('#upload').on('change', function() {

		var file = new FormData();
		file.append('photo', $(add_book).find('input[type="file"]')[0].files[0]);
		file.append('_token', $(add_book).find('input[name="_token"]').val());

		$.ajax({   
	        url: '/doUploadPhoto',   
	        data: file,    
	        dataType: "json",   
	        type: "POST",   
	        cache: false,   
	        contentType: false,   
	        processData: false,  
	        beforeSend:function() {}, 
          	success: function(res) {   
	        	if(res['ServerNo']=='200') {
	        		$(add_book).find('#img').attr('src', '/tmp/'+res['ResultData']);
	        		$(add_book).find('input[name="fileName"]').val(res['ResultData']);
	        		$(add_book).find('.upload').css('display', 'none');
	        		$(add_book).find('.icon-cancel-circle').css('display', 'block');
	        		// console.log(res);
	        	}
	        	else {
	        		alert(res['ResultData']);
	        	}	            
	        },
	        error: function(xhr) {   
	            document.write(xhr.responseText);
	        	console.log(xhr);   
	        }
	    });

	});
});

//add delete photo
$(add_book).on('click', '.icon-cancel-circle', function() {
	$.ajax({
		type : 'DELETE',
        url : '/doDelPhoto',
        data : { 
        	_token : $(add_book).find('input[name="_token"]').val(),
        },
        dataType:'json',
        success : function(res) {
        	$(add_book).find('#img').attr('src', '');
        	$(add_book).find('input[name="fileName"]').val();
        	$(add_book).find('.upload').css('display', 'block');
	        $(add_book).find('.icon-cancel-circle').css('display', 'none');
        },
        error : function(res) {
        	document.write(res.responseText);
        	console.log(res);
        }
	});
});

//add book save
$(add_book).on('click', 'button[name="save"]', function() {

	$.ajax({
		type : 'POST',
        url : '/doAddSubscriptionBooks',
        data : $(add_book).serialize(),
        dataType:'json',
        success : function(res) {

            $(add_book).find('.error-temple').text('');
            $(add_book).find('input[name="SubscriptionCount"]').parent().removeClass("has-error");
            $(add_book).find('input[name="book_name"]').parent().removeClass("has-error");
            $(add_book).find('.upload').css('color','#ddd');
            $(add_book).find('.error-type').text('');
            $(add_book).find('.error-lan').text('');
        	if(res == 'success') {
        		alert('新增成功');
        		window.location.reload();
        	}
            else {
                if('temple' in res) 
                    $(add_book).find('.error-temple').text('* 該欄位項目尚未選擇');
                if('SubscriptionCount' in res) 
                    $(add_book).find('input[name="SubscriptionCount"]').parent().addClass("has-error");
                if('book_name' in res) 
                    $(add_book).find('input[name="book_name"]').parent().addClass("has-error");
                if('fileName' in res)
                    $(add_book).find('.upload').css('color','#d64e4e');
                if('type' in res || 'type2' in res) 
                    $(add_book).find('.error-type').text('* 該欄位項目尚未選擇');
                if('lan' in res) 
                    $(add_book).find('.error-lan').text('* 該欄位項目尚未選擇');
            }
        	console.log(res);
        },
        error : function(res) {
        	document.write(res.responseText);
        	console.log(res);
        }
	});
});

//get book data
$(bookssubscription).find('.edit_btn').on('click', function() {
    
    var id = $(this).data('val');
    $.ajax({
        type : 'GET',
        url : '/doGetSubscriptionData',
        data : { id : $(this).data('val'), },
        dataType:'json',
        success : function(res) {
            if(res.status == 'success') {

                $(edit_book).find('.temple li').each(function() {                   
                    if($(this).data('val') == res.data[0].tid) {
                        $(edit_book).find('button[name="temple"]').text($(this).text());
                        $(edit_book).find('button[name="temple"]').append('<span class="caret"></span>');
                        $(edit_book).find('input[name="temple"]').val(res.data[0].tid);
                    }
                });

                $(edit_book).find('button[name="type"]').text(res.data[0].attribute);
                $(edit_book).find('button[name="type"]').append('<span class="caret"></span>');
                $(edit_book).find('input[name="type"]').val(res.data[0].attribute);

                $.ajax({
                    type : 'GET',
                    url : '/doGetSubscriptionType',
                    data : { type : res.data[0].attribute },
                    dataType:'json',
                    success : function(res) {
                        $(edit_book).find('.type2 ul li').remove();
                        for(var index in res) {
                            $(edit_book).find('.type2 ul').append('<li role="presentation" data-val="'+res[index].value+'"><a role="menuitem" tabindex="-1" href="#">'+res[index].word+'</a></li>');
                        }           
                    },
                    error : function(res) {
                        document.write(res.responseText);
                        console.log(res);
                    }
                });

                $(edit_book).find('button[name="type2"]').text(res.data[0].word);
                $(edit_book).find('button[name="type2"]').append('<span class="caret"></span>');
                $(edit_book).find('input[name="type2"]').val(res.data[0].cat);

                $(edit_book).find('.lan li').each(function() {                  
                    if($(this).data('val') == res.data[0].lan) {
                        $(edit_book).find('button[name="lan"]').text($(this).text());
                        $(edit_book).find('button[name="lan"]').append('<span class="caret"></span>');
                        $(edit_book).find('input[name="lan"]').val(res.data[0].lan);
                    }
                });

                $(edit_book).find('input[name="book_name"]').val(res.data[0].title);
                $(edit_book).find('input[name="count"]').val(res.data[0].count);

                if(res.data[0].img.length > 0) {
                    $(edit_book).find('#img').attr('src', '/upload/subscription/'+res.data[0].img);
                    $(edit_book).find('input[name="fileName"]').val(res.data[0].img);
                    $(edit_book).find('.upload').css('display', 'none');
                }

                $(edit_book).find('input[name="id"]').val(id);
                $(edit_book).find('input[name="is_borrow"]').prop("checked", res.data[0].is_borrow=='true' ? true : false);
                $(edit_book).find('input[name="book_number"]').val(res.data[0].location);
                $(edit_book).find('input[name="author"]').val(res.data[0].author);
                $(edit_book).find('input[name="isbn"]').val(res.data[0].isbn);
                $(edit_book).find('input[name="pub_year"]').val(res.data[0].pub_year);
                $(edit_book).find('input[name="version"]').val(res.data[0].version);
                $(edit_book).find('input[name="no"]').val(res.data[0].no);
                $(edit_book).find('input[name="price"]').val(res.data[0].price);
                $(edit_book).find('input[name="buy_date"]').val(res.data[0].buy_date);
                
            }
            console.log(res);
        },
        error : function(res) {}
    });
});

//edit 上傳圖片至tmp
$(edit_book).on('click', '.upload', function() {

    console.log($(edit_book).find('input[type="file"]').val());
    $(edit_book).find('#reupload').on('change', function() {

        var file = new FormData();
        file.append('photo', $(edit_book).find('input[type="file"]')[0].files[0]);
        file.append('_token', $(edit_book).find('input[name="_token"]').val());

        
        $.ajax({   
            url: '/doUploadPhoto',   
            data: file,    
            dataType: "json",   
            type: "POST",   
            cache: false,   
            contentType: false,   
            processData: false,  
            beforeSend:function() {}, 
            success: function(res) {   
                if(res['ServerNo']=='200') {
                    $(edit_book).find('#img').attr('src', '/tmp/'+res['ResultData']);
                    $(edit_book).find('input[name="fileName"]').val(res['ResultData']);
                    $(edit_book).find('.upload').css('display', 'none');
                    $(edit_book).find('.icon-cancel-circle').css('display', 'block');   
                    // console.log(res);                
                }
                else {
                    alert(res['ResultData']);
                }            

            },
            error: function(xhr) {   
                document.write(xhr.responseText);
                console.log(xhr);   
            }
        });

    });
});

//edit delete photo
$(edit_book).on('click', '.icon-cancel-circle', function() {

    $.ajax({
        type : 'DELETE',
        url : '/doDelPhoto',
        data : { 
            _token : $(edit_book).find('input[name="_token"]').val(),
        },
        dataType:'json',
        success : function(res) {
            $(edit_book).find('#img').attr('src', '');
            $(edit_book).find('input[name="fileName"]').val('');
            $(edit_book).find('input[name="upload"]').val('');
            $(edit_book).find('.upload').css('display', 'block');
            $(edit_book).find('.icon-cancel-circle').css('display', 'none');      
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//edit book save
$(edit_book).on('click', 'button[name="save"]', function() {

    $.ajax({
        type : 'POST',
        url : '/doEditSubscription',
        data : $(edit_book).serialize() + "id=" + $(edit_book).find('input[name="id"]').val(),
        dataType:'json',
        success : function(res) {

            $(edit_book).find('.error-temple').text('');
            $(edit_book).find('input[name="count"]').parent().removeClass("has-error");
            $(edit_book).find('input[name="book_name"]').parent().removeClass("has-error");
            $(edit_book).find('.upload').css('color','#ddd');
            $(edit_book).find('.error-type').text('');
            $(edit_book).find('.error-lan').text('');
            if(res == 'success') {
                alert('修改成功');
                window.location.reload();
            }
            else {
                if('temple' in res) 
                    $(edit_book).find('.error-temple').text('* 該欄位項目尚未選擇');
                if('count' in res) 
                    $(edit_book).find('input[name="count"]').parent().addClass("has-error");
                if('book_name' in res) 
                    $(edit_book).find('input[name="book_name"]').parent().addClass("has-error");
                if('fileName' in res)
                    $(edit_book).find('.upload').css('color','#d64e4e');
                if('type' in res || 'type2' in res) 
                    $(edit_book).find('.error-type').text('* 該欄位項目尚未選擇');
                if('lan' in res) 
                    $(edit_book).find('.error-lan').text('* 該欄位項目尚未選擇');
            }
            console.log(res);
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});