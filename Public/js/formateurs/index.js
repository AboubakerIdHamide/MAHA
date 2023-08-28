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
        xaxis: {
            categories: data.last7Days,
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return val + "$";
                },
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#salesChart"), options);
    chart.render();
})