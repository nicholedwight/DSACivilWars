// ** JavaScript Dependencies **
// -- jQuery
// -- Google Maps API V3
// -- Underscore JS
$(document).ready(function(){
  // Location of battles data as a JSON resource.
  // Used in AJAX call bellow.
  var battlesjson = "http://civilwar.dev:8888/?json=battles";

  // Variable type Object.
  // used to expose JSON data from closure of AJAX request.
  var battles = {};

  // jQuery AJAX call used to get JSON from server.
  // JSON is then parsed to a JavaScript Object and stored in battles variable.
  // Once data is available the map is initialized.
  $.get(battlesjson, function(data) {
    battles = data;
    initializeMap();
  });

  // Function builds map using google maps api.
  function initializeMap() {
    // A geo location aroun the center of britain.
    var latlng = new google.maps.LatLng(52.454,-2.587);

    // Configures map canvas. Set zoom and center to show most of Britain.
    // Styles map.
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

    // Builds map in a div with an ID of map-canvas.

    if(document.getElementById("map-canvas")) {
      var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    }

    // Appends a container div to the map in which to display battle information using jQuery.
    // var battleInfoContainer = '<div id="battle-info"></div>';
    // $('#map-canvas').append(battleInfoContainer);
    var i = 0;
    // Function used to add an event listeners to each marker.
    // Uses closure to protect values during iterations over battle data.
    // Markers will be made by iterating over the dataset. Making a marker for each iteration.
    function addInfoWindow (num, battle, marker, map) {
      var battleName = battle.name;
      var battleDate = battle.date;
      var battleOutcome = battle.outcome;
      var battleContent = "<h2>" + battleName + "</h2>";
      var linkToBattlePage = "<a href='/?page=battle&id=" + battle.id +"' alt='Link to battle page'>";
      linkToBattlePage += "<button type='button' class='btn btn-success'>More info about the " + battle.name + "</button>";
      linkToBattlePage += "</a>";
      battleContent += '<p>' + battleDate + '<p>';


      marker.set('id', 'm' + i);
      i++;

      var infoWindow = new google.maps.InfoWindow({
        content: battleContent
      });

      google.maps.event.addListener(marker, 'mouseover', function() {
        infoWindow.open(map, marker);
      });

      google.maps.event.addListener(marker, 'mouseout', function() {
        infoWindow.close();
      });

      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.close();
        map.panTo(marker.getPosition());
        toggleBounce(marker);
        $('.modal-title').html(battleName);
        $('.battle-date').html(battleDate);
        $('.battle-outcome').html(battleOutcome);
        $('#battle-link-wrapper').html(linkToBattlePage);
        $('#battle-modal').modal('toggle');
      });
    };

    // Function sets a bouncing animation on a marker passed in arguments.
    // Uses closure to protect values and behaviour during iteration of the loop.
    var toggleBounce = function (marker) {
      if (marker.getAnimation() != null) {
        marker.setAnimation(null);
      } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
        // Animation last 1400 ms
        setTimeout(function (){
          marker.setAnimation(null);
        }, 1400);
      }
    };

    // Uses Underscore JS to iterate over battles data.
    // Offering more control over closure, Allowing events to be binded to each marker.
    _.map(battles, function (battle, i) {

      var lat = battle.latitude;
      var lng = '-' + battle.longitude;

      var battleLocation = new google.maps.LatLng(lat,lng);

      var marker = new google.maps.Marker({
        map: map,
        position: battleLocation,
        animation: google.maps.Animation.DROP,
        icon: './assets/img/cannon.png' + '#' + i
      });

      marker.setTitle(battle.name);

      addInfoWindow(i, battle, marker, map);
    });
  }

});
