jQuery(document).ready(function($) {

	$('.form-shorten').on('click', '#button-shorten', function(event) {
		event.preventDefault();
		// Cache selectors
		var $input_shorten = $('#input-shorten');
		var $button_shorten = $(this);
		var $response_shorten = $('#response-shorten');

		// Add loading state to the form
		$button_shorten.addClass('progress-bar progress-bar-striped progress-bar-animated');
		$button_shorten.prop('disabled', true)
		$input_shorten.prop('readonly', true);

		$.ajax({
			url: 'api/store',
			type: 'POST',
			dataType: 'json',
			data: {
				longurl: $input_shorten.val()
			},
		})
		.done(function(res) {
			$input_shorten.val('');
			$response_shorten.html(res.data.message + '<br>' + res.data.url + '<br>' + res.data.stats).fadeIn();
		})
		.fail(function() {
			$response_shorten.html(res.data.message).fadeIn();
		})
		.always(function() {
			// Remove loading state from the form
			$button_shorten.removeClass('progress-bar progress-bar-striped progress-bar-animated');
			$button_shorten.prop('disabled', false)
			$input_shorten.prop('readonly', false);
		});
		
	});

});