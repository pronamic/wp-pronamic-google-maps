/**
 * Title: Pronamic Google Maps
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
(function($) {
	var methods = {
		/**
		 * Build map
		 * 
		 * @param s an jQuery selector
		 */
		buildMap: function(s) {
			var element = jQuery(s);

			var info = jQuery.parseJSON(element.find("input[name=pgm-info]").val());

			var canvas = element.find(".canvas").get(0);

			if(canvas) {
				var location =  new google.maps.LatLng(info.latitude, info.longitude);

				var mapOptions = {
					zoom: info.zoom , 
					center: location , 
					mapTypeId: info.mapType 
				};

				var map = new google.maps.Map(canvas, mapOptions);

				var marker = new google.maps.Marker({
					position: location , 
					map: map 
				});
			
				var infoWindow = new google.maps.InfoWindow({content: info.description});

				google.maps.event.addListener(marker, "click", function() {
					infoWindow.open(map, marker);
				});
			}
		} , 

		//////////////////////////////////////////////////

		/**
		 * Build mashup
		 * 
		 * @param s an jQuery selector
		 */
		buildMashup: function(s) { 
			var element = jQuery(s);

			var list = element.find("ul");

			var defaultOptions = {
				zoom: 8 , 
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			var mashupInfo = jQuery.parseJSON(element.find("input[name=pgmm-info]").val());

			mashupInfo = $.extend(defaultOptions, mashupInfo);

			var canvas = element.find(".canvas").get(0);

			if(canvas) {
				if(mashupInfo.hideList) {
					list.hide();
				}

				var mapOptions = {
					zoom: mashupInfo.zoom , 
					mapTypeId: mashupInfo.mapTypeId 
				};
				
				var map = new google.maps.Map(canvas, mapOptions);
				var bounds = new google.maps.LatLngBounds();
				var infoWindow = new google.maps.InfoWindow();

				list.find("li").each(function() {
					var item = jQuery(this);

					var info = jQuery.parseJSON(item.find("input[name=pgm-info]").val());

					var location =  new google.maps.LatLng(info.latitude, info.longitude);

					bounds.extend(location);

					var markerOptions = $.extend({
							position: location , 
							map: map 
						} , 
						mashupInfo.markerOptions
					);

					var marker = new google.maps.Marker(markerOptions);

					google.maps.event.addListener(marker, "click", function() {
						infoWindow.setContent(item.html());
						infoWindow.open(map, marker);
					});
				});

				map.fitBounds(bounds);
			}
		}
	};

	//////////////////////////////////////////////////

	/**
	 * The Pronamic Google Maps jQuery plugin function
	 */
	$.fn.pronamicGoogleMaps = function() {
		return this.each(function() {
			methods.buildMap(this);
		});
	};

	//////////////////////////////////////////////////

	/**
	 * The Pronamic Google Maps mashup jQuery plugin function
	 */
	$.fn.pronamicGoogleMapsMashup = function() {
		return this.each(function() {
			methods.buildMashup(this);
		});
	};
})(jQuery);

//////////////////////////////////////////////////

/**
 * Check the document for Pronamic Google Maps and mashups
 */
jQuery(window).load(function() {
	jQuery(".pgm").pronamicGoogleMaps();

	jQuery(".pgmm").pronamicGoogleMapsMashup();
});