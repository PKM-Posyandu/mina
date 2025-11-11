<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cakupan Posyandu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 text-gray-900">
  <div class="max-w-6xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold">Cakupan Posyandu Mina</h1>
      <a href="/" class="text-blue-600 hover:underline">← Kembali</a>
    </div>

    <p class="text-gray-600 mb-6">Semua grafik per kategori ditampilkan dalam satu halaman.</p>

    <div id="charts" class="grid grid-cols-1 md:grid-cols-2 gap-6">
      @foreach($categories as $i => $cat)
        @php $cid = 'chart_'.($i); @endphp
        <div class="bg-white rounded-xl shadow p-5">
          <div class="flex items-center justify-between mb-2">
            <h2 class="font-semibold">{{ $cat }}</h2>
            <a class="text-blue-600 text-sm hover:underline" href="{{ url('/cakupan/'.rawurlencode($cat)) }}" target="_blank">Buka halaman</a>
          </div>
          <canvas id="{{ $cid }}" height="170"></canvas>
          <div id="empty_{{ $cid }}" class="hidden text-sm text-gray-500 mt-2">Belum ada data.</div>
        </div>
      @endforeach
    </div>
  </div>

  <script>
    const categories = @json($categories);

    function makeColors(n){
      const base = ['#2563eb','#16a34a','#f59e0b','#ef4444','#7c3aed','#0891b2','#dc2626','#059669','#7c2d12'];
      return Array.from({length: n}, (_,i)=> base[i % base.length]);
    }

    function buildChart(canvasId, kategori, payload){
      const ctx = document.getElementById(canvasId);
      if(!ctx){ return; }
      const isHorizontal = kategori === 'Imunisasi Dasar';
      const colors = makeColors((payload.datasets||[]).length);
      const datasets = (payload.datasets || []).map((ds, i) => {
        const base = { ...ds };
        if (ds.type === 'line') {
          base.borderColor = colors[i];
          base.backgroundColor = 'rgba(0,0,0,0)';
          base.borderWidth = ds.borderWidth || 2;
          base.pointRadius = 3;
          base.fill = false;
        } else {
          base.backgroundColor = colors[i];
          base.borderWidth = 0;
        }
        return base;
      });
      const hasY1 = datasets.some(d => d.yAxisID === 'y1');
      const pelayananCats = new Set(['Pelayanan Kesehatan Balita','Pelayanan Kesehatan Lansia','Pelayanan Kesehatan Ibu Hamil']);
      // For pelayanan kesehatan categories, force all datasets to use left axis 'y'
      if (pelayananCats.has(kategori)) {
        datasets.forEach(d => { d.yAxisID = 'y'; });
      }

      if ((payload.labels||[]).length === 0 || (payload.datasets||[]).length === 0){
        document.getElementById('empty_'+canvasId)?.classList.remove('hidden');
      }

      

      new Chart(ctx, {
        type: 'bar',
        data: { labels: payload.labels || [], datasets },
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
          },
          plugins: { legend: { display: true } }
        }
      });
    }

    categories.forEach((kategori, i) => {
      const id = 'chart_'+i;
      fetch(`/api/cakupan/${encodeURIComponent(kategori)}`)
        .then(r=>r.json())
        .then(payload=> buildChart(id, kategori, payload))
        .catch(err=>{
          console.error('Gagal memuat', kategori, err);
          document.getElementById('empty_'+id)?.classList.remove('hidden');
          document.getElementById('empty_'+id).textContent = 'Gagal memuat data.';
        });
    });
  </script>
</body>
</html>
