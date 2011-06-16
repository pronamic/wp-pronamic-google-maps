(function($) {
	/**
	 * Pronamic Google Maps meta box prototype
	 */
	var PronamicGoogleMapsMetaBox = function(element, options) {
		var obj = this;
		var element = $(element);

		// Fields
		var fields = {};
		fields.description = element.find("#pgm-description-field");
		fields.address = element.find("#pgm-address-field");
		fields.latitude = element.find("#pgm-lat-field");
		fields.longitude = element.find("#pgm-lng-field");
		fields.mapType = element.find("#pgm-map-type-field");
		fields.zoom = element.find("#pgm-zoom-field");
		
		// Canvas
		var canvas = element.find("#pgm-canvas").get(0);
		if(canvas) {
			var location =  new google.maps.LatLng(fields.latitude.val(), fields.longitude.val());

			var zoom = parseInt(fields.zoom.val());
			if(isNaN(zoom)) { zoom = 0; }

			var mapType = fields.mapType.val();
			if(mapType == "") { mapType = google.maps.MapTypeId.ROADMAP; }

			var options = {
				zoom: zoom , 
				center: location , 
				mapTypeId: mapType 
			};

			var map = new google.maps.Map(canvas, options);
			var geocoder = new google.maps.Geocoder();

			var marker = new google.maps.Marker({
				position: location , 
				map: map , 
				draggable: true
			});

			var infoWindow = new google.maps.InfoWindow({content: fields.description.val()});
			infoWindow.open(map, marker);

			element.find("#pgm-geocode-button").click(function() {
				obj.geocode();
				
				return false;
			});

			element.find("#pgm-reverse-geocode-button").click(function() {
				obj.reverseGeocode();
				
				return false;
			});
		}

		/**
		 * Update marker
		 */
		this.updateMarker = function() {
			var location =  new google.maps.LatLng(fields.latitude.val(), fields.longitude.val());

			marker.setPosition(location);
			map.setCenter(location);
		};

		/**
		 * Update fields
		 */
		this.updateFields = function() {
			var location = marker.getPosition();

			fields.latitude.val(location.lat());
			fields.longitude.val(location.lng());
			fields.zoom.val(map.getZoom());
			fields.mapType.val(map.getMapTypeId());
		};

		/**
		 * Geocode
		 */
		this.geocode = function() {
			var address = fields.address.val();
			var singleLineAddress = address.replace(/(\r\n|[\r\n])/g, ", ");

			geocoder.geocode({"address": singleLineAddress} , function(results, status) {
				if(status == google.maps.GeocoderStatus.OK) {
					if(results[0]) {
						var location = results[0].geometry.location;
						var viewport = results[0].geometry.viewport;

						fields.latitude.val(location.lat());
						fields.longitude.val(location.lng());

						marker.setPosition(location);

						map.setCenter(location);
						map.fitBounds(viewport);
					}
				} else {
					alert(status);
				}
			});
		};

		/**
		 * Reverse geocode
		 */
		this.reverseGeocode = function() {
			var location =  new google.maps.LatLng(fields.latitude.val(), fields.longitude.val());

			geocoder.geocode({"latLng": location} , function(results, status) {
				if(status == google.maps.GeocoderStatus.OK) {
					if(results[0]) {
						var address = results[0].formatted_address;

						fields.address.val(address);
					}
				} else {
					alert(status);
				}
			});
		};

		// Event handlers
		google.maps.event.addListener(map, "maptypeid_changed", obj.updateFields);
		google.maps.event.addListener(map, "zoom_changed", obj.updateFields);
		google.maps.event.addListener(marker, "drag", obj.updateFields);
		google.maps.event.addListener(marker, "dragend", obj.updateFields);

		fields.latitude.keyup(obj.updateMarker);
		fields.latitude.change(obj.updateMarker);
		fields.longitude.keyup(obj.updateMarker);
		fields.longitude.change(obj.updateMarker);

		fields.description.keyup(function() { infoWindow.setContent(fields.description.val()); });
		fields.description.change(function() { infoWindow.setContent(fields.description.val()); });
	};

	/**
	 * Pronamic Google Maps geocoder prototype
	 */
	var PronamicGoogleMapsGeocoder = function(element, options) {
		var obj = this;
		var element = $(element);

		// Fields
		var fields = {};
		fields.ID = element.find("#pgm-id-field");
		fields.title = element.find("#pgm-title-field");
		fields.address = element.find("#pgm-address-field");
		fields.latitude = element.find("#pgm-lat-field");
		fields.longitude = element.find("#pgm-lng-field");
		fields.mapType = element.find("#pgm-map-type-field");
		fields.zoom = element.find("#pgm-zoom-field");
		fields.foundPosts = element.find("#pgm-found-posts");
		fields.status = element.find("#pgm-status-field");

		// Geocoder
		var geocoder = new google.maps.Geocoder();

		// Submit
		element.find("#submit").click(function() {
			obj.startGeocode();

			return false;
		});

		/**
		 * Start geocode
		 */
		this.startGeocode = function() {
			var address = fields.address.val();
			var singleLineAddress = address.replace(/(\r\n|[\r\n])/g, ", ");

			geocoder.geocode({"address": singleLineAddress} , function(results, status) {
				fields.status.val(status);

				if(status == google.maps.GeocoderStatus.OK) {
					if(results[0]) {
						var location = results[0].geometry.location;
						var viewport = results[0].geometry.viewport;

						fields.latitude.val(location.lat());
						fields.longitude.val(location.lng());
					}
				}

				$.post(ajaxurl, element.serialize(), function(result) {
					obj.updateFields(result);
				});
			});
		};

		/**
		 * Update fields
		 */
		this.updateFields = function(result) {
			fields.foundPosts.text(result.foundPosts);

			if(result.nextPost) {
				var post = result.nextPost;

				fields.ID.val(post.ID);
				fields.title.val(post.title);
				fields.address.val(post.address);
				fields.latitude.val(post.latitude);
				fields.longitude.val(post.longitude);

				obj.startGeocode();
			} else {
				element.hide();
			} 
		}
	};

	/**
	 * jQuery plugin - Pronamic Google Maps meta box
	 */
	$.fn.pronamicGoogleMapsMetaBox = function(options) {
		return this.each(function() {
			var element = $(this);

			if(element.data('pgm-meta-box')) return;

			var geocoder = new PronamicGoogleMapsMetaBox(this, options);

			element.data('pgm-meta-box', geocoder);
		});
	};

	/**
	 * jQuery plugin - Pronamic Google Maps geocoder
	 */
	$.fn.pronamicGoogleMapsGeocoder = function(options) {
		return this.each(function() {
			var element = $(this);

			if(element.data('pgm-geocoder')) return;

			var geocoder = new PronamicGoogleMapsGeocoder(this, options);

			element.data('pgm-geocoder', geocoder);
		});
	};

	$(document).ready(function() {
		$("#pronamic-google-maps-meta-box").pronamicGoogleMapsMetaBox();
		$("#pgm-geocoder").pronamicGoogleMapsGeocoder();
	});
})(jQuery);