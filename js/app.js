$(function() {
	$( "#password-form" ).submit(function( event ) {
		event.preventDefault();
		
		var $form = $( this ),
		url = $form.attr( "action" ),
		length = $form.find( "select[id='length']" ).val();
		//separator = 

		var post = $.post( url, $form.serialize() );
		console.log($form.serialize());
		post.done(function( data ) {
			alert(data);
		});

	});
});