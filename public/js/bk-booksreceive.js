var booksreceive = $('#bk-booksreceive');
var edit_book = booksreceive.find('form[name="edit_book"]'),
    count_book = booksreceive.find('form[name="count_book"]'),
    view_book = booksreceive.find('form[name="view_book"]'),
    edit_record = booksreceive.find('form[name="edit_record"]');

ddl(edit_book, 'temple');
ddl(edit_book, 'type');
ddl(edit_book, 'type2');
ddl(edit_book, 'lan');
ddl(edit_record, 'status');
ddl(count_book, 'temple');
//ddl function
function ddl(el, cls) {
	$(el).on('click','.'+cls+' li',function(){
        $(el).find('button[name="'+cls+'"]').text($(this).text());
        $(el).find('button[name="'+cls+'"]').append('<span class="caret"></span>');
        $(el).find('input[name="'+cls+'"]').val($(this).data('val'));
    });
}

//get book data
$(booksreceive).find('.edit_btn').on('click', function() {
    
    var id = $(this).data('val');
    $.ajax({
        type : 'GET',
        url : '/doGetReceiveData',
        data : { id : id, },
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
                    console.log(res.data[0].img);
                    $(edit_book).find('#img').attr('src', '/upload/receive/'+res.data[0].img);
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
        url : '/doEditReceive',
        data : $(edit_book).serialize() + "id=" + $(edit_book).find('input[name="id"]').val(),
        dataType:'json',
        success : function(res) {

            $(edit_book).find('.error-temple').text('');
            $(edit_book).find('input[name="book_name"]').parent().removeClass("has-error");
            $(edit_book).find('.upload').css('color','#ddd');
            $(edit_book).find('.error-type').text('');
            $(edit_book).find('.error-lan').text('');
            $(edit_book).find('input[name="pub_year"]').parent().removeClass("has-error");

            if(res == 'success') {
                alert('修改成功');
                window.location.reload();
            }
            else {
                if('temple' in res) 
                    $(edit_book).find('.error-temple').text('* 該欄位項目尚未選擇');
                if('book_name' in res) 
                    $(edit_book).find('input[name="book_name"]').parent().addClass("has-error");
                if('upload' in res)
                    $(edit_book).find('.upload').css('color','#d64e4e');
                if('type' in res || 'type2' in res) 
                    $(edit_book).find('.error-type').text('* 該欄位項目尚未選擇');
                if('lan' in res) 
                    $(edit_book).find('.error-lan').text('* 該欄位項目尚未選擇');
                if('pub_year' in res) 
                    $(edit_book).find('input[name="pub_year"]').parent().addClass("has-error");
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
$(booksreceive).find('img[name="item_img"]').on('click', function() {
    
    var id = $(this).data('val');
    $.ajax({
        type : 'GET',
        url : '/doGetReceiveData',
        data : { id : $(this).data('val'), },
        dataType:'json',
        success : function(res) {
            if(res.status == 'success') {

                $(view_book).find('label[name="temple"]').text(res.data[0].name);
                $(view_book).find('label[name="cat"]').text(res.data[0].attribute);

                var lan = "";
                if(res.data[0].lan =='tran_chinese')
                    lan = '中文';
                $(view_book).find('label[name="lan"]').text(lan);

                $(view_book).find('label[name="title"]').text(res.data[0].title);

                if(res.data[0].img.length > 0) {
                    $(view_book).find('#img').attr('src', '/upload/subscription/'+res.data[0].img);   
                }

                $(view_book).find('input[name="id"]').val(id);
                $(view_book).find('label[name="author"]').text(res.data[0].author);
                $(view_book).find('label[name="isbn"]').text(res.data[0].isbn);
                $(view_book).find('label[name="pub_year"]').text(res.data[0].pub_year);
                $(view_book).find('label[name="version"]').text(res.data[0].version);
                $(view_book).find('label[name="no"]').text(res.data[0].no);
            }
            console.log(res);
        },
        error : function(res) {}
    });
});

//add rcord
$(view_book).find('button[name="save"]').on('click', function() {
    $.ajax({
        type : 'POST',
        url : '/doAddRecvApplication',
        data : $(view_book).serialize(),
        dataType:'json',
        success : function(res) {

            $(view_book).find('input[name="count"]').parent().removeClass('has-error');
            if(res == 'success') {
                alert('申請成功');
                window.location.reload();
            }
            else {
                alert('請檢查領取數量');
                $(view_book).find('input[name="count"]').parent().addClass('has-error');
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});


//get book data
$(booksreceive).find('.record_table tr').on('click', function() {

   var id = $(this).data('val');
   $.ajax({
     type : 'GET',
        url : '/doGetReceiveRecordData',
        data : { id : id, },
        dataType:'json',
        success : function(res) {
            if(res.status == 'success') {

                $(edit_record).find('.status li').each(function() {     
                           
                    if($(this).data('val') == res.data[0].status) {

                        // $(this).addClass('active');
                        $(edit_record).find('button[name="status"]').text($(this).text());
                        $(edit_record).find('button[name="status"]').append('<span class="caret"></span>');
                        if(res.data[0].status == 'process') {
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

                $(edit_record).find('input[name="id"]').val(id);
                $(edit_record).find('label[name="author"]').text(res.data[0].author);
                $(edit_record).find('label[name="isbn"]').text(res.data[0].isbn);
                $(edit_record).find('label[name="pub_year"]').text(res.data[0].pub_year);
                $(edit_record).find('label[name="version"]').text(res.data[0].version);
                $(edit_record).find('label[name="no"]').text(res.data[0].no);
            }
            
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
   }); 
});

//search user
$(edit_record).find('button[name="search"]').on('click', function() {

    $.ajax({
        type : 'POST',
        url : '/doSearchUser',
        data : { 
            _token : $(edit_record).find('input[name="_token"]').val(),
            search : $(edit_record).find('input[name="search"]').val(), 
        },
        dataType:'json',
        success : function(res) {
            if(res.status == 'success') {
                $(edit_record).find('input[name="search"]').parent().addClass('has-success');
                $(edit_record).find('input[name="upid"]').val(res.data.id);
            }
        },
        error : function(res) {
            document.write(res.responseText);
            console.log(res);
        }
    });
});

//edit record
$(edit_record).find('button[name="save"]').on('click', function() {

    $.ajax({
        type : 'POST',
        url : '/doEditReceiveRecord',
        data : $(edit_record).serialize(),
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


//count submit
$(count_book).find('button[name="ready"]').on('click', function() {

    var tid = $(count_book).find('input[name="temple"]').val(),
        location = $(count_book).find('input[name="location"]').val();

    if(tid > 0 && location != '') {
        $(count_book).find('.table tr').remove();
        $(count_book).find('.ready').css('display','block');
        $(count_book).find('input[name="number"]').focus();
    }
});

//count scanning
$(count_book).find('input[name="number"]').keydown(function(e) {
    if(e.which==13) {
        if(!$(count_book).find('.ready').is(':hidden')) {

            $.ajax({
                type : 'GET',
                url : '/doCountLocationRcevBooks',
                data : $(count_book).serialize(),
                dataType:'json',
                success : function(res) {
                    if(res.status == 'success') {

                        tr = $(count_book).find('.table tr');
                        if(tr.length > 0) {
                            for(var index in tr) {
                                if(tr.eq(index).data('number') == $(count_book).find('input[name="number"]').val()) {
                                    tr.eq(index).find('td').eq(0).removeClass('gainsboro');
                                }
                            }
                        }
                        else {
                            $(count_book).find('.table tr').remove();
                            thead = '<thead>' + 
                                        '<td>書籍</td><td>存放</td><td>庫存</td>' + 
                                    '</thead>';

                            $(count_book).find('.table').append(thead);
                            for(var index in res.data) {
                                color = res.data[index].number!=$(count_book).find('input[name="number"]').val() ? 'gainsboro' : '';
                                row = '<tr data-number="'+res.data[index].number+'">' + 
                                            '<td class="'+color+'">'+res.data[index].title+'</td>' +
                                            '<td>'+res.data[index].name+'</td>' +
                                            '<td>'+res.data[index].count+'</td>' +
                                        '</tr>';
                                $(count_book).find('.table').append(row);                                
                            }
                        }
                        $(count_book).find('input[name="number"]').val('');
                        $(count_book).find('input[name="number"]').focus();
                    }
                    console.log(res);
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
$(count_book).find('input[name="number"]').blur(function() {
    $(count_book).find('.table tr').remove();
    $(count_book).find('.ready').css('display','none');
});