jQuery(document).ready(function($) {

	$('.form-shorten').on('click', '#button-shorten', function(event) {
		event.preventDefault();
		// Cache selectors
		var $input_shorten = $('#input-shorten');
		var $button_shorten = $(this);
		var $response_shorten = $('#response-shorten');

		// Add loading state to the form
		$button_shorten.addClass('progress-bar-striped progress-bar-animated');
		$button_shorten.prop('disabled', true)
		$input_shorten.prop('readonly', true);
		$response_shorten.fadeOut('fast');

		$.ajax({
			url: 'api/urls',
			type: 'POST',
			dataType: 'json',
			data: {
				longurl: $input_shorten.val()
			},
		})
		.done(function(res) {
			$input_shorten.val('');
			$response_shorten.html(res.message + '<br>' + res.data.short_url + '<br>' + res.data.stats).fadeIn();
		})
		.fail(function(xhr, status, error) {
			var res = JSON.parse(xhr.responseText);
            $response_shorten.html(res.message).fadeIn('fast');
		})
		.always(function() {
			// Remove loading state from the form
			$button_shorten.removeClass('progress-bar-striped progress-bar-animated');
			$button_shorten.prop('disabled', false)
			$input_shorten.prop('readonly', false);
		});
		
	});

});