<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cakupan: {{ $kategori }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-white text-gray-900">
  <div class="max-w-5xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Cakupan: {{ $kategori }}</h1>
      <a href="/" class="text-blue-600 hover:underline">← Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
      <canvas id="chart" height="160"></canvas>
    </div>
  </div>

  <script>
    const kategori = @json($kategori);

    fetch(`/api/cakupan/${encodeURIComponent(kategori)}`)
      .then(r => r.json())
      .then(payload => {
        const ctx = document.getElementById('chart');
        const isHorizontal = kategori === 'Imunisasi Dasar';
        const datasets = (payload.datasets || []).map(ds => ({
          ...ds,
          backgroundColor: ds.type === 'line' ? 'rgba(37, 99, 235, 0.2)' : undefined,
          borderColor: ds.type === 'line' ? '#2563eb' : undefined,
          borderWidth: ds.type === 'line' ? (ds.borderWidth || 2) : 0,
          fill: ds.type === 'line' ? false : true,
        }));
        const hasY1 = datasets.some(d => d.yAxisID === 'y1');
        const pelayananCats = new Set(['Pelayanan Kesehatan Balita','Pelayanan Kesehatan Lansia','Pelayanan Kesehatan Ibu Hamil']);
        // For pelayanan kesehatan categories, force all datasets to use left axis 'y'
        if (pelayananCats.has(kategori)) {
          datasets.forEach(d => { d.yAxisID = 'y'; });
        }

        const yLabelHideThreshold = {
          'Pelayanan Kesehatan Balita': 60,
          'Pelayanan Kesehatan Lansia': 80,
          'Pelayanan Kesehatan Ibu Hamil': 3.0,
        };

        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: payload.labels || [],
            datasets: datasets,
          },
          options: {
            responsive: true,
            indexAxis: isHorizontal ? 'y' : 'x',
            scales: {
              y: pelayananCats.has(kategori)
                    ? { beginAtZero: true, min: 0, max: 120, ticks: { stepSize: 20 } }
                    : { beginAtZero: true },
              y1: {
                display: !pelayananCats.has(kategori) && datasets.some(ds => ds.yAxisID === 'y1'),
                beginAtZero: true,
                position: 'right',
                min: 0,
                max: 120,
                grid: { drawOnChartArea: false }
              }
            }
          }
        });
      })
      .catch(err => {
        console.error(err);
        alert('Gagal memuat data cakupan.');
      });
  </script>
</body>
</html>
