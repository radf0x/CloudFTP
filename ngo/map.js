var map, bounds, event;

google.maps.event.addDomListener(window, "resize", initialize);


function initialize() {
	bounds = new google.maps.LatLngBounds();
	map = new google.maps.Map(document.getElementById('map-canvas'), {
		center : new google.maps.LatLng(22.278, 114.158),
		zoom : 12,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	});
	google.maps.event.addListenerOnce(map, 'idle', myMarkers);
}

function myMarkers() {
	event = 'fire';
	$.post('GetData.php', {event : event}, function(data) {
		var myJSON = $.parseJSON(data);

		for (var i = 0 ; i < myJSON.length; i+=4) {
			var latLng = new google.maps.LatLng(myJSON[i+3].lat, myJSON[i+3].lng);
			bounds.extend(latLng);
			var infowindow = new google.maps.InfoWindow();
			var marker = new google.maps.Marker({
				position : latLng,
				map : map,
				title : myJSON[i],
				content : 'Name: ' + myJSON[i] + '<br> Address: ' + myJSON[i+2] + '<br> Tel: ' + myJSON[i+1]
			});
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.setContent(this.content);
				infowindow.open(map, this);
			});
		}
	});
}
