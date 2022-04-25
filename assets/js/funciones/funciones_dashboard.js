$(document).ready(function() {
    grafica1();
    grafica2();
    //grafica3();
    //grafica4();
});

function grafica1() {
    let base_url = $("#base_url").val();
    $.ajax({
        url: base_url + "/dashboard/grafica1",
        method: "POST",
        success: function(data) {
            var producto = [];
            var total = [];
            var obj = jQuery.parseJSON(data);
            var sales = [];
            for (var i in obj) {
                producto.push(obj[i].producto);
                total.push(obj[i].total);
                var json = { "name": (obj[i].producto), "data": [parseFloat(obj[i].total)] }
                sales.push(json);
            }
            Highcharts.chart('container1', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'TOTAL DE PROMOCIONES POR SUCURSAL'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'TOTAL DE PROMOCIONES'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f} </b> PROMOCIONESL<br/>'
                },
                series: sales,
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function grafica2() {
    let base_url = $("#base_url").val();
    $.ajax({
        url: base_url + "/dashboard/grafica2",
        method: "POST",
        success: function(data) {
            var producto = [];
            var total = [];
            var obj = jQuery.parseJSON(data);
            var sales = [];
            for (var i in obj) {
                producto.push(obj[i].producto);
                total.push(obj[i].total);
                var json = { "name": (obj[i].producto), "data": [parseFloat(obj[i].total)] }
                sales.push(json);
            }
            Highcharts.chart('container2', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'PROMOCIONES HECHAS POR ESTABLECIMIENTOS'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    categories: producto,
                },
                yAxis: {
                    title: {
                        text: 'ESTABLECIMIENTOS'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> DE PROMOCIONES<br/>'
                },
                series: sales,
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
}


function reload1() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/dashboard';
}