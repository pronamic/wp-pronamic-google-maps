function Pronamic_Google_Maps_Admin(element) {
	var latitudeField = document.getElementById("pronamic-latitude-field");
	var longitudeField = document.getElementById("pronamic-longitude-field");
	var descriptionField = document.getElementById("pronamic-description-field");
	var mapTypeField = document.getElementById("pronamic-google-maps-map-type");
	var zoomField = document.getElementById("pronamic-google-maps-zoom");

	var location =  new google.maps.LatLng(latitudeField.value, longitudeField.value);

	var zoom = parseInt(zoomField.value);
	if(isNaN(zoom)) { zoom = 0; }

	var mapType = mapTypeField.value;
	if(mapType == "") { mapType = google.maps.MapTypeId.ROADMAP; }
	
	var options = {
		zoom: zoom , 
		center: location , 
		mapTypeId: mapType 
	};

	var map = new google.maps.Map(document.getElementById("pronamic-google-maps-canvas"), options);

	var marker = new google.maps.Marker({
		position: location , 
		map: map , 
		draggable: true
	});

	var infoWindow = new google.maps.InfoWindow({content: descriptionField.value});
	infoWindow.open(map, marker);

	var updateFields = function() {
		var location = marker.getPosition();

		latitudeField.value = location.lat();
		longitudeField.value = location.lng();
		zoomField.value = map.getZoom();
		mapTypeField.value = map.getMapTypeId();
	};

	google.maps.event.addListener(map, 'maptypeid_changed', updateFields);
	google.maps.event.addListener(map, 'zoom_changed', updateFields);
	google.maps.event.addListener(marker, "drag", updateFields);
	google.maps.event.addListener(marker, "dragend", updateFields);
	google.maps.event.addDomListener(descriptionField, "keyup", function() { infoWindow.setContent(descriptionField.value); });
	google.maps.event.addDomListener(descriptionField, "change", function() { infoWindow.setContent(descriptionField.value); });
}

google.maps.event.addDomListener(window, "load", function() {
	var pgm = document.getElementById("pronamic-google-maps");

	if(pgm) {
		new Pronamic_Google_Maps_Admin(pgm);
	}
});