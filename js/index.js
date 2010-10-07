function Pronamic_Google_Maps(element) {
	var latField = document.getElementById("pgm-lat-field");
	var lngField = document.getElementById("pmg-lng-field");
	var mapTypeField = document.getElementById("pgm-map-type-field");
	var zoomField = document.getElementById("pgm-zoom-field");
	var descriptionField = document.getElementById("pgm-description-field");

	if(latField && lngField) {
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

		google.maps.event.addListener(marker, "click", function() {
			infoWindow.open(map, marker);
		});
	}
}

google.maps.event.addDomListener(window, "load", function() {
	var pgm = document.getElementById("pgm-canvas");

	if(pgm) {
		new Pronamic_Google_Maps(pgm);
	}
});