<?php

namespace App\Imports;

use App\Models\IndikatorPosyandu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SheetImport implements ToCollection, WithHeadingRow
{
    protected string $kategori;
    protected bool $replace;
    protected bool $didClear = false;

    public function __construct(string $kategori, bool $replace = false)
    {
        $this->kategori = $kategori;
        $this->replace = $replace;
    }

    public function collection(Collection $rows)
    {
        // Optional: replace existing data for this category once per sheet present
        if ($this->replace && !$this->didClear) {
            IndikatorPosyandu::where('kategori', $this->kategori)->delete();
            $this->didClear = true;
        }

        foreach ($rows as $row) {
            // WithHeadingRow lowercases and snake_cases keys
            $array = $row->toArray();
            $labelKey = null;
            foreach (['vaksin', 'bulan', 'kelompok'] as $candidate) {
                if (array_key_exists($candidate, $array)) {
                    $labelKey = $candidate;
                    break;
                }
            }
            if (!$labelKey) {
                continue;
            }

            $label = trim((string)($array[$labelKey] ?? ''));
            if ($label === '') {
                continue;
            }

            foreach ($array as $key => $value) {
                if ($key === $labelKey) {
                    continue; // skip label-defining column
                }
                if ($value === null || $value === '') {
                    continue;
                }
                // Only keep numeric-like values
                if (!is_numeric($value)) {
                    continue;
                }

                $metrik = $this->formatMetrik($key);

                IndikatorPosyandu::create([
                    'kategori' => $this->kategori,
                    'label' => $label,
                    'metrik' => $metrik,
                    'subkategori' => null,
                    'nilai' => (int) round($value),
                ]);
            }
        }
    }

    protected function formatMetrik(string $key): string
    {
        $k = trim($key);
        if ($k === 'jml') {
            return 'JML';
        }
        // make snake_case to Title Case (S, K, etc. become uppercase)
        if (strlen($k) === 1) {
            return strtoupper($k);
        }
        $k = str_replace(['_', '-'], ' ', $k);
        $k = preg_replace('/\s+/', ' ', $k);
        return ucwords(strtolower($k));
    }
}
