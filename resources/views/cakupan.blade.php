<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cakupan Posyandu Mina</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
  </head>
  <body class="bg-white text-gray-900">
    <div class="max-w-6xl mx-auto px-6 py-10">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Cakupan Layanan</h1>
        <a href="/" class="text-blue-600 hover:underline">← Kembali</a>
      </div>

      @php
        $labels = $data['labels'] ?? [];
        // Backward compatibility: allow old shape where series[cat] = [values]
        $rawSeries = $data['series'] ?? [];
        $series = [];
        foreach($rawSeries as $cat => $value){
          if(is_array($value)){
            $isAssoc = array_keys($value) !== range(0, count($value) - 1);
            $series[$cat] = $isAssoc ? $value : ['Nilai' => $value];
          }
        }
        $categories = [
          'Imunisasi Dasar',
          'ASI Eksklusif',
          'Pelayanan Kesehatan Balita',
          'Pelayanan Kesehatan Lansia',
          'Pelayanan Kesehatan Ibu Hamil',
          'Pelayanan Kesehatan Akseptor Aktif KB',
        ];
      @endphp

      @if(empty($labels))
        <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded mb-6">
          <p>Belum ada data cakupan. Silakan impor data melalui <a href="{{ route('cakupan.dashboard') }}" class="text-blue-600 underline">Dashboard</a>.</p>
        </div>
      @endif

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($categories as $idx => $cat)
          <div class="bg-white rounded-lg shadow p-4">
            <h2 class="font-semibold mb-2">{{ $cat }}</h2>
            <canvas id="chart{{ $idx }}" height="160"></canvas>
          </div>
        @endforeach
      </div>
    </div>

    <script>
      const labels = @json($labels);
      const series = @json($series);
      const cats = @json($categories);

      function color(i){
        const palette = ['#2563eb','#16a34a','#f59e0b','#ef4444','#7c3aed','#0891b2'];
        return palette[i % palette.length];
      }

      const horizontalCats = new Set(['Imunisasi Dasar','ASI Eksklusif']);
      cats.forEach((cat, i) => {
        const ctx = document.getElementById('chart'+i);
        if(!ctx) return;
        const catSeries = (series && series[cat]) ? series[cat] : {};
        const datasets = [];
        let idx = 0;
        for (const [name, values] of Object.entries(catSeries)) {
          datasets.push({
            label: name,
            data: values,
            backgroundColor: color(idx++),
            borderWidth: 0
          });
        }
        if (datasets.length === 0) {
          datasets.push({ label: cat, data: [], backgroundColor: color(0) });
        }
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: datasets
          },
          options: {
            responsive: true,
            indexAxis: horizontalCats.has(cat) ? 'y' : 'x',
            plugins: {
              legend: { display: true },
              datalabels: {
                anchor: 'end',
                align: 'end',
                color: '#6b7280',
                formatter: (v) => (v==null? '': v)
              }
            },
            scales: {
              y: { beginAtZero: true, ticks: { stepSize: 10 } }
            }
          }
        });
      });
    </script>
  </body>
  </html>
