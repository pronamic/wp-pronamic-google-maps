function Pronamic_Google_Maps_Admin() {
	var latitudeField = document.getElementById("pronamic-latitude-field");
	var longitudeField = document.getElementById("pronamic-longitude-field");
	var descriptionField = document.getElementById("pronamic-description-field");

	var location =  new google.maps.LatLng(latitudeField.value, longitudeField.value);

	var options = {
		zoom: 8 , 
		center: location , 
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	var map = new google.maps.Map(document.getElementById("pronamic_google_maps_canvas"), options);

	var marker = new google.maps.Marker({
		position: location , 
		map: map , 
		draggable: true
	});

	var infoWindow = new google.maps.InfoWindow({content: descriptionField.value});
	infoWindow.open(map, marker);

	var updateFields = function(location) {
		latitudeField.value = location.lat();
		longitudeField.value = location.lng();
	};

	google.maps.event.addListener(marker, 'drag', function() { updateFields(marker.getPosition()); });
	google.maps.event.addListener(marker, 'dragend', function() { updateFields(marker.getPosition()); });
	google.maps.event.addDomListener(descriptionField, 'keyup', function() { infoWindow.setContent(descriptionField.value); });
	google.maps.event.addDomListener(descriptionField, 'change', function() { infoWindow.setContent(descriptionField.value); });
}

google.maps.event.addDomListener(window, 'load', function() {
	new Pronamic_Google_Maps_Admin();
});