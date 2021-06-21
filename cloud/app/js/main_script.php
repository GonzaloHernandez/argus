
<script type="text/javascript">
map_lat = 1.217824;
map_lon = -77.271828;
temperature = 0;

voltage_r = 0;
voltage_s = 0;
voltage_t = 0;
rtt = 0;

var frozen_map = new Object();
var myMark = new Object();
var myLatlng = {lat:map_lat, lng:map_lon};
var myOptions = {zoom: 13, center: myLatlng};
var infowindow = new Object();
var app_date = new Date();
var dev_date = new Date();

devices = new Array();
current_device = new Array();
current_variable = 0;
current_data = new Array();
device_pwr = 0;
diff_time = 0;
    
function loadContractData(){
  var url = 'http://www.argusingenieria.com/frozen2/ws/devices.php?request=<?php $id = $cliente[id_cliente]; echo "$id"; ?>';
  
  $.ajax({
      url : url,
      dataType : 'json',
      success : function (info) { 
        devices = info;
        current_device = devices[0];
        current_variable = current_device['id_variable'];
        app_date = new Date();
        dev_date = new Date(current_device['fecha']);
        //console.log(app_date);
        //console.log(dev_date);
        diff_time = (app_date.getTime() - dev_date.getTime())/1000;
        reloadData();
        setMarkers();
      }
  });
}

function reloadData(){
  //Temperatura (id_variable = 1)
  var url = 'http://www.argusingenieria.com/frozen2/ws/reporter.php?request='+current_device['id_dispositivo']+';1'+';'+current_variable;
  //console.log(url);
  $.ajax({
      url : url,
      dataType : 'json',
      success : function (info) { 
        current_data = info[0];
        app_date = new Date();
        dev_date = new Date(info[0]['fecha']);
        temperature = info[0]['valor'];
        diff_time = (app_date.getTime() - dev_date.getTime())/1000;
        //console.log(diff_time);
        updateDashboard();
      }
  });
  
  //RTT id variable 7
  url = 'http://www.argusingenieria.com/frozen2/ws/reporter.php?request='+current_device['id_dispositivo']+';1'+';'+'7';
  $.ajax({
      url : url,
      dataType : 'json',
      success : function (info) { 
        rtt = info[0]['valor'];
        updateDashboard();
      }
  });
  
  //Powerline R id variable 12
  url = 'http://www.argusingenieria.com/frozen2/ws/reporter.php?request='+current_device['id_dispositivo']+';1'+';'+'12';
  $.ajax({
      url : url,
      dataType : 'json',
      success : function (info) { 
        voltage_r = info[0]['valor'];
        updateDashboard();
      }
  });
  
  //Powerline S id variable 13
  url = 'http://www.argusingenieria.com/frozen2/ws/reporter.php?request='+current_device['id_dispositivo']+';1'+';'+'13';
  $.ajax({
      url : url,
      dataType : 'json',
      success : function (info) { 
        voltage_s = info[0]['valor'];
        updateDashboard();
      }
  });
  
  //Powerline T id variable 14
  url = 'http://www.argusingenieria.com/frozen2/ws/reporter.php?request='+current_device['id_dispositivo']+';1'+';'+'14';
  $.ajax({
      url : url,
      dataType : 'json',
      success : function (info) { 
        voltage_t = info[0]['valor'];
        updateDashboard();
      }
  });
}

function setMarkers(){
  //console.log(JSON.stringify(current_device));
  var marker = [];
  var i,j;
  var frozen_icon = {
                    url: 'http://argusingenieria.com/frozen2/img/icecream-blue-normal.png',
                    scaledSize: new google.maps.Size(35, 35),
                    origin: new google.maps.Point(0,0),
                    anchor: new google.maps.Point(20,20)
                };
  var active_icon = {
                    url: 'http://argusingenieria.com/frozen2/img/icecream-blue-active.png',
                    scaledSize: new google.maps.Size(35, 35),
                    origin: new google.maps.Point(0,0),
                    anchor: new google.maps.Point(20,20)
                };
  
  console.log(devices);
  console.log(devices.length);
  
  for (i = 0; i < devices.length; i++) {
    marker[i] = new google.maps.Marker({
                    position: new google.maps.LatLng(devices[i]['latitude'], devices[i]['longitude']),
                    map: frozen_map,
                    icon: frozen_icon,
                    title: devices[i]['direccion']
                    });
    google.maps.event.addListener(marker[i], 'click', (function(marker, i) {
                                    return function() {
                                        current_device = devices[i];
                                        reloadData();
                                        for(j=0; j< devices.length; j++)
                                          marker[j].setIcon(frozen_icon);
                                        marker[i].setIcon(active_icon);
                                    }
                                  })(marker, i));
  }
  marker[0].setIcon(active_icon);
  marker[0].setMap(frozen_map);
}

function updateDashboard(){
    //console.log(JSON.stringify(current_data));
    $("#device_info").html("");
    $("#device_dir").html(current_device['direccion']);
    $("#device_hw").html(current_device['descripcion']);
    $("#device_des").html(current_device['id_dispositivo']);
    $("#device_lat").html(current_data['latitude']); 
    $("#device_lon").html(current_data['longitude']); 
    $("#device_alt").html(current_data['altitude']); 
    $("#device_temperature").html(parseFloat(current_data['valor']).toFixed(1) + " ºC"); 
    $("#device_con").html(current_device['numero_telefono']);
    
    rtt = parseFloat(rtt);
    rtt = rtt.toFixed(1);
    
    $("#rtt_info").html("RTT: "+ rtt + " ms");
    if(rtt < 100){
        $("#device_com").css("color","green");
        $("#device_com").html("EN LÍNEA");
    }
    else{
         $("#device_com").css("color","red");
         $("#device_com").html("Fuera de línea");
    }
    
    $("#last_update").html(current_data['fecha']);
    $("#seldev").html("Para cambiar seleccione en el mapa");

    // Detect if the app lost connection wwith the device (the time diference between app an the last record retrieved is over the sample time i the device)
    if(diff_time > 130) {   
      $("#dev_box").attr("class","info-box-icon bg-red");
      $("#dev_box").prop("title","Se ha perdido la comunicación con el dispositivo de monitoreo. Imposible determinar el estado de las variables.")
      $("#device_status").css("color","red");
      $("#device_status").html(current_device['descripcion'] + " Desconectado");
      $("#seldev").html("Contacte soporte ténico");
      $("#device_pwr").css("color",'red');
      $("#device_pwr").html("Unknown");
      $("#pwr_box").attr("class","info-box-icon bg-red");
      $("#pwr_info").html("");
      $("#device_temperature").css("color","red"); 
      $("#device_temperature").html(current_data['valor']+' ?'); 
      $("#last_update").css("color","red");
      $("#device_com").html("Unknown"); 
      $("#device_com").css("color","red"); 
      return;
    }
    else{
      $("#dev_box").attr("class","info-box-icon bg-teal");
      $("#device_status").css("color","green");
      $("#device_status").html(current_device['descripcion'] + " En línea");
      $("#seldev").html("Para cambiar seleccione en el mapa");
      $("#device_temperature").css("color","black");
      $("#last_update").css("color","black");
      
    }
    
    // Change status on device power ON/OFF
    if(voltage_r < 100 || voltage_s < 100 || voltage_t < 100){
      $("#device_pwr").css("color",'red');
      $("#device_pwr").html("FUERA DE LÍNEA");
      $("#pwr_box").attr("class","info-box-icon bg-red");
      $("#pwr_info").html("Atender de inmediato");
      $("#pwr_box").prop("title","El sistema ha detectado un fallo en la red eléctrica principal.");
    }
    else {
      $("#pwr_box").attr("class","info-box-icon bg-orange");
      $("#device_pwr").css("color",'green');
      $("#device_pwr").html("EN LÍNEA"); 
      $("#pwr_info").html("Red primaria CEDENAR");
    }
}

function initialize() {
    frozen_map = new google.maps.Map(document.getElementById("main_container"),myOptions);
    var myLatlng = new google.maps.LatLng(map_lat, map_lon);
    infowindow = new google.maps.InfoWindow;
    loadContractData();
}
setInterval(reloadData,50000);
</script>
