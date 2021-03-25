<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script>
    var data = {
            labels: ["Jakarta", "Bali", "Jawa Tengah", "Jawa Barat", "Kalimantan Tengah"],
            datasets: [
                {
                    label: "DOR",
                    backgroundColor: ["#0000CD", "#0000CD","#0000CD","#0000CD","#0000CD"],
                    data: [2478,5267,734,784,433]
                },
                {
                    label: "WOR",
                    backgroundColor: ["#FF8C00", "#FF8C00","#FF8C00","#FF8C00","#FF8C00"],
                    data: [2600,6000,800,800,500]
                }
            ]
        };
    new Chart(document.getElementById("bar-chart-horizontal"), {
        type: 'horizontalBar',
        data: data,
        options: {
            legend: { 
                display: true,
                labels: {
                    fontColor: 'rgb(0,0,0)'
                }
            },
            title: {
                display: true,
                text: 'Report Total DOR & WOR'
            },
            scales: {
                xAxes: [{
                    stacked: true
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });
</script>