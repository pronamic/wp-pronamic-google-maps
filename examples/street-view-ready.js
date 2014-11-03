jQuery( document ).ready( function( $ ) {
	$( '.pgm' ).on( 'pronamic-google-maps-ready', function() {
		var map = $( this ).data( 'google-maps' );

		panorama = map.getStreetView();
		panorama.setPosition( map.getCenter() );
		panorama.setPov(/** @type {google.maps.StreetViewPov} */ ( {
			heading: 265,
			pitch: 0
		} ) );
		panorama.setVisible( true );
	} );
} );
