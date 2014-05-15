jQuery( document ).ready( function( $ ) {
	$( '.pgm' ).on( 'pronamic-google-maps-ready', function() {
		var map = $( this ).data( 'google-maps' );

		var friesland = new google.maps.LatLng( 53.16, 5.78 );

		map.panTo( friesland );
		map.setZoom( 4 );
	} );
} );
