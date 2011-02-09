/**
 * jQuery plugin - Pronamic Google Maps meta box
 */
(function($) {
	var methods = {
		getFields: function(metaBox) {
			var fields = {};

			fields.latitude = metaBox.find("#pgm-lat-field");
			fields.longitude = metaBox.find("#pgm-lng-field");
			fields.description = metaBox.find("#pgm-description-field");
			fields.mapType = metaBox.find("#pgm-map-type-field");
			fields.zoom = metaBox.find("#pgm-zoom-field");
			fields.search = metaBox.find("#pgm-search-field");

			return fields;
		} , 

		buildMetaBox: function(s) { 
			var metaBox = jQuery(s);

			var canvas = metaBox.find("#pgm-canvas").get(0);

			if(canvas) {
				var fields = methods.getFields(metaBox);
				var searchButton = metaBox.find("#pgm-search-button");
	
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

				var updateMarker = function() {
					var location =  new google.maps.LatLng(fields.latitude.val(), fields.longitude.val());

					marker.setPosition(location);
					map.setCenter(location);
				};

				var updateFields = function() {
					var location = marker.getPosition();

					fields.latitude.val(location.lat());
					fields.longitude.val(location.lng());
					fields.zoom.val(map.getZoom());
					fields.mapType.val(map.getMapTypeId());
				};

				google.maps.event.addListener(map, "maptypeid_changed", updateFields);
				google.maps.event.addListener(map, "zoom_changed", updateFields);
				google.maps.event.addListener(marker, "drag", updateFields);
				google.maps.event.addListener(marker, "dragend", updateFields);
				
				fields.latitude.keyup(updateMarker);
				fields.latitude.change(updateMarker);
				fields.longitude.keyup(updateMarker)
				fields.longitude.change(updateMarker)

				fields.description.keyup(function() { infoWindow.setContent(fields.description.val()); });
				fields.description.change(function() { infoWindow.setContent(fields.description.val()); });

				var search = function() {
					geocoder.geocode({"address": fields.search.val()} , function(results, status) {
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
						}
					});
				};

				searchButton.click(function(event) { 
					search(); 

					return false; 
				});

				fields.search.keydown(function(event) { 
					if(event.keyCode == 13) { 
						search();

						return false;
					}
				});
			}
		}
	};

	$.fn.pronamicGoogleMapsMetaBox = function() {
		return this.each(function() {
			methods.buildMetaBox(this);
		});
	};
})(jQuery);

jQuery(document).ready(function() {
	jQuery("#pronamic-google-maps-meta-box").pronamicGoogleMapsMetaBox();
});