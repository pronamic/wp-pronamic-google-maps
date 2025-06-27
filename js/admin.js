/*jshint unused:false */
/* global google */
/* global ajaxurl */
(function( $ ) {
	/**
	 * Pronamic Google Maps meta box prototype
	 */
	var PronamicGoogleMapsMetaBox = function( element, options ) {
		var obj      = this;
		var $element = $( element );
		var map      = null;
		var marker   = null;

		// Fields
		var fields = {};
		fields.description = $element.find( '#pgm-description-field' );
		fields.address     = $element.find( '#pgm-address-field' );
		fields.latitude    = $element.find( '#pgm-lat-field' );
		fields.longitude   = $element.find( '#pgm-lng-field' );
		fields.mapType     = $element.find( '#pgm-map-type-field' );
		fields.zoom        = $element.find( '#pgm-zoom-field' );
		
		// Canvas
		var canvas = $element.find( '#pgm-canvas' ).get( 0 );
		if ( canvas ) {
			var location =  new google.maps.LatLng( fields.latitude.val(), fields.longitude.val() );

			var zoom = parseInt( fields.zoom.val(), 10 );
			if ( isNaN( zoom ) ) { zoom = 0; }

			var mapType = fields.mapType.val();
			if ( '' === mapType ) { mapType = google.maps.MapTypeId.ROADMAP; }

			var mapOptions = {
				zoom: zoom,
				center: location,
				mapTypeId: mapType
			};

			map = new google.maps.Map( canvas, mapOptions );
			var geocoder = new google.maps.Geocoder();

			marker = new google.maps.Marker( {
				position: location,
				map: map,
				draggable: true
			} );

			var infoWindow = new google.maps.InfoWindow( { content: fields.description.val() } );
			infoWindow.open( map, marker );

			$element.find( '#pgm-geocode-button' ).on( 'click', function() {
				obj.geocode();
				
				return false;
			} );

			$element.find( '#pgm-reverse-geocode-button' ).on( 'click', function() {
				obj.reverseGeocode();
				
				return false;
			} );
		}

		/**
		 * Update marker
		 */
		this.updateMarker = function() {
			var location =  new google.maps.LatLng( fields.latitude.val(), fields.longitude.val() );

			marker.setPosition( location );
			map.setCenter( location );
		};

		/**
		 * Update fields
		 */
		this.updateFields = function() {
			var location = marker.getPosition();

			fields.latitude.val( location.lat() );
			fields.longitude.val( location.lng() );
			fields.zoom.val( map.getZoom() );
			fields.mapType.val( map.getMapTypeId() );
		};

		/**
		 * Geocode
		 */
		this.geocode = function() {
			var address = fields.address.val();
			var singleLineAddress = address.replace( /(\r\n|[\r\n])/g, ', ' );

			geocoder.geocode( { 'address': singleLineAddress } , function( results, status ) {
				if ( google.maps.GeocoderStatus.OK === status ) {
					if ( results[0] ) {
						var location = results[0].geometry.location;
						var viewport = results[0].geometry.viewport;

						fields.latitude.val( location.lat() );
						fields.longitude.val( location.lng() );

						marker.setPosition( location );

						map.setCenter( location );
						map.fitBounds( viewport );
					}
				} else {
					
				}
			} );
		};

		/**
		 * Reverse geocode
		 */
		this.reverseGeocode = function() {
			var location =  new google.maps.LatLng( fields.latitude.val(), fields.longitude.val() );

			geocoder.geocode( { 'latLng': location } , function( results, status ) {
				if ( google.maps.GeocoderStatus.OK === status ) {
					if ( results[0] ) {
						var address = results[0].formatted_address;

						fields.address.val( address );
					}
				} else {
					
				}
			} );
		};

		// Event handlers
		google.maps.event.addListener( map, 'maptypeid_changed', obj.updateFields );
		google.maps.event.addListener( map, 'zoom_changed', obj.updateFields );
		google.maps.event.addListener( marker, 'drag', obj.updateFields );
		google.maps.event.addListener( marker, 'dragend', obj.updateFields );

		fields.latitude.on( 'keyup change', obj.updateMarker );
		fields.longitude.on( 'keyup change', obj.updateMarker );
		fields.description.on( 'keyup change', function() { infoWindow.setContent( fields.description.val() ); } );
	};
	
	/**
	 * Pronamic Google Maps widget prototype
	 */
	var PronamicGoogleMapsWidget = function( element, options ) {
		var obj      = this;
		var $element = $(element);

		// Fields
		var fields = {};
		fields.latitude    = $element.find( '.latitude-field' );
		fields.longitude   = $element.find( '.longitude-field' );
		fields.description = $element.find( '.description-field' );
		fields.mapType     = $element.find( '.map-type-field' );
		fields.zoom        = $element.find( '.zoom-field' );

		// Canvas
		var canvas = $element.find( '.google-maps-canvas' );

		var location =  new google.maps.LatLng( fields.latitude.val(), fields.longitude.val() );

		var zoom = parseInt( fields.zoom.val(), 10 );
		if ( isNaN( zoom ) ) { zoom = 0; }
		
		var mapType = fields.mapType.val();
		if ( '' === mapType ) { mapType = google.maps.MapTypeId.ROADMAP; }

		var mapOptions = {
			zoom: zoom,
			center: location,
			mapTypeId: mapType 
		};

		var map = new google.maps.Map( canvas.get( 0 ), mapOptions );

		var marker = new google.maps.Marker( {
			position: location,
			map: map,
			draggable: true
		} );
		
		var infoWindow = new google.maps.InfoWindow( { content: fields.description.val() } );
		infoWindow.open( map, marker );

		var updateMarker = function() {
			var location =  new google.maps.LatLng( fields.latitude.val(), fields.longitude.val() );

			marker.setPosition( location );
			map.setCenter( location );
		};

		var updateFields = function() {
			var location = marker.getPosition();

			fields.latitude.val( location.lat() );
			fields.longitude.val( location.lng() );
			fields.zoom.val( map.getZoom() );
			fields.mapType.val( map.getMapTypeId() );
		};

		google.maps.event.addListener( map, 'maptypeid_changed', updateFields );
		google.maps.event.addListener( map, 'zoom_changed', updateFields );
		google.maps.event.addListener( marker, 'drag', updateFields );
		google.maps.event.addListener( marker, 'dragend', updateFields );

		fields.latitude.on( 'keyup change', updateMarker );
		fields.longitude.on( 'keyup change', updateMarker );
		fields.description.on( 'keyup change', function() { infoWindow.setContent( fields.description.val() ); } );

		// The widget area is resized, wich is causing a buggy Google Maps, this function fixes that issue
		var fixMap = function() {
			google.maps.event.trigger( map, 'resize' );

			map.setCenter( location );
		};

		$element.closest( '.widget' ).find( '.widget-action' ).on( 'click', function() { setTimeout( fixMap, 1000 ); } );
		$element.closest( '.widget' ).on( 'click', function() {
			if ( ! $( this ).hasClass( 'open' ) ) {
				setTimeout( fixMap, 1000 );
			}
		} );
	};
	
	/**
	 * Pronamic Google Maps geocoder prototype
	 */
	var PronamicGoogleMapsGeocoder = function( element, options ) {
		var obj = this;
		var $element = $(element);

		// Fields
		var fields = {};
		fields.ID         = $element.find( '#pgm-id-field' );
		fields.title      = $element.find( '#pgm-title-field' );
		fields.address    = $element.find( '#pgm-address-field' );
		fields.latitude   = $element.find( '#pgm-lat-field' );
		fields.longitude  = $element.find( '#pgm-lng-field' );
		fields.mapType    = $element.find( '#pgm-map-type-field' );
		fields.zoom       = $element.find( '#pgm-zoom-field' );
		fields.foundPosts = $element.find( '#pgm-found-posts' );
		fields.status     = $element.find( '#pgm-status-field' );

		// Geocoder
		var geocoder = new google.maps.Geocoder();

		// Submit
		$element.find( '#submit' ).on( 'click', function() {
			obj.startGeocode();

			return false;
		} );

		/**
		 * Start geocode
		 */
		this.startGeocode = function() {
			var address = fields.address.val();
			var singleLineAddress = address.replace( /(\r\n|[\r\n])/g, ', ' );

			geocoder.geocode( { 'address': singleLineAddress } , function( results, status ) {
				fields.status.val( status );

				if ( google.maps.GeocoderStatus.OK === status ) {
					if ( results[0] ) {
						var location = results[0].geometry.location;
						var viewport = results[0].geometry.viewport;

						fields.latitude.val( location.lat() );
						fields.longitude.val( location.lng() );
					}
				}

				$.post( ajaxurl, $element.serialize(), function( result ) {
					obj.updateFields( result );
				} );
			} );
		};

		/**
		 * Update fields
		 */
		this.updateFields = function( result ) {
			fields.foundPosts.text( result.foundPosts );

			if ( result.nextPost ) {
				var post = result.nextPost;

				fields.ID.val( post.ID );
				fields.title.val( post.title );
				fields.address.val( post.address );
				fields.latitude.val( post.latitude );
				fields.longitude.val( post.longitude );
				fields.status.val( '' );

				// Google Maps Geocoding API Usage Limits
				// https://developers.google.com/maps/documentation/geocoding/usage-limits
				// 10 requests per second
				setTimeout( function() {
					obj.startGeocode();
				}, 10000 );				
			} else {
				$element.hide();
			} 
		};
	};
	
	/**
	 * jQuery plugin - Pronamic Google Maps meta box
	 */
	$.fn.pronamicGoogleMapsMetaBox = function( options ) {
		return this.each( function() {
			var element = $( this );

			if ( element.data( 'pgm-meta-box' ) ) {
				return;
			}

			var geocoder = new PronamicGoogleMapsMetaBox( this, options );

			element.data( 'pgm-meta-box', geocoder );
		} );
	};
	
	/**
	 * jQuery plugin - Pronamic Google Maps geocoder
	 */
	$.fn.pronamicGoogleMapsWidget = function( options ) {
		return this.each( function() {
			var element = $( this );

			if ( element.data( 'pgm-widget' ) ) {
				return;
			}

			var widget = new PronamicGoogleMapsWidget( this, options );

			element.data( 'pgm-widget', widget );
		} );
	};
	
	/**
	 * jQuery plugin - Pronamic Google Maps geocoder
	 */
	$.fn.pronamicGoogleMapsGeocoder = function( options ) {
		return this.each( function() {
			var element = $( this );

			if ( element.data( 'pgm-geocoder' ) ) {
				return;
			}

			var geocoder = new PronamicGoogleMapsGeocoder( this, options );

			element.data( 'pgm-geocoder', geocoder );
		} );
	};
	
	/**
	 * Initialize
	 */
	var initialize = function() {
		$( '#pronamic-google-maps-meta-box' ).pronamicGoogleMapsMetaBox();

		$( '#pgm-geocoder' ).pronamicGoogleMapsGeocoder();

		$( '#widgets-right .pronamic-google-maps-widget' ).pronamicGoogleMapsWidget();

		jQuery( 'div[id$="_pronamic_google_maps-__i__"]' ).on( 'dragstop', function() {
			$( '#widgets-right .pronamic-google-maps-widget' ).pronamicGoogleMapsWidget();
		} );
	};

	window.initPronamicGoogleMaps = initialize;
} )( jQuery );
