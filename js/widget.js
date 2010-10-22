function pronamicGoogleMapsWidget(s) {
	var element = jQuery(s);

	var latField = element.find(".latitude-field");
	var lngField = element.find(".longitude-field");
	var descriptionField = element.find(".description-field");
	var mapTypeField = element.find(".map-type-field");
	var zoomField = element.find(".zoom-field");

	var canvas = element.find(".google-maps-canvas").get(0);

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
		map: map , 
		draggable: true
	});
	
	var infoWindow = new google.maps.InfoWindow({content: descriptionField.val()});
	infoWindow.open(map, marker);

	var updateMarker = function() {
		var location =  new google.maps.LatLng(latField.val(), lngField.val());

		marker.setPosition(location);
		map.setCenter(location);
	};

	var updateFields = function() {
		var location = marker.getPosition();

		latField.val(location.lat());
		lngField.val(location.lng());
		zoomField.val(map.getZoom());
		mapTypeField.val(map.getMapTypeId());
	};

	google.maps.event.addListener(map, "maptypeid_changed", updateFields);
	google.maps.event.addListener(map, "zoom_changed", updateFields);
	google.maps.event.addListener(marker, "drag", updateFields);
	google.maps.event.addListener(marker, "dragend", updateFields);
	google.maps.event.addDomListener(latField, "keyup", updateMarker);
	google.maps.event.addDomListener(latField, "change", updateMarker);
	google.maps.event.addDomListener(lngField, "keyup", updateMarker);
	google.maps.event.addDomListener(lngField, "change", updateMarker);
	google.maps.event.addDomListener(descriptionField, "keyup", function() { infoWindow.setContent(descriptionField.val()); });
	google.maps.event.addDomListener(descriptionField, "change", function() { infoWindow.setContent(descriptionField.val()); });

	// The widget area is resized, wich is causing a buggy Google Maps, this function fixes that issue
	var fixMap = function() {
		google.maps.event.trigger(map, 'resize');

		map.setCenter(location);
	}

	element.closest(".widget").find(".widget-action").live("click", function() { setTimeout(fixMap, 1000); });
}