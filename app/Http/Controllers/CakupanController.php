<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CakupanController extends Controller
{
    protected string $storagePath = 'cakupan.json';

    public function showPublic()
    {
        $data = $this->readData();
        return view('cakupan', ['data' => $data]);
    }

    public function showDashboard()
    {
        $data = $this->readData();
        return view('dashboard.cakupan', ['data' => $data]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $array = Excel::toArray(null, $request->file('file'));
        if (empty($array) || empty($array[0])) {
            return back()->withErrors(['file' => 'Berkas tidak berisi data lembar pertama.']);
        }

        $sheet = $array[0];
        // New expected format (supports multiple metrics per category):
        // Row 1 header: Kategori | Metrik | Label1 | Label2 | ...
        // Row 2..: category name | metric name | angka per label ...
        // Backward compatible with old format (Kategori | Label1..n)

        $headers = array_map(fn($h) => trim((string)$h), $sheet[0] ?? []);
        if (count($headers) < 2) {
            return back()->withErrors(['file' => 'Header tidak valid. Minimal Kategori dan satu label.']);
        }

        $hasMetricColumn = false;
        if (isset($headers[1])) {
            $second = mb_strtolower($headers[1]);
            $hasMetricColumn = in_array($second, ['metric', 'metrik', 'indikator']);
        }

        $labels = $hasMetricColumn ? array_slice($headers, 2) : array_slice($headers, 1);
        $series = [];
        foreach (array_slice($sheet, 1) as $row) {
            if (!isset($row[0]) || trim((string)$row[0]) === '') continue;
            $cat = trim((string)$row[0]);
            $metric = $hasMetricColumn ? trim((string)($row[1] ?? 'Nilai')) : 'Nilai';
            $startIdx = $hasMetricColumn ? 2 : 1;

            $values = [];
            for ($i = $startIdx; $i < count($row); $i++) {
                $v = $row[$i];
                $values[] = is_numeric($v) ? (float)$v : null;
            }
            $values = array_pad(array_slice($values, 0, count($labels)), count($labels), null);
            if (!isset($series[$cat])) $series[$cat] = [];
            $series[$cat][$metric] = $values;
        }

        // Save structure
        $payload = [
            'labels' => $labels,
            'series' => $series,
            'updated_at' => now()->toIso8601String(),
        ];
        Storage::put($this->storagePath, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('cakupan.dashboard')->with('status', 'Data cakupan berhasil diimpor.');
    }

    protected function readData(): array
    {
        if (!Storage::exists($this->storagePath)) {
            return [
                'labels' => [],
                'series' => [],
                'updated_at' => null,
            ];
        }
        $json = Storage::get($this->storagePath);
        $data = json_decode($json, true) ?: [];
        // Ensure keys
        $data['labels'] = $data['labels'] ?? [];
        $data['series'] = $data['series'] ?? [];
        return $data;
    }
}
