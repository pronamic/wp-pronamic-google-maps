jQuery( document ).ready( function( $ ) {
	// Bootstrap Tabs and Google Maps
	$( '.pgm' ).on( 'pronamic-google-maps-ready', function( e ) {
		var map = $( this ).data( 'google-maps' );

		$( '.tab-with-map' ).on( 'shown.bs.tab', function( e ) {
			var center = map.getCenter();

			google.maps.event.trigger( map, 'resize' );

			map.setCenter( center ); 
		} );
	} );
} );
