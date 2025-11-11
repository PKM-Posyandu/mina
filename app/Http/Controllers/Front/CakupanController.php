<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\IndikatorPosyandu;
use Illuminate\Http\Request;

class CakupanController extends Controller
{
    public function index()
    {
        $categories = [
            'Imunisasi Dasar',
            'ASI Eksklusif',
            'Pelayanan Kesehatan Balita',
            'Pelayanan Kesehatan Lansia',
            'Pelayanan Kesehatan Ibu Hamil',
            'Akseptor Aktif KB',
        ];
        return view('cakupan_index', compact('categories'));
    }

    public function show(string $kategori)
    {
        return view('cakupan', compact('kategori'));
    }

    public function api(string $kategori)
    {
        $data = IndikatorPosyandu::where('kategori', $kategori)->get();

        // Collect labels
        $labels = $data->pluck('label')->unique()->values()->toArray();
        $labels = $this->sortLabels($labels, $kategori);

        // Collect metrics
        $metrics = $data->pluck('metrik')->unique()->values()->toArray();

        // Force order for certain categories
        if ($kategori === 'Imunisasi Dasar') {
            $metrics = $this->prioritizeMetrics($metrics, ['Capaian', 'Sasaran']);
        }

        $datasets = [];
        foreach ($metrics as $metrik) {
            $series = array_fill(0, count($labels), null);
            foreach ($labels as $i => $label) {
                $row = $data->firstWhere('label', $label);
                // Could be multiple rows per label+metrik; filter
                $row = $data->first(function($r) use ($label, $metrik) {
                    return $r->label === $label && $r->metrik === $metrik;
                });
                if ($row) {
                    $series[$i] = (int) $row->nilai;
                }
            }
            $ds = [
                'label' => $metrik,
                'data' => $series,
                'yAxisID' => (stripos($metrik, 'persen') !== false) ? 'y1' : 'y',
            ];
            if ($kategori === 'Akseptor Aktif KB' && strtoupper($metrik) === 'JML') {
                $ds['type'] = 'line';
                $ds['borderWidth'] = 2;
            }
            $datasets[] = $ds;
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => $datasets,
        ]);
    }

    protected function sortLabels(array $labels, string $kategori): array
    {
        $months = [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];
        $monthlyCats = [
            'ASI Eksklusif',
            'Pelayanan Kesehatan Balita',
            'Pelayanan Kesehatan Lansia',
            'Pelayanan Kesehatan Ibu Hamil',
        ];
        if (in_array($kategori, $monthlyCats, true)) {
            usort($labels, function($a, $b) use ($months) {
                $ia = array_search($a, $months, true);
                $ib = array_search($b, $months, true);
                $ia = $ia === false ? PHP_INT_MAX : $ia;
                $ib = $ib === false ? PHP_INT_MAX : $ib;
                return $ia <=> $ib;
            });
            return $labels;
        }
        if ($kategori === 'Akseptor Aktif KB' || $kategori === 'Imunisasi Dasar') {
            sort($labels, SORT_NATURAL | SORT_FLAG_CASE);
            return $labels;
        }
        return $labels;
    }

    protected function prioritizeMetrics(array $metrics, array $preferred): array
    {
        $set = [];
        foreach ($preferred as $p) {
            if (in_array($p, $metrics, true)) {
                $set[] = $p;
            }
        }
        foreach ($metrics as $m) {
            if (!in_array($m, $set, true)) {
                $set[] = $m;
            }
        }
        return $set;
    }
}
