@extends('layouts.app')

@section('content')
@php
    use App\Models\Complaint;
    $totalComplaints = Complaint::count();
    $todayComplaints = Complaint::whereDate('created_at', now())->count();
@endphp

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <p class="text-uppercase text-muted mb-1" style="letter-spacing:.2em;">Dashboard Admin</p>
        <h1 class="h3" style="background:linear-gradient(90deg,#00B8F0,#E64FC5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Ringkasan Pengaduan</h1>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="p-4 rounded-4 h-100" style="background:rgba(0,184,240,.12);">
            <p class="text-muted mb-1">Total Pengaduan</p>
            <h3 class="mb-0">{{ $totalComplaints }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 rounded-4 h-100" style="background:rgba(230,79,197,.12);">
            <p class="text-muted mb-1">Pengaduan Hari Ini</p>
            <h3 class="mb-0">{{ $todayComplaints }}</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-3 rounded-3" style="background:linear-gradient(90deg, rgba(0,184,240,.08), rgba(230,79,197,.08));">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Pengaduan 7 Hari Terakhir</h6>
                    </div>
                    <div style="height: 320px;">
                        <canvas id="complaintsPerDayChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 rounded-3" style="background:linear-gradient(90deg, rgba(0,184,240,.08), rgba(230,79,197,.08));">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Pengaduan per Kategori</h6>
                    </div>
                    <div style="height: 320px;">
                        <canvas id="complaintsPerCategoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const complaintsPerDayCanvas = document.getElementById('complaintsPerDayChart');
    const complaintsPerCategoryCanvas = document.getElementById('complaintsPerCategoryChart');
    const complaintsPerDayCtx = complaintsPerDayCanvas.getContext('2d');
    const complaintsPerCategoryCtx = complaintsPerCategoryCanvas.getContext('2d');

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
                    // Gradient for line
                    const gradLine = complaintsPerDayCtx.createLinearGradient(0, 0, complaintsPerDayCanvas.width, 0);
                    gradLine.addColorStop(0, '#00B8F0');
                    gradLine.addColorStop(1, '#E64FC5');
                    const gradFill = complaintsPerDayCtx.createLinearGradient(0, 0, 0, complaintsPerDayCanvas.height);
                    gradFill.addColorStop(0, 'rgba(0,184,240,0.18)');
                    gradFill.addColorStop(1, 'rgba(230,79,197,0.05)');

                    complaintsPerDayChart = new Chart(complaintsPerDayCtx, {
                        type: 'line',
                        data: {
                            labels: labelsPerDay,
                            datasets: [{
                                label: 'Total Pengaduan',
                                data: dataPerDay,
                                borderColor: gradLine,
                                backgroundColor: gradFill,
                                fill: true,
                                tension: 0.35,
                                pointRadius: 3,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: gradLine,
                                pointBorderWidth: 2,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: true },
                                tooltip: { enabled: true }
                            },
                            scales: {
                                x: { grid: { display: false } },
                                y: { beginAtZero: true }
                            }
                        }
                    });
                }

                if (complaintsPerCategoryChart) {
                    complaintsPerCategoryChart.data.labels = labelsPerCategory;
                    complaintsPerCategoryChart.data.datasets[0].data = dataPerCategory;
                    complaintsPerCategoryChart.update();
                } else {
                    // Build a palette blending c1->c2
                    const baseColors = ['#00B8F0','#3CC0EC','#66BDE8','#8FB7E4','#B6ACE0','#DD9FDB','#E64FC5'];
                    const barColors = labelsPerCategory.map((_, i) => baseColors[i % baseColors.length]);
                    const barBorders = barColors.map(c => c);
                    complaintsPerCategoryChart = new Chart(complaintsPerCategoryCtx, {
                        type: 'bar',
                        data: {
                            labels: labelsPerCategory,
                            datasets: [{
                                label: 'Pengaduan per Kategori',
                                data: dataPerCategory,
                                backgroundColor: barColors.map(c => c + '33'),
                                borderColor: barBorders,
                                borderWidth: 2,
                                borderRadius: 8,
                                maxBarThickness: 38
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: { grid: { display: false } },
                                y: { beginAtZero: true }
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
