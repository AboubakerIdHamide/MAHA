function renderDataChart(data) {
    const formateurs = [];
    const revenus = [];
    const soldCourses = [];

    console.log(data);

    data.forEach(function(row) {
        formateurs.push(row.nomComplet);
        revenus.push(Number(row.montantTotal));
        soldCourses.push(Number(row.nbrFormation));
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
            text: `Statistiques Formateur`,
            align: "center",
            style: {
                color: "#1D308A",
                fontFamily: "Inter, Arial, sans-serif",
            },
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [1],
        },
        labels: formateurs,
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

function getTop5Sellers($periode = 'today') {
    $.ajax({
        url : 'http://localhost/maha/admin/ajaxData/' + $periode,
        success: function (data) {
            $("#chart-1").html('');
            renderDataChart(JSON.parse(data)); 
        }
    });
}

getTop5Sellers();

$('#date').change(function (event) {
    getTop5Sellers($(this).val());
})

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

function dateCompare(dateD, dateR){
    let dateDebut = new Date(dateD);
    let dateFin = new Date(dateR);

    if(dateDebut <= dateFin){
        dateDebut = formatDate(dateD);
        dateFin = formatDate(dateR);
        $.ajax({
            url : `http://localhost/maha/admin/ajaxData?debut=${dateDebut}&fin=${dateFin}`,
            success: function (data) {
                $("#chart-1").html('');
                renderDataChart(JSON.parse(data));   
            }
        });
    }else{
        alert('Date Fin doit etre inferieur a date debut !');
    }
}

$('#chercher').click(function (event) {
    const debut = $('#debut').val();
    const fin = $('#fin').val();
    if(debut !== '' && fin !== ''){
        dateCompare(debut, fin);
    }else{
        alert('Veuillez Choissir les deux date !');
    }
});