$(function () {
    const options = {
        series: [{
            data: data.earning,
            name: 'Revenus',
        }],
        chart: {
            toolbar: {
                show: false
            },
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
            }
        },
        dataLabels: {
            enabled: false,
        },
        tooltip : {
            style: {
                fontFamily: 'Oswald', 
            },
        },
        xaxis: {
            categories: data.last7Days,
            labels : {
                style: {
                    fontFamily: 'Oswald', 
                },
            },
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return val + "$";
                },
                style: {
                    fontFamily: 'Oswald', 
                },
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#salesChart"), options);
    chart.render();
})