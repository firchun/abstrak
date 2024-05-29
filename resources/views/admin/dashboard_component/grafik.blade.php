<div class="card mb-3 ">
    <div class="card-header ">
        <h4>Grafik Pengajuan Abstrak</h4>
    </div>
    <div class="card-body">
        <div id="grafik-pengajuan"></div>
    </div>
</div>
@push('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
   
    function getDataFromUrl(url) {
        return fetch(url)
            .then(response => response.json())
            .catch(error => console.error('Error:', error));
    }

    function initializeChart(data) {
        var options = {
            chart: {
                height: 350,
                type: 'line',
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                    }
                }
            },
            series: [{
                name: 'Total Pengajuan',
                type: 'line',
                data: data.total_pengajuan
            }],
            stroke: {
                width: [4]
            },
            title: {
                text: 'Grafik Pengajuan Abstrak'
            },
            labels: data.labels,
            xaxis: {
                type: 'categories'
            },
            yaxis: {
                title: {
                    text: 'Total Pengajuan'
                }
            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: [0]
            },
        };

        data.fakultas.forEach(function(fakultas) {
            options.series.push({
                name: fakultas.name,
                type: 'column',
                data: fakultas.data
            });
        });

        var chart = new ApexCharts(
            document.querySelector("#grafik-pengajuan"),
            options
        );

        chart.render();
    }

    getDataFromUrl('/grafik')
        .then(data => initializeChart(data));
</script>



@endpush