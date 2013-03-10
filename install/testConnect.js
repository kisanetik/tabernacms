jQuery(function ($) {

	$(document).on('click', 'input.test_connect', function () {

		var form = $('form.data-form');
		var host = form.find('input[name="host"]').val();
		var login = form.find('input[name="login"]').val();
		var password = form.find('input[name="password"]').val();
		var dbname = form.find('input[name="dbname"]').val();

		if (host != '' && login != '' && dbname != '') {
			$('div.row').removeClass('error');

			$('#ajax_indication').show(0);
			$('#error_msg').hide(0);

			jQuery.post("3",
				{'method': 'ajax', 'host': host, 'login': login, 'password': password, 'dbname': dbname},
				function (error) {

					$('#ajax_indication').hide(0);

					if (!error){
						form.find('input.test_connect').removeClass('test_connect').val($('#next_value').text());
						$('#success_msg').show();
					} else {
						$('#error_msg').text(error).show(0);
					}
				}
			);

			return false;
		} else return true;
	});

});