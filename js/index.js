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
			map: map , 
			draggable: true
		});
	
		var infoWindow = new google.maps.InfoWindow({content: descriptionField.val()});
	
		google.maps.event.addListener(marker, "click", function() {
			infoWindow.open(map, marker);
		});
	}
}

jQuery(document).ready(function() {
	jQuery(".pgm").each(function() {
		pronamicGoogleMaps(this);
	});
});