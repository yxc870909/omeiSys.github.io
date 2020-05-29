var bk_booksborrow = $('#bk-booksborrow');
var add_book = bk_booksborrow.find('form[name="add_book"]'),
	edit_book = bk_booksborrow.find('form[name="edit_book"]'),
    count_book = bk_booksborrow.find('form[name="count_book"]'),
    view_book = bk_booksborrow.find('form[name="view_book"]'),
    edit_record = bk_booksborrow.find('form[name="edit_record"]'),
    add_borrow = bk_booksborrow.find('form[name="doAddBorrow"]');

$(add_book).find('.input-group.date').datepicker({format: "yyyy年mm月dd日"});
$(edit_book).find('.input-group.date').datepicker({format: "yyyy年mm月dd日"});

ddl(add_book, 'temple');
ddl(add_book, 'type');
ddl(add_book, 'lan');
ddl(edit_book, 'temple');
ddl(edit_book, 'type');
ddl(edit_book, 'lan');
ddl(edit_record, 'status');
ddl(count_book, 'scann_temple');
ddl(count_book, 'key_temple');
ddl(count_book, 'mode');
ddl(add_borrow, 'mode');
//ddl function
function ddl(el, cls) {
	$(el).on('click','.'+cls+' li',function(){
        $(el).find('button[name="'+cls+'"]').text($(this).text());
        $(el).find('button[name="'+cls+'"]').append('<span class="caret"></span>');
        $(el).find('input[name="'+cls+'"]').val($(this).data('val'));
    });
}

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
        url : '/doAddBooks',
        data : $(add_book).serialize(),
        dataType:'json',
        success : function(res) {

        $(add_book).find('.error-temple').text('');
        $(add_book).find('input[name="book_number"]').parent().removeClass("has-error");
        $(add_book).find('input[name="book_name"]').parent().removeClass("has-error");
        $(add_book).find('.upload').css('color','#ddd');
        $(add_book).find('.error-type').text('');
        $(add_book).find('.error-lan').text('');
        $(add_book).find('input[name="pub_year"]').parent().removeClass("has-error");
        $(add_book).find('input[name="buy_date"]').parent().removeClass("has-error");
        console.log(res);
        	if(res == 'success') {
        		alert('新增成功');
        		window.location.reload();
        	}
            else {
                if('temple' in res) 
                    $(add_book).find('.error-temple').text('* 該欄位項目尚未選擇');
                if('location' in res) 
                    $(add_book).find('input[name="location"]').parent().addClass("has-error");
                if('book_name' in res) 
                    $(add_book).find('input[name="book_name"]').parent().addClass("has-error");
                if('count' in res) 
                    $(add_book).find('input[name="count"]').parent().addClass("has-error");
                if('fileName' in res)
                    $(add_book).find('.upload').css('color','#d64e4e');
                if('type' in res) 
                    $(add_book).find('.error-type').text('* 該欄位項目尚未選擇');
                if('lan' in res) 
                    $(add_book).find('.error-lan').text('* 該欄位項目尚未選擇');
                if('buy_date' in res) 
                    $(add_book).find('input[name="buy_date"]').parent().addClass("has-error");
            }
        	
        },
        error : function(res) {
        	document.write(res.responseText);
        	console.log(res);
        }
	});
});


//get book data
$(bk_booksborrow).find('.edit_btn').on('click', function() {
	
	var id = $(this).data('val');
	$.ajax({
		type : 'GET',
        url : '/doGetBooksData',
        data : { id : $(this).data('val'), },
        dataType:'json',
        success : function(res) {
        	if(res.status == 'success') {
                // console.log(res);
        		$(edit_book).find('.temple li').each(function() {        			
        			if($(this).data('val') == res.data[0].tid) {
        			    $(edit_book).find('button[name="temple"]').text($(this).text());
        			    $(edit_book).find('button[name="temple"]').append('<span class="caret"></span>');
        			    $(edit_book).find('input[name="temple"]').val(res.data[0].tid);
        			}
        		});

        		$(edit_book).find('.type li').each(function() {        			
        			if($(this).data('val') == res.data[0].cat) {
        			    $(edit_book).find('button[name="type"]').text($(this).text());
        			    $(edit_book).find('button[name="type"]').append('<span class="caret"></span>');
        			    $(edit_book).find('input[name="type"]').val(res.data[0].cat);
        			}
        		});

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
        			$(edit_book).find('#img').attr('src', '/upload/books/'+res.data[0].img);
        			$(edit_book).find('input[name="fileName"]').val(res.data[0].img);
        			$(edit_book).find('.upload').css('display', 'none');
        		}

        		$(edit_book).find('input[name="id"]').val(id);
        		$(edit_book).find('input[name="is_borrow"]').prop("checked", res.data[0].is_borrow=='true' ? true : false);
        		$(edit_book).find('label[name="number"]').text(res.data[0].number);
                $(edit_book).find('input[name="location"]').val(res.data[0].location);
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
        url : '/doEditBooks',
        data : $(edit_book).serialize() + "id=" + $(edit_book).find('input[name="id"]').val(),
        dataType:'json',
        success : function(res) {

            $(edit_book).find('.error-temple').text('');
            $(edit_book).find('input[name="book_number"]').parent().removeClass("has-error");
            $(edit_book).find('input[name="book_name"]').parent().removeClass("has-error");
            $(edit_book).find('.upload').css('color','#ddd');
            $(edit_book).find('.error-type').text('');
            $(edit_book).find('.error-lan').text('');
            $(edit_book).find('input[name="pub_year"]').parent().removeClass("has-error");
            $(edit_book).find('input[name="buy_date"]').parent().removeClass("has-error");
        
        	if(res == 'success') {
        		alert('修改成功');
        		window.location.reload();
        	}
            else {
                if('temple' in res) 
                    $(edit_book).find('.error-temple').text('* 該欄位項目尚未選擇');
                if('location' in res) 
                    $(edit_book).find('input[name="location"]').parent().addClass("has-error");
                if('book_name' in res) 
                    $(edit_book).find('input[name="book_name"]').parent().addClass("has-error");
                if('count' in res) 
                    $(edit_book).find('input[name="count"]').parent().addClass("has-error");
                if('fileName' in res)
                    $(edit_book).find('.upload').css('color','#d64e4e');
                if('type' in res) 
                    $(edit_book).find('.error-type').text('* 該欄位項目尚未選擇');
                if('lan' in res) 
                    $(edit_book).find('.error-lan').text('* 該欄位項目尚未選擇');
                if('pub_year' in res) 
                    $(edit_book).find('input[name="pub_year"]').parent().addClass("has-error");
                if('buy_date' in res) 
                    $(edit_book).find('input[name="buy_date"]').parent().addClass("has-error");
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
$(bk_booksborrow).find('img[name="item_img"]').on('click', function() {
    
    var id = $(this).data('val');
    $(view_book).find('button[name="save"]').removeClass('disabled');

    $.ajax({
        type : 'GET',
        url : '/doGetBooksData',
        data : { id : $(this).data('val'), },
        dataType:'json',
        success : function(res) {
            if(res.status == 'success') {
                
                if(res.data[0].status == 'process')
                    $(view_book).find('button[name="save"]').addClass('disabled');

                $(view_book).find('label[name="temple"]').text(res.data[0].name);
                $(view_book).find('label[name="cat"]').text(res.data[0].word);

                var lan = "";
                if(res.data[0].lan =='tran_chinese')
                    lan = '中文';
                $(view_book).find('label[name="lan"]').text(lan);

                $(view_book).find('label[name="title"]').text(res.data[0].title);

                if(res.data[0].img.length > 0) {
                    $(view_book).find('#img').attr('src', '/upload/books/'+res.data[0].img);   
                }

                $(view_book).find('input[name="id"]').val(id);
                $(view_book).find('label[name="author"]').text(res.data[0].author);
                $(view_book).find('label[name="isbn"]').text(res.data[0].isbn);
                $(view_book).find('label[name="pub_year"]').text(res.data[0].pub_year);
                $(view_book).find('label[name="version"]').text(res.data[0].version);
                $(view_book).find('label[name="no"]').text(res.data[0].no);
                //console.log(res);
            }
        },
        error : function(res) {}
    });
});


//get book data
$(bk_booksborrow).find('.record_table tr').on('click', function() {

   var id = $(this).data('val');
   $.ajax({
        type : 'GET',
        url : '/doGetBorrowRecordData',
        data : { id : id, },
        dataType:'json',
        success : function(res) {
            if(res.status == 'success') {

                $(edit_record).find('.status li').each(function() {     
                           
                    if($(this).data('val') == res.data[0].status) {

                        // $(this).addClass('active');
                        $(edit_record).find('button[name="status"]').text($(this).text());
                        $(edit_record).find('button[name="status"]').append('<span class="caret"></span>');
                        if(res.data[0].status == 'out') {
                            $(edit_record).find('input[name="status"]').val(res.data[0].status);                            
                        }
                        else {
                            $(edit_record).find('button[name="status"]').addClass('disabled');
                            $(edit_record).find('button[name="save"]').addClass('disabled');
                        }
                    }
                });

                $(edit_record).find('label[name="temple"]').text(res.data[0].name);
                $(edit_record).find('label[name="cat"]').text(res.data[0].attribute);

                var lan = "";
                if(res.data[0].lan =='tran_chinese')
                    lan = '中文';
                $(edit_record).find('label[name="lan"]').text(lan);

                $(edit_record).find('label[name="title"]').text(res.data[0].title);

                if(res.data[0].img.length > 0) {
                    $(edit_record).find('#img').attr('src', '/upload/subscription/'+res.data[0].img);   
                }

                $(edit_record).find('p[name="return_date"]').text('歸還時間: ' + res.data[0].return_date);
                $(edit_record).find('p[name="return_date"]').addClass('gray');
                $(edit_record).find('input[name="id"]').val(id);
                $(edit_record).find('label[name="author"]').text(res.data[0].author);
                $(edit_record).find('label[name="isbn"]').text(res.data[0].isbn);
                $(edit_record).find('label[name="pub_year"]').text(res.data[0].pub_year);
                $(edit_record).find('label[name="version"]').text(res.data[0].version);
                $(edit_record).find('label[name="no"]').text(res.data[0].no);
            }
        },
        error : function(res) {}
   }); 
});

//edit record
$(edit_record).find('button[name="save"]').on('click', function() {

    $.ajax({
        type : 'POST',
        url : '/doEditBorrow',
        data : {
            _token : $(edit_record).find('input[name="_token"]').val(),
            id : $(edit_record).find('input[name="id"]').val(),
            status : $(edit_record).find('input[name="status"]').val()
        },
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


///////borrow///////
//scann mode click
$(add_borrow).on('click', 'li', function() {
    if($(add_borrow).find('input[name="mode"]').val() == 'scann') {
        $(add_borrow).find('.scann_mode').show();
        $(add_borrow).find('.key_mode').hide();
    }
    else if($(add_borrow).find('input[name="mode"]').val() == 'key') {
        $(add_borrow).find('.scann_mode').hide();
        $(add_borrow).find('.key_mode').show();
    }
});

//scann user search
$(add_borrow).find('button[name="scann_search"]').on('click', function() {
    $.ajax({
        type : 'POST',
        url : '/doSearchUser',
        data : { 
            _token : $(add_borrow).find('input[name="_token"]').val(),
            search : $(add_borrow).find('input[name="scann_search"]').val() 
        },
        dataType:'json',
        success : function(res) {
            if(res.status == 'success') {
                $(add_borrow).find('input[name="scann_search"]').parent().addClass('has-success');
                $(add_borrow).find('input[name="scann_upid"]').val(res.data.id);
                $(add_borrow).find('.scan_ready').css('display', 'block');
                $(add_borrow).find('input[name="scann_number"]').focus();
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//scann scanning
$(add_borrow).find('input[name="scann_number"]').keydown(function(e){

    if(e.which==13) {        
        $.ajax({
            type : 'POST',
            url : '/doGetBooksDataFromNumber',
            data : { 
                _token : $(add_borrow).find('input[name="_token"]').val(),
                upid : $(add_borrow).find('input[name="scann_upid"]').val(),
                number : $(add_borrow).find('input[name="scann_number"]').val()
            },
            dataType:'json',
            success : function(res) {
                if(res.status=='success') {
                    $(add_borrow).find('.borrow_table tr').remove();
                    for(var index in res.data) {
                        $(add_borrow).find('.borrow_table').append('<tr data-bid="'+res.data[index].bid+'" data-id="'+res.data[index].id+'""><th><a href="" style="cursor: default; text-decoration:none;">'+res.data[index].title+'</a></th><th style="width: 10%; text-align: right;">'+res.data[index].name+'</th><th data-val="'+res.data[index].count+'"style="width: 14%; text-align: center;">'+res.data[index].count+'本</th><th style="width: 10px;"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></th></tr>');
                    }                    

                    $(add_borrow).find('input[name="scann_number"]').val('');
                    $(add_borrow).find('input[name="scann_number"]').focus();

                    if($(add_borrow).find('.borrow_table tr').length > 0) 
                        $(add_borrow).find('.group-data').css('display', 'block');
                }
                else if(res.status == 'not found') {
                    alert('找不到書籍或已經沒有庫存');
                }
                    
                // console.log(res);
                
            },
            error : function(res) {
                document.write(res.responseText);
                console.log(res);
            }
        });
    }
});

//not focus
$(add_borrow).find('input[name="scann_number"]').blur(function() {
    $(add_borrow).find('.scan_ready').css('display', 'none');
});


//key user search
$(add_borrow).find('button[name="key_search"]').on('click', function() {
    $.ajax({
        type : 'POST',
        url : '/doSearchUser',
        data : { 
            _token : $(add_borrow).find('input[name="_token"]').val(),
            search : $(add_borrow).find('input[name="key_search"]').val() 
        },
        dataType:'json',
        success : function(res) {
            if(res.status == 'success') {
                $(add_borrow).find('input[name="key_search"]').parent().addClass('has-success');
                $(add_borrow).find('input[name="key_upid"]').val(res.data.id);
                
                $(add_borrow).find('input[name="key_number"]').focus();
                $(add_borrow).find('input[name="key_number"]').css('display', 'block');
                $(add_borrow).find('.button[name="key_input"]').css('display', 'block');
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//key input
$(add_borrow).find('button[name="key_input"]').on('click', function() {

    var error = false;
    if($(add_borrow).find('input[name="key_upid"]').val().length == 0) {
        $(add_borrow).find('input[name="key_upid"]').parent().addClass('has-error');
        error = true;
    }
    if($(add_borrow).find('input[name="key_number"]').val().length == 0) {
        $(add_borrow).find('input[name="key_number"]').parent().addClass('has-error');
        rerror = true;
    }

    if(error) return;

    $.ajax({
            type : 'POST',
            url : '/doGetBooksDataFromNumber',
            data : { 
                _token : $(add_borrow).find('input[name="_token"]').val(),
                upid : $(add_borrow).find('input[name="key_upid"]').val(),
                number : $(add_borrow).find('input[name="key_number"]').val()
            },
            dataType:'json',
            success : function(res) {
                if(res.status=='success') {
                    $(add_borrow).find('.borrow_table tr').remove();
                    for(var index in res.data) {
                        $(add_borrow).find('.borrow_table').append('<tr data-bid="'+res.data[index].bid+'" data-id="'+res.data[index].id+'""><th><a href="" style="cursor: default; text-decoration:none;">'+res.data[index].title+'</a></th><th style="width: 10%; text-align: right;">'+res.data[index].name+'</th><th data-val="'+res.data[index].count+'"style="width: 14%; text-align: center;">'+res.data[index].count+'本</th><th style="width: 10px;"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></th></tr>');
                    }                    

                    $(add_borrow).find('input[name="key_number"]').val('');
                    $(add_borrow).find('input[name="key_number"]').focus();

                    if($(add_borrow).find('.borrow_table tr').length > 0) 
                        $(add_borrow).find('.group-data').css('display', 'block');
                }
                else if(res.status == 'not found') {
                    alert('找不到書籍或已經沒有庫存');
                }
                else {
                    if('key_search' in res) 
                        $(add_borrow).find('input[name="key_search"]').text(res.sambo);
                    if('key_number' in res) 
                        $(add_borrow).find('input[name="key_number"]').text(res.add); 
                }
                
            },
            error : function(res) {
                document.write(res.responseText);
                console.log(res);
            }
        });
});

//borrow record close
$(add_borrow).on('click','.close', function(){
    var id = $(this).parent('th').parent('tr').data('id'),
        pobj = $(this).parent('p').remove(),
        trobj = $(this).parent('th').parent('tr');
    $.ajax({
        type : 'DELETE',
        url : '/doDeleteTmpBorrow',
        data : { 
            _token : $(add_borrow).find('input[name="_token"]').val(),
            id : id
        },
        dataType:'json',
        success : function(res) {
            if(res == 'success') {
                $(pobj).remove();
                $(trobj).remove();
                $(add_borrow).find('.scan_ready').css('display', 'block');
                $(add_borrow).find('input[name="1017139number"]').val('');
                $(add_borrow).find('input[name="1017139number"]').focus();

                if($(add_borrow).find('.borrow_table tr').length == 0) 
                    $(add_borrow).find('.group-data').css('display', 'none');
            }
            // console.log(res);
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//borrow save
$(add_borrow).on('click', '.save', function(res) {
    var mode = $(add_borrow).find('input[name="mode"]').val();
    var upid = (mode=='key') ? $(add_borrow).find('input[name="key_upid"]').val() : $(add_borrow).find('input[name="scann_upid"]').val();
    var borrows = [];
    $.each($(add_borrow).find('.borrow_table tr'), function(index, obj) {
        
        borrows[index] = {
            'id' : $(obj).data('id'),
            'bbid': $(obj).data('bid'),
            'count': $(obj).find('th').eq(2).data('val'),
            'upid': upid
        };
    });

    
    $.ajax({
        type : 'POST',
        url : '/doAddBorrow',
        data : { 
            _token : $(add_borrow).find('input[name="_token"]').val(),
            data : borrows
        },
        dataType:'json',
        success : function(res) {
            if(res == 'success') {
                alert('登入成功');
                window.location.reload();
            }
            //console.log(res);
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//////count///////
//scann mode click
$(count_book).on('click', 'li', function() {
    if($(count_book).find('input[name="mode"]').val() == 'scann') {
        $(count_book).find('.scann_mode').show();
        $(count_book).find('.key_mode').hide();
    }
    else if($(count_book).find('input[name="mode"]').val() == 'key') {
        $(count_book).find('.scann_mode').hide();
        $(count_book).find('.key_mode').show();
    }

});

//scann count submit
$(count_book).find('button[name="scann_ready"]').on('click', function() {

    var tid = $(count_book).find('input[name="scann_temple"]').val(),
        location = $(count_book).find('input[name="scann_location"]').val();

    if(tid > 0 && location != '') {
        $(count_book).find('.table tr').remove();
        $(count_book).find('.ready').css('display','block');
        $(count_book).find('input[name="scann_number"]').focus();
    }
});

//scann  count scanning
$(count_book).find('input[name="scann_number"]').keydown(function(e) {
    if(e.which==13) {
        if(!$(count_book).find('.ready').is(':hidden')) {

            $.ajax({
                type : 'GET',
                url : '/doCountLocationBooks',
                data : $(count_book).serialize(),
                dataType:'json',
                success : function(res) {console.log(res);
                    if(res.status == 'success') {

                        tr = $(count_book).find('.table tr');
                        if(tr.length > 0) {
                            for(var index in tr) {
                                if(tr.eq(index).data('number') == $(count_book).find('input[name="scann_number"]').val()) {
                                    tr.eq(index).find('td').eq(0).removeClass('gainsboro');
                                }
                            }
                        }
                        else {
                            $(count_book).find('.table tr').remove();
                            thead = '<thead>' + 
                                        '<td>書籍</td><td>存放</td><td>借出</td><td>庫存</td><td>狀態</td>' + 
                                    '</thead>';

                            $(count_book).find('.table').append(thead);
                            for(var index in res.data) {
                                status = res.data[index].is_borrow=='true' ? '開放' : '-';
                                color = res.data[index].number!=$(count_book).find('input[name="scann_number"]').val() ? 'gainsboro' : '';
                                row = '<tr data-number="'+res.data[index].number+'">' + 
                                            '<td class="'+color+'">'+res.data[index].title+'</td>' +
                                            '<td>'+res.data[index].name+'</td>' +
                                            '<td>'+res.data[index].out+'</td>' +
                                            '<td>'+(res.data[index].count-res.data[index].out)+'</td>' +
                                            '<td>'+status+'</td>' +
                                        '</tr>';
                                $(count_book).find('.table').append(row);                                
                            }
                        }
                        $(count_book).find('input[name="scann_number"]').val('');
                        $(count_book).find('input[name="scann_number"]').focus();
                    }
                    // console.log(res);
                },
                error : function(res) {
                    document.write(res.responseText);
                    console.log(res);
                }
            });
        }
        else {

        }

        
    }
});

//not focus
$(count_book).find('input[name="scann_number"]').blur(function() {
    $(count_book).find('.table tr').remove();
    $(count_book).find('.ready').css('display','none');
});


//key count submit
$(count_book).find('button[name="key_ready"]').on('click', function() {

    $.ajax({
        type : 'GET',
        url : '/doCountLocationBooks',
        data : $(count_book).serialize(),
        dataType:'json',
        success : function(res) {

            if(res.status == 'success') {
                tr = $(count_book).find('.table tr');
                if(tr.length > 0) {
                    for(var index in tr) {
                        if(tr.eq(index).data('number') == $(count_book).find('input[name="key_number"]').val()) {
                            tr.eq(index).find('td').eq(0).removeClass('gainsboro');
                        }
                    }
                }
                else {
                    $(count_book).find('.table tr').remove();
                    thead = '<thead>' + 
                                '<td>書籍</td><td>存放</td><td>借出</td><td>庫存</td><td>狀態</td>' + 
                            '</thead>';

                    $(count_book).find('.table').append(thead);
                    for(var index in res.data) {
                        status = res.data[index].is_borrow=='true' ? '開放' : '-';
                        color = res.data[index].number!=$(count_book).find('input[name="key_number"]').val() ? 'gainsboro' : '';
                        row = '<tr data-number="'+res.data[index].number+'">' + 
                                    '<td class="'+color+'">'+res.data[index].title+'</td>' +
                                    '<td>'+res.data[index].name+'</td>' +
                                    '<td>'+res.data[index].out+'</td>' +
                                    '<td>'+(res.data[index].count-res.data[index].out)+'</td>' +
                                    '<td>'+status+'</td>' +
                                '</tr>';
                        $(count_book).find('.table').append(row);                                
                    }
                }
                $(count_book).find('input[name="key_number"]').val('');
                $(count_book).find('input[name="key_number"]').focus();
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});
