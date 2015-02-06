$(document).ready(function(){
  var battlesjson = "http://localhost:9000/dsa-civilwar/?json=battles";
  var map;
  var battles = '';

  $.get(battlesjson, function(data) {
    battles = JSON.parse(data);
    initializeMap();
  });

  function initializeMap() {
    var latlng = new google.maps.LatLng(52.454,-2.587);

    var mapOptions = {
      zoom: 7,
      center: latlng,
      styles: [{
        "featureType":"administrative",
        "elementType":"labels.text.fill",
        "stylers":[{"color":"#444444"}]},
        {"featureType":"landscape",
        "elementType":"all",
        "stylers":[{"color":"#f2f2f2"}]},
        {"featureType":"poi",
        "elementType":"all",
        "stylers":[{"visibility":"off"}]},
        {"featureType":"poi.business",
        "elementType":"geometry.fill",
        "stylers":[{"visibility":"on"}]},
        {"featureType":"road",
        "elementType":"all",
        "stylers":[{"saturation":-100},
        {"lightness":45}]},
        {"featureType":"road.highway",
        "elementType":"all",
        "stylers":[{"visibility":"simplified"}]},
        {"featureType":"road.arterial",
        "elementType":"labels.icon",
        "stylers":[{"visibility":"off"}]},
        {"featureType":"transit",
        "elementType":"all",
        "stylers":[{"visibility":"off"}]},
        {"featureType":"water",
        "elementType":"all",
        "stylers":[{"color":"#b4d4e1"},
        {"visibility":"on"}]}]
    }

    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var battleInfoContainer = '<div id="battle-info"></div>';

    $('#map-canvas').append(battleInfoContainer);

    function addInfoWindow (num, battle) {
      var battleName = battle[num].name;
      var battleDate = battle[num].date;
      var battleContent = "<h2>" + battleName + "</h2>";
      battleContent += '<p>' + battleDate + '<p>';

      google.maps.event.addListener(marker, 'click', function() {
        $('#battle-info').html(battleContent);
      });
    };

    for (var i = 0; i < battles.length; i++) {

      var lat = battles[i].latitude;
      var lng = '-' + battles[i].longitude;

      var battleLocation = new google.maps.LatLng(lat,lng);

      var marker = new google.maps.Marker({
        map: map,
        position: battleLocation,
        icon: './views/img/cannon.png'
      });

      marker.setTitle((i + 1).toString());

      addInfoWindow(i, battles);
    }
  }
});