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
        // Expect: Row 1 header: Category | Col2..n labels (bulan/periode)
        // Row 2..: category name + angka per kolom
        $headers = array_map(fn($h) => trim((string)$h), $sheet[0] ?? []);
        if (count($headers) < 2) {
            return back()->withErrors(['file' => 'Header tidak valid. Pastikan kolom pertama kategori, kolom berikutnya label (bulan/periode).']);
        }

        $labels = array_slice($headers, 1);
        $series = [];
        foreach (array_slice($sheet, 1) as $row) {
            if (!isset($row[0]) || trim((string)$row[0]) === '') {
                continue;
            }
            $name = trim((string)$row[0]);
            $values = [];
            for ($i = 1; $i < count($row); $i++) {
                $v = $row[$i];
                $values[] = is_numeric($v) ? (float)$v : null;
            }
            // Normalize length to labels
            $values = array_pad(array_slice($values, 0, count($labels)), count($labels), null);
            $series[$name] = $values;
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

