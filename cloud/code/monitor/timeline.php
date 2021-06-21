
<script type="text/javascript">

/*function timeStampToDate(timestamp) {
  var epoca = new Date(timestamp);
  return epoca.valueOf();
}*/

function getTimelineData(){
  $.getJSON('http://www.argusingenieria.com/frozen/ws/reporter.php?request=161102;3;1', function (info) {
       //obj = JSON.parse(info);
       //console.log(timeStampToDate(info[1]['fecha']));
       info.reverse();
       count = 0;
       console.log(info.length);
       for(var i=0; i < info.length; i++ ){
         console.log(info[i]['fecha']);
         console.log(parseFloat(info[i]['valor']));
         console.log(timeStampToDate(info[i]['fecha']));
         points[count] = [timeStampToDate(info[i]['fecha']),parseFloat(info[i]['valor'])];
         count++;
       }
       console.log(points.toString());
       //points.push(timeStampToDate(info[1]['fecha']),parseFloat(info[1]['valor']));
   });
}
setInterval(function() {
  getTimelineData();
  drawTimeline();
}, 10000);

function drawTimeline(){
  $(function () {
      Highcharts.chart('realtime', {
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Historial de temperatura'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                        'Seleccione área para información detallada' : 'Zoom'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Grados Celcius'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Grados Celcius',
                data: points
            }]
        });
    });
}

getTimelineData();
drawTimeline();

</script>
