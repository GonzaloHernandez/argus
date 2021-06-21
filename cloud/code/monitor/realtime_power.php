<script type="text/javascript">
var chartp; // global
/**
 * Request data from the server, add it to the graph and set a timeout
 * to request again
 */

//$(document).ready(function() {
function drawRealTime(){
    chartp = chart;
}

function requestData() {
    $.ajax({
       url: 'http://www.argusingenieria.com/frozen/ws/live.php',
        success: function(point) {
            var seriesp = chartp.series[0],
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
            samplep = [point[0],temperature];
            chartp.series[0].addPoint(samplep, true, shift);
            setTimeout(requestData, 10000);
        },
        cache: false
    });
}

drawRealTime();
</script>
