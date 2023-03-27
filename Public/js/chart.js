const states = $.parseJSON($.ajax({
    url: "http://localhost/maha/admin/getAllFormateurs/",
    dataType: "json",
    async: false,
}).responseText);

const names = [];
states.forEach(function(f) {
    names.push({
        value: f.id_formateur,
        label: f.nom_formateur + " " + f.prenom_formateur,
    });
});

$("#formateur").autocomplete({
    delay: 0,
    source: names,
}).on("autocompleteselect", function(event, ui) {
    $("#chart-1").html("");
    const data = $.parseJSON($.ajax({
        url: "http://localhost/maha/admin/ajaxData/" + ui.item.value,
        dataType: "json",
        async: false,
    }).responseText);

    renderDataChart1(data, ui.item.label);
    $("#formateur").text(ui.item.label);
}).on("autocompleteclose", function() {
    $(this).val("");
});

function renderDataChart1(data, nomFormateur) {
    const dates = [];
    const revenus = [];
    const soldCourses = [];

    data.forEach(function(row) {
        dates.push(row.dateInscription);
        revenus.push(row.totalRevenue);
        soldCourses.push(Number(row.inscriptions));
    });

    const options = {
        series: [{
            name: "Revenu",
            type: "column",
            data: revenus,
        }, {
            name: "Ventes",
            type: "line",
            data: soldCourses,
        }, ],
        chart: {
            height: 350,
            type: "line",
        },
        stroke: {
            width: [0, 4],
        },
        title: {
            text: `Statistiques Formateur (${nomFormateur})`,
            align: "center",
            style: {
                color: "#0d6efd",
                fontFamily: "Inter, Arial, sans-serif",
            },
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [1],
        },
        labels: dates,
        yaxis: [{
            title: {
                text: "Revenu en $",
            },
            labels: {
                formatter: function(val, index) {
                    return val + " $";
                },
            },
        }, {
            opposite: true,
            title: {
                text: "Ventes",
            },
            min: 1,
            labels: {
                formatter: function(val, index) {
                    return parseInt(val);
                },
            },
        }, ],
    };

    const chart = new ApexCharts(document.querySelector("#chart-1"),options);
    chart.render();
}

function renderDataChart2() {
    const data = $.parseJSON($.ajax({
        url: "http://localhost/maha/admin/getTop10BestSellers",
        dataType: "json",
        async: false,
    }).responseText);
    const totalRevenu = [];
    const names = [];

    data.forEach(function(row) {
        names.push(row.nom);
        totalRevenu.push(row.totalRevenu);
    });

    const options = {
        series: [{
            name: "Total Revenu",
            data: totalRevenu,
        }, ],
        chart: {
            type: "bar",
            height: 350,
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
            },
        },
        title: {
            text: "Top 10 meilleurs vendeurs",
            align: "center",
            style: {
                color: "#0d6efd",
                fontFamily: "Inter, Arial, sans-serif",
            },
        },
        dataLabels: {
            enabled: false,
        },
        xaxis: {
            categories: names,
            labels: {
                formatter: function(val, index) {
                    return val + " $";
                },
            },
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " $";
                },
            },
        },
    };

    const chart = new ApexCharts(document.querySelector("#chart-2"),options);
    chart.render();
}

renderDataChart2();
