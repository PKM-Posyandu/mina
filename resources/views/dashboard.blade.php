@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="complaintsPerDayChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="complaintsPerCategoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const complaintsPerDayCtx = document.getElementById('complaintsPerDayChart').getContext('2d');
    const complaintsPerCategoryCtx = document.getElementById('complaintsPerCategoryChart').getContext('2d');

    let complaintsPerDayChart, complaintsPerCategoryChart;

    function updateCharts() {
        fetch('{{ route('complaints.chartData') }}')
            .then(response => response.json())
            .then(data => {
                const complaintsPerDay = data.complaintsPerDay;
                const complaintsPerCategory = data.complaintsPerCategory;

                const labelsPerDay = complaintsPerDay.map(item => item.date);
                const dataPerDay = complaintsPerDay.map(item => item.total);

                const labelsPerCategory = complaintsPerCategory.map(item => item.kategori_pengaduan);
                const dataPerCategory = complaintsPerCategory.map(item => item.total);

                if (complaintsPerDayChart) {
                    complaintsPerDayChart.data.labels = labelsPerDay;
                    complaintsPerDayChart.data.datasets[0].data = dataPerDay;
                    complaintsPerDayChart.update();
                } else {
                    complaintsPerDayChart = new Chart(complaintsPerDayCtx, {
options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }

                if (complaintsPerCategoryChart) {
                    complaintsPerCategoryChart.data.labels = labelsPerCategory;
                    complaintsPerCategoryChart.data.datasets[0].data = dataPerCategory;
                    complaintsPerCategoryChart.update();
                } else {
                    complaintsPerCategoryChart = new Chart(complaintsPerCategoryCtx, {
                        type: 'bar',
                        data: {
                            labels: labelsPerCategory,
                            datasets: [{
                                label: 'Pengaduan per Kategori',
                                data: dataPerCategory,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });
    }

    updateCharts();
    setInterval(updateCharts, 5000);
</script>
@endsection
