<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['ºC', 10]
        ]);

        var options = {
          max: 35,
          min: 10,
          width: 400, height: 150,
          greenFrom: 15, greenTo:24,
          yellowFrom:24, yellowTo: 27,
          redFrom: 27, redTo: 35,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('temperature_log'));

        chart.draw(data, options);

        setInterval(function() {
          data.setValue(0, 1, parseFloat(current_data['valor']).toFixed(1));
          chart.draw(data, options);
        }, 3000);
      }
</script>