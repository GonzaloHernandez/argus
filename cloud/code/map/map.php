

<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMSHh2fi5o7oWEKLKXLrGHTIWlKw_fRiQ&callback=initialize">
</script>

<script src="../js/jquery-3.1.1.min.js"></script>
<script src="../js/highcharts.js"></script>



<script type="text/javascript">
// Get device list and their information
// Map Center (San Juan de Pasto)

map_lat = 1.217824;
map_lon = -77.271828;
var map = new Object();
var myMark = new Object();
var myLatlng = {lat:map_lat, lng:map_lon};
var myOptions = {zoom: 13, center: myLatlng};
var infowindow = new Object();

function setMarkers(){
  var url = 'http://www.argusingenieria.com/frozen/ws/devices.php?request=<?php $id = $cliente[id_cliente]; echo "$id"; ?>';
  //console.log(url);
  $.getJSON(url, function (info) {
    var marker = [];
    var i;
    for (i = 0; i < info.length; i++) {
        marker[i] = new google.maps.Marker({
             position: new google.maps.LatLng(info[i]['latitude'], info[i]['longitude']),
             map: map
        });
        //console.log(info[i]);

        google.maps.event.addListener(marker[i], 'click', (function(marker, i) {
             return function() {
                 infowindow.setContent(info[i]['descripcion']);
                 infowindow.open(map, marker[i]);
                 current_device = info[i]['id_dispositivo'];
                 current_variable = info[i]['id_variable'];
                 $("#seldev").html(info[i]['descripcion']);
                 getGaugeData();
             }
        })(marker, i));
    }
  //var myMark = new google.maps.Marker({map:map, position: myLatlng, title: "Waiting data..."});
  });
}

function initialize() {
		map = new google.maps.Map(document.getElementById("map"),myOptions);
		var myLatlng = new google.maps.LatLng(map_lat, map_lon);
		//var myMark = new google.maps.Marker({map:map, position: myLatlng, title: "Waiting data..."});
    infowindow = new google.maps.InfoWindow;
    setMarkers();
}
</script>
