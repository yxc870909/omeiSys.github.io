var bk_recordjoin = $('#bk-recordjoin');


ddl(bk_recordjoin, 'year');
//ddl function
function ddl(el, cls) {
	$(el).on('click','.'+cls+' li',function(){
        $(el).find('button[name="'+cls+'"]').text($(this).text());
        $(el).find('button[name="'+cls+'"]').append('<span class="caret"></span>');
        $(el).find('input[name="'+cls+'"]').val($(this).data('val'));
    });
}