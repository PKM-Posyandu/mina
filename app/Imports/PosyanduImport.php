<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PosyanduImport implements WithMultipleSheets
{
    protected bool $replace;

    public function __construct(bool $replace = false)
    {
        $this->replace = $replace;
    }
    public function sheets(): array
    {
        // Map Excel sheet names to target kategori for storage and routing
        return [
            'Imunisasi Dasar' => new SheetImport('Imunisasi Dasar', $this->replace),
            'ASI Eksklusif' => new SheetImport('ASI Eksklusif', $this->replace),
            'Pelayanan Balita' => new SheetImport('Pelayanan Kesehatan Balita', $this->replace),
            'Pelayanan Lansia' => new SheetImport('Pelayanan Kesehatan Lansia', $this->replace),
            'Pelayanan Ibu Hamil' => new SheetImport('Pelayanan Kesehatan Ibu Hamil', $this->replace),
            'Akseptor Aktif KB' => new SheetImport('Akseptor Aktif KB', $this->replace),
        ];
    }
}
