<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['V', 0],
          ['V', 0],
          ['V', 0]
        ]);

        var options = {
          max: 150,
          width: 400, height: 220,
          redFrom: 80, redTo: 108,
          greenFrom:108, greenTo: 132,
          yellowFrom:132, yellowTo: 150,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('compressor_timeline'));

        chart.draw(data, options);

        setInterval(function() {
          data.setValue(0, 1, parseFloat(voltage_r).toFixed(1));
          chart.draw(data, options);
        }, 3000);
        setInterval(function() {
          data.setValue(1, 1, parseFloat(voltage_s).toFixed(1));
          chart.draw(data, options);
        }, 3000);
        setInterval(function() {
          data.setValue(2, 1, parseFloat(voltage_t).toFixed(1));
          chart.draw(data, options);
        }, 3000);
      }

</script>