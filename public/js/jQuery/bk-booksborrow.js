
var bk_booksborrow = $('#bk-booksborrow');
var add_book = bk_booksborrow.find('#Add_book');


ddl(add_book, 'temple');
ddl(add_book, 'type');
ddl(add_book, 'lan');
//ddl function
function ddl(el, cls) {
	$(el).on('click','.'+cls+' li',function(){
        $(el).find('button[name="'+cls+'"]').text($(this).text());
        $(el).find('button[name="'+cls+'"]').append('<span class="caret"></span>');
        $(el).find('input[name="'+cls+'"]').val($(this).data('val'));
    });
}


$(add_book).find('button[name="save"]').on('click', function() {(
	alert(123);
	// $.ajax({
	// 	type: 'POST',
 //        url: '/doAddBooks',
 //        data: $(add_book).serialize(),
 //        dataType: 'json',
 //        success : function(res) {
 //        	console.log(res);
 //        },
 //        error : function(res) {}
	// });
});