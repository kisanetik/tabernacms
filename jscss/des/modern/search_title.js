$(document).ready(function() {
	var search_form = $('#title-search');

	var category_el = search_form.find('#category');
	var updateSearchIblock = function (){
		var text = $(this).find(':selected').text();
		if (text)
			category_el.text( text );
        /*
		search_form.find('#title-search-input').css( 'padding-left', category_el.width() + 35 );
		search_form.find('#title-search-input').css( 'width', 373 - category_el.width()  );
		*/
        $( document.body ).trigger( 'updateSearchField' );
		search_form.find('#category-block').removeClass('active');

	}
	search_form.find( '#category-select' ).change(updateSearchIblock);

	search_form.find( '#category-select' ).focusin( function() {
		search_form.find('#category-block').addClass('active');
	})
	search_form.find( '#category-select' ).focusout( function() {
		search_form.find('#category-block').removeClass('active');
	})
	updateSearchIblock();
});
