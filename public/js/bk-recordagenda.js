var bk_recordagenda = $('#bk-recordagenda');


ddl(bk_recordagenda, 'year');
//ddl function
function ddl(el, cls) {
	$(el).on('click','.'+cls+' li',function(){
        $(el).find('button[name="'+cls+'"]').text($(this).text());
        $(el).find('button[name="'+cls+'"]').append('<span class="caret"></span>');
        $(el).find('input[name="'+cls+'"]').val($(this).data('val'));
    });
}