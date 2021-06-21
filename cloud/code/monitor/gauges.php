<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});   
      google.charts.setOnLoadCallback(drawChart);
      /// Global variables //////
      temperature = 0;
      online = 0;
      var last_update = new Date();
      var current_update = new Date();
      count = 0; 
      ////////////////////////////
      current_device = 17020701;
      current_variable = 1;
      drawChart();

      function getGaugeData(){
        var urlt = 'http://www.argusingenieria.com/frozen/ws/reporter.php?request='+current_device+';1;1';
        var urlp = 'http://www.argusingenieria.com/frozen/ws/reporter.php?request='+current_device+';1;4';
        
        $.getJSON(urlt, function (info) {
            temperature = parseFloat(info[0]['valor']);
            current_device = info[0]['id_dispositivo'];
            current_variable = 1;
            //console.log("last update: "+last_update);
            //console.log("database: "+info[0]['fecha']);
            //console.log(count);
            // Determina si hay cambios entre dos muestras consecutivas
            // Utilizado para controlar si se perdió la conexión con el dispsitivo.
            if(last_update != info[0]['fecha']) {
              count =  0;
              last_update = info[0]['fecha'];
            }
            else count ++;
            $("#lat").html(info[0]['latitude']);
            $("#lon").html(info[0]['longitude']);
            $("#alt").html(info[0]['altitude']);
            $("#dev").html(info[0]['id_dispositivo']);
            $("#lastupg").html(info[0]['fecha']);
            $("#lastups").html(info[0]['fecha']);
            $("#lastupd").html(info[0]['fecha']);
         });

         $.getJSON(urlp, function (info) {
            current_variable = 4;
            online = info[0]['valor'];
           
            if(online ==1 ){
              $("#pwrline").attr("class", "alert alert-success");
              $("#pwrline").text("Red eléctrica en línea");
            }
            else{
              $("#pwrline").attr("class", "alert alert-danger");
              $("#pwrline").text("Red eléctrica fuera de línea");
            }
          
            // IMPORTANTE, se debe cumplir la condición: [ count > 1 + (SAMPLE_TIME / setInterval) ] de lo contrario se obtendrán cambios de estado incorrectos.
            // La pérdida de conexión con el dispositivo se determina por excesivo tiempo sin que cambie la fecha del último dato recibido.
            if(count > 7) {   
              $("#device_status").attr("class","alert alert-danger");
              $("#device_status").text("Se ha perdido conexión con el dispositivo");
              $("#pwrline").attr("class", "alert alert-danger");
              $("#pwrline").text("No se pudo determinar estado de la red eléctrica");
            }
            else{
              $("#device_status").attr("class","alert alert-success");
              $("#device_status").text("Dispositivo en línea");
            }
            
         });
      }

      function drawChart() {
        //getGaugeData();
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Temp', 0]
        ]);
        var options = {
          width: 420, height: 140,
          redFrom: 25, redTo: 50,
          yellowFrom:20, yellowTo: 25,
          greenFrom:0, greenTo: 20,
          blueFrom:-20, blueTo: 0,
          minorTicks: 5,
          min: -20,
          max: 50
        };
        var chart = new google.visualization.Gauge(document.getElementById('gauges'));
        getGaugeData();
        chart.draw(data, options);

        setInterval(function() {
          getGaugeData();
          data.setValue(0, 1, temperature);
          chart.draw(data, options);

        }, 5000);
      }


</script>
