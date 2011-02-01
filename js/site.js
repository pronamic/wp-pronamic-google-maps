(function($) {
	var methods = {
		buildMap: function(s) {
			var element = jQuery(s);

			var options = jQuery.parseJSON(element.find("input[name=pronamic-google-maps-meta]").val());

			var canvas = element.find(".canvas").get(0);

			if(canvas) {
				var location =  new google.maps.LatLng(options.latitude, options.longitude);

				var mapOptions = {
					zoom: options.zoom , 
					center: location , 
					mapTypeId: options.mapType 
				};
			
				var map = new google.maps.Map(canvas, mapOptions);
			
				var marker = new google.maps.Marker({
					position: location , 
					map: map 
				});
			
				var infoWindow = new google.maps.InfoWindow({content: options.description});

				google.maps.event.addListener(marker, "click", function() {
					infoWindow.open(map, marker);
				});
			}
		} , 

		buildMashup: function(s) { 
			var element = jQuery(s);

			var list = element.find("ul");

			var options = jQuery.parseJSON(element.find("input[name=options]").val());

			var canvas = element.find(".canvas").get(0);

			if(canvas) {
				if(options.hideList) {
					list.hide();
				}

				var mapOptions = {
					zoom: options.zoom , 
					mapTypeId: options.mapTypeId 
				};
				
				var map = new google.maps.Map(canvas, mapOptions);

				var bounds = new google.maps.LatLngBounds();

				list.find("li").each(function() {
					var item = jQuery(this);

					var meta = jQuery.parseJSON(item.find("input[name=pronamic-google-maps-meta]").val());

					var location =  new google.maps.LatLng(meta.latitude, meta.longitude);

					bounds.extend(location);

					var marker = new google.maps.Marker({
						position: location , 
						map: map 
					});

					var infoWindow = new google.maps.InfoWindow({content: meta.description});
				
					google.maps.event.addListener(marker, "click", function() {
						infoWindow.open(map, marker);
					});
				});

				map.fitBounds(bounds);
			}
		}
	};

	$.fn.pronamicGoogleMaps = function() {
		return this.each(function() {
			methods.buildMap(this);
		});
	};

	$.fn.pronamicGoogleMapsMashup = function() {
		return this.each(function() {
			methods.buildMashup(this);
		});
	};
})(jQuery);

jQuery(document).ready(function() {
	jQuery(".pgm").pronamicGoogleMaps();

	jQuery(".pgmm").pronamicGoogleMapsMashup();
});