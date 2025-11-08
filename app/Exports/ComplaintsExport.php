<?php

namespace App\Exports;

use App\Models\Complaint;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class ComplaintsExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Complaint::query();

        // Apply filters
        if ($this->request->filled('category')) {
            $query->where('kategori_pengaduan', $this->request->category);
        }
        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('created_at', [$this->request->start_date . ' 00:00:00', $this->request->end_date . ' 23:59:59']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap',
            'Nomor Whatsapp',
            'Kategori Pengaduan',
            'Isi Pengaduan',
            'Alamat Lengkap',
            'RT',
            'Bukti',
            'Tanggal Laporan',
            'Updated At',
        ];
    }
}