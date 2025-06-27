/* global google */
/* global pronamic_google_maps_settings */
/* global MarkerClusterer */
/* global OverlappingMarkerSpiderfier */
(function( $ ) {
	var methods = {
		/**
		 * Build map
		 *
		 * @param s an jQuery selector
		 */
		buildMap: function( s ) {
			var element = $( s );

			var input = element.find( 'input[name="pgm-info"]' );

			if ( input.length < 1 ) {
				return;
			}

			var info = JSON.parse( input.val() );

			var canvas = element.find( '.canvas' ).get( 0 );

			if ( canvas ) {
				// Location
				var location = new google.maps.LatLng( info.latitude, info.longitude );

				// Map options
				var mapOptions = $.extend( {
						center: location
					},
					info.mapOptions
				);

				var map = new google.maps.Map( canvas, mapOptions );

				// Marker options
				var markerOptions = $.extend( {
						position: location,
						map: map
					},
					info.markerOptions
				);

				var marker = new google.maps.Marker( markerOptions );

				element.data( 'google-maps', map);
				element.data( 'google-maps-marker', marker );

				var infoWindow = new google.maps.InfoWindow( { content: info.description } );

				google.maps.event.addListener( marker, 'click', function() {
					infoWindow.open( map, marker );
				} );

				// Trigger ready event
				element.trigger( 'pronamic-google-maps-ready', map );
			}
		},

		/**
		 * Build mashup
		 *
		 * @param s an jQuery selector
		 */
		buildMashup: function( s ) {
			var element = $( s );

			var list = element.find( 'ul' );

			var mashupInfo = JSON.parse( element.find( 'input[name="pgmm-info"]' ).val());

			var canvas = element.find( '.canvas' ).get( 0 );

			if ( canvas ) {
				if ( mashupInfo.hideList ) {
					list.hide();
				}

				var center = new google.maps.LatLng( mashupInfo.center.latitude, mashupInfo.center.longitude );

				// Map options
				var mapOptions = $.extend( {
						center: center
					},
					mashupInfo.mapOptions
				);

				var map = new google.maps.Map( canvas, mapOptions );

				// MarkerClustererPlus options
				var markerClusterer = false;
				if ( mashupInfo.markerClustererOptions ) {
					markerClusterer = new MarkerClusterer( map, [], mashupInfo.markerClustererOptions );
				}

				// OverlappingMarkerSpiderfier
				var overlappingMarkerSpiderfier = false;
				if ( mashupInfo.overlappingMarkerSpiderfierOptions ) {
					overlappingMarkerSpiderfier = new OverlappingMarkerSpiderfier( map, mashupInfo.overlappingMarkerSpiderfierOptions );
				}

				// Associated the Google Maps with the element so other developers can easily retrieve the Google Maps object
				element.data( 'google-maps', map );

				// Create one info window where the details from the posts will be displayed in
				var infoWindow = new google.maps.InfoWindow();

				// Create an bounds object so we can fit the map to show all posts
				var bounds = new google.maps.LatLngBounds();

				$.each( mashupInfo.markers, function( i, info ) {
					var location = new google.maps.LatLng( info.lat, info.lng );

					var markerOptions = $.extend( {
							position: location
						},
						info.options
					);

					var marker = new google.maps.Marker( markerOptions );

					google.maps.event.addListener( marker, 'click', function() {
						infoWindow.setContent( info.description );
						infoWindow.open( map, marker );

						element.trigger( 'pronamic-google-maps-infowindow-open', infoWindow );
					} );

					if ( markerClusterer ) {
						markerClusterer.addMarker( marker, false );
					}

					if ( overlappingMarkerSpiderfier ) {
						overlappingMarkerSpiderfier.addMarker( marker );
					}

					marker.setMap( map );

					// Extends the bounds object with this location so we can fit the map to show all posts
					bounds.extend( location );
				});

				if ( markerClusterer ) {
					markerClusterer.repaint();
				}

				if ( mashupInfo.fitBounds ) {
					map.fitBounds( bounds );
				}

				// Trigger ready event
				element.trigger( 'pronamic-google-maps-ready', map );
			}
		}
	};

	/**
	 * The Pronamic Google Maps jQuery plugin function
	 */
	$.fn.pronamicGoogleMaps = function() {
		return this.each( function() {
			methods.buildMap( this );
		} );
	};

	/**
	 * The Pronamic Google Maps mashup jQuery plugin function
	 */
	$.fn.pronamicGoogleMapsMashup = function() {
		return this.each( function() {
			methods.buildMashup( this );
		} );
	};

	/**
	 * Initialize
	 */
	var initialize = function() {
		$( '.pgm' ).pronamicGoogleMaps();

		$( '.pgmm' ).pronamicGoogleMapsMashup();
	};

	window.initPronamicGoogleMaps = initialize;
} )( jQuery );
