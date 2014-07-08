$(function() {
	
	function generatePassword( event ) {
		
		if (event) {
			event.preventDefault();
		}
		
		var $form = $( "#password-form" ),
		url = $form.attr( "action" );

		var post = 	$.ajax({
						type: "POST",
						url: url,
						data: $form.serialize(),
						dataType: "json"
					});

		post.done(function( data ) {
			if (data.result == "success") {
				$( "#password-field h4" ).text( data.password );
			} else {
				$( "#password-field h4" ).text( "Something went wrong parsing the word list." );
			}
		});
	}

	generatePassword();

	$( "#password-form" ).submit( generatePassword );
});