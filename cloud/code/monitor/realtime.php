<script type="text/javascript">
var chart; // global
/**
 * Request data from the server, add it to the graph and set a timeout
 * to request again
 */

//$(document).ready(function() {
function drawRealTime(){
    chart = new Highcharts.Chart({
        chart: {
            renderTo: 'realtime',
            defaultSeriesType: 'spline',
            events: {
                load: requestData
            }
        },
        title: {
            text: 'Historial'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,
            maxZoom: 20 * 1000
        },
        yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: 'Grados Celcius',
                margin: 80
            }
        },
        series: [{
            name: 'Temperatura',
            data: []
        }]
    });

    
}

function requestData() {
    $.ajax({
       url: 'http://www.argusingenieria.com/frozen/ws/live.php',
        success: function(point) {
            var series = chart.series[0],
            shift = series.data.length > 20; // shift if the series is
                                           // longer than 20
            console.log("server="+today);
            hoy = new Date();
            timestamp = hoy.getFullYear() + "-" + (hoy.getMonth() +1) + "-" + (hoy.getDay()-3) +' '+hoy.getHours()+':'+hoy.getMinutes()+':'+hoy.getSeconds();

            console.log("local="+timeStampToDate(timestamp));
            // add the point
            dif = (timeStampToDate(timestamp)-today)/(1000*60);
            console.log(dif);
            //sample = [timeStampToDate(timestamp),temperature];
            sample = [point[0],temperature];
            chart.series[0].addPoint(sample, true, shift);
            setTimeout(requestData, 5000);
        },
        cache: false
    });
}
drawRealTime();

</script>
