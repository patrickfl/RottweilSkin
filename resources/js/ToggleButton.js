( function( d, $, mw ) {
	$( '.rw-toggle-button' ).on( 'click', function( e ){
		e.preventDefault();

		var item =  $( this ).attr( 'data-toggle' );
		var toggle =  $( this ).attr( 'data-toggleClass' );

		var target = 'body > .container .' + item;

			$( '.rw-toggle-button.open' ).each( function( index, element ){
				var openItem =  $( element ).attr( 'data-toggle' );
				var openToggle =  $( element ).attr( 'data-toggleClass' );
				var openTarget = 'body > .container .' + openItem;
				if ( openItem != item) {
					$( openItem ).removeClass( 'open' );
					$( openTarget ).addClass( openToggle );
				}

			});

		if ( $( target ).hasClass( toggle ) ) {
			$( this ).addClass( 'open' );
			$( target ).removeClass( toggle );
		}
		else {
			$( this ).removeClass( 'open' );
			$( target ).addClass( toggle );
		}
	});
})( document, jQuery, mediaWiki );

