function pronamicGoogleMaps(s) {
	var element = jQuery(s);

	var canvas = element.find(".canvas").get(0);

	if(canvas) {
		var latField = element.find("input[name=lat]");
		var lngField = element.find("input[name=lng]");
		var mapTypeField = element.find("input[name=map-type]");
		var zoomField = element.find("input[name=zoom]");
		var titleField = element.find("input[name=title]");
		var descriptionField = element.find("input[name=description]");

		var location =  new google.maps.LatLng(latField.val(), lngField.val());
	
		var zoom = parseInt(zoomField.val());
		if(isNaN(zoom)) { zoom = 0; }
	
		var mapType = mapTypeField.val();
		if(mapType == "") { mapType = google.maps.MapTypeId.ROADMAP; }
	
		var options = {
			zoom: zoom , 
			center: location , 
			mapTypeId: mapType 
		};
	
		var map = new google.maps.Map(canvas, options);
	
		var marker = new google.maps.Marker({
			position: location , 
			map: map 
		});
	
		var infoWindow = new google.maps.InfoWindow({content: descriptionField.val()});
	
		google.maps.event.addListener(marker, "click", function() {
			infoWindow.open(map, marker);
		});
	}
}

function pronamicGoogleMapsMashup(s) {

}

(function($) {
	var methods = {
		getFields: function(element) {
			var fields = {
				lat: element.find("input[name=lat]") , 
				lng: element.find("input[name=lng]") , 
				mapType: element.find("input[name=map-type]") ,
				zoom: element.find("input[name=zoom]") ,
				title: element.find("input[name=title]") ,
				description: element.find("input[name=description]") 
			};

			return fields;
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

	$.fn.pronamicGoogleMapsMashup = function() {
		return this.each(function() {
			methods.buildMashup(this);
		});
	};
})(jQuery);

jQuery(document).ready(function() {
	jQuery(".pgm").each(function() {
		pronamicGoogleMaps(this);
	});

	jQuery(".pgmm").pronamicGoogleMapsMashup();
});