
<script type="text/javascript">


function drawStatistics(){
   
    $("#main_container_title").html("Registro estadístico");
    $("#main_container").empty();
    if ( $("#daterange-btn").length == 0 ) {
        $("#main-container-menu").append("<button type='button' class='btn btn-default pull-right' id='daterange-btn'><span><i class='fa fa-calendar'></i> Lapso de tiempo </span><i class='fa fa-caret-down'></i></button>");
    }
    
    // Retrieve temperature data
    $.ajax({
        url : 'http://www.argusingenieria.com/frozen/ws/reporter.php?request='+current_device['id_dispositivo']+';500'+';'+'1',
        dataType : 'json',
        success :   function (info) { 
                        $("#main_container").append("<div id=stats_temperature style='width: 100%; height: 200px'></div>");
                        drawTemperatureStats(info);
                    }
    });    
    
    // Retrieve power line data (R,S,T)
    $.ajax({
            url : 'http://www.argusingenieria.com/frozen/ws/reporter.php?request='+current_device['id_dispositivo']+';800'+';'+'12',
            dataType : 'json',
            success : function (info){
                var fase_r = info;
                $.ajax({
                    url : 'http://www.argusingenieria.com/frozen/ws/reporter.php?request='+current_device['id_dispositivo']+';800'+';'+'13',
                    dataType: 'json',
                    success: function(info){
                        var fase_s = info;
                        $.ajax({
                            url: 'http://www.argusingenieria.com/frozen/ws/reporter.php?request='+current_device['id_dispositivo']+';800'+';'+'14',
                            dataType: 'json',
                            success: function(info){
                                var fase_t = info;
                                drawPowerline(fase_r, fase_s, fase_t);
                            }
                        });
                    }
                });
            }
    }); 
    
    // Retrieve RTT data
    $.ajax({
        url : 'http://www.argusingenieria.com/frozen/ws/reporter.php?request='+current_device['id_dispositivo']+';500'+';'+'7',
        dataType : 'json',
        success :   function (info) { 
                        $("#main_container").append("<div id=stats_rtt style='width: 100%; height: 200px'></div>");
                        drawRTTStats(info);
                    }
    });    
}

function drawTemperatureStats(temperature_data){
    var data = [];
    var aux = [];
    var min, max, mean = 0;
    
    for(var i= 0; i < temperature_data.length; i++){
        data[i] = [ new Date(temperature_data[i]['fecha']).getTime(), parseFloat(temperature_data[i]['valor']) ];
        aux[i] = data[i][1];
        mean = mean + aux[i];
    }
    data.sort();
    min = arrayMin(aux);
    max = arrayMax(aux);
    mean = mean / aux.length;
    mean = parseFloat(mean.toFixed(1));
    
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
    
        Highcharts.chart('stats_temperature', {
            chart: {
                type: 'spline',
                zoomType: 'x'
            },
            title: {
                text: 'Temperatura'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                        'Click y arrastre para acercar' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Grados ºC'
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
                            [0, Highcharts.getOptions().colors[2]],
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
                name: 'Temperatura',
                data: data
            }]
        });
}

function drawRTTStats(rtt_data){
    var data = [];
    var aux = [];
    var min, max, mean = 0;
    
    for(var i= 0; i < rtt_data.length; i++){
        data[i] = [ new Date(rtt_data[i]['fecha']).getTime(), parseFloat(rtt_data[i]['valor']) ];
        aux[i] = data[i][1];
        mean = mean + aux[i];
    }
    data.sort();
    min = arrayMin(aux);
    max = arrayMax(aux);
    mean = mean / aux.length;
    mean = parseFloat(mean.toFixed(1));
    
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
    
        Highcharts.chart('stats_rtt', {
            chart: {
                type: 'spline',
                zoomType: 'x'
            },
            title: {
                text: 'Canal de internet RTT (ms)'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                        'Click y arrastre para acercar' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'RTT (ms)'
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
                            x2: 1,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[3]).setOpacity(1).get('rgba')]
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
                name: 'RTT',
                data: data
            }]
        });
}
        
function drawPowerline(info_r, info_s, info_t) {
    var data_r = [];
    var data_s = [];
    var data_t = [];
    
    $("#main_container").append("<div id=stats_compressor style='width: 100%; height: 300px'></div>");
    
    for(var i= 0; i < info_r.length; i++){
        data_r[i] = [ new Date(info_r[i]['fecha']).getTime(), parseFloat(info_r[i]['valor']) ];
        data_s[i] = [ new Date(info_r[i]['fecha']).getTime(), parseFloat(info_s[i]['valor'])];
        data_t[i] = [ new Date(info_r[i]['fecha']).getTime(), parseFloat(info_t[i]['valor'])];
    }
    data_r.sort();
    data_s.sort();
    data_t.sort();
    
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
    
    Highcharts.chart('stats_compressor', {
    
    chart: {
        type: 'spline'
    },

    title: {
        text: 'Red eléctrica primaria'
    },

    subtitle: {
        text: 'Últimas horas'
    },
    
    xAxis: {
                type: 'datetime'
    },
    
    yAxis: {
        title: {
            text: 'Voltaje (v)'
        }
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 0
        }
    },

    series: [{
        name: 'R',
        color: 'black',
        data: data_r
    }, {
        name: 'S',
        color: 'red',
        data: data_s
    }, {
        name: 'T',
        color: 'blue',
        data: data_t
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

    });
}

function drawTables(){
    // Add a div for table
  return;  
}

function arrayMin(arr) {
  var len = arr.length, min = Infinity;
  while (len--) {
    if (arr[len] < min) {
      min = arr[len];
    }
  }
  return min;
};

function arrayMax(arr) {
  var len = arr.length, max = -Infinity;
  while (len--) {
    if (arr[len] > max) {
      max = arr[len];
    }
  }
  return max;
};

setInterval(drawStatistics,60000);

</script>