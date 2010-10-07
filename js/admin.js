function Pronamic_Google_Maps_Admin(element) {
	var latField = document.getElementById("pgm-lat-field");
	var lngField = document.getElementById("pgm-lng-field");
	var descriptionField = document.getElementById("pgm-description-field");
	var mapTypeField = document.getElementById("pgm-map-type-field");
	var zoomField = document.getElementById("pgm-zoom-field");

	var location =  new google.maps.LatLng(latField.value, lngField.value);

	var zoom = parseInt(zoomField.value);
	if(isNaN(zoom)) { zoom = 0; }

	var mapType = mapTypeField.value;
	if(mapType == "") { mapType = google.maps.MapTypeId.ROADMAP; }
	
	var options = {
		zoom: zoom , 
		center: location , 
		mapTypeId: mapType 
	};

	var map = new google.maps.Map(element, options);

	var marker = new google.maps.Marker({
		position: location , 
		map: map , 
		draggable: true
	});

	var infoWindow = new google.maps.InfoWindow({content: descriptionField.value});
	infoWindow.open(map, marker);

	var updateMarker = function() {
		var location =  new google.maps.LatLng(latField.value, lngField.value);

		marker.setPosition(location);
		map.setCenter(location);
	};

	var updateFields = function() {
		var location = marker.getPosition();

		latField.value = location.lat();
		lngField.value = location.lng();
		zoomField.value = map.getZoom();
		mapTypeField.value = map.getMapTypeId();
	};

	google.maps.event.addListener(map, "maptypeid_changed", updateFields);
	google.maps.event.addListener(map, "zoom_changed", updateFields);
	google.maps.event.addListener(marker, "drag", updateFields);
	google.maps.event.addListener(marker, "dragend", updateFields);
	google.maps.event.addDomListener(latField, "keyup", updateMarker);
	google.maps.event.addDomListener(latField, "change", updateMarker);
	google.maps.event.addDomListener(lngField, "keyup", updateMarker);
	google.maps.event.addDomListener(lngField, "change", updateMarker);
	google.maps.event.addDomListener(descriptionField, "keyup", function() { infoWindow.setContent(descriptionField.value); });
	google.maps.event.addDomListener(descriptionField, "change", function() { infoWindow.setContent(descriptionField.value); });
}

google.maps.event.addDomListener(window, "load", function() {
	var pgm = document.getElementById("pgm-canvas");

	if(pgm) {
		new Pronamic_Google_Maps_Admin(pgm);
	}
});