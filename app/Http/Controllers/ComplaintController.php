<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response; // For file downloads
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel; // Assuming maatwebsite/excel package is installed
use App\Exports\ComplaintsExport; // We will create this export class later

use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    public function chartData()
    {
        $complaintsPerDay = Complaint::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $complaintsPerCategory = Complaint::select('kategori_pengaduan', DB::raw('count(*) as total'))
            ->groupBy('kategori_pengaduan')
            ->get();

        return response()->json([
            'complaintsPerDay' => $complaintsPerDay,
            'complaintsPerCategory' => $complaintsPerCategory,
        ]);
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $complaint->update([
            'is_resolved' => $request->boolean('is_resolved')
        ]);

        return redirect()->back()->with('status', 'Status pengaduan diperbarui.');
    }
    public function index(Request $request)
    {
        $query = Complaint::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('kategori_pengaduan', $request->category);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(10);

        $categories = [
            'Pendidikan', 'Kesehatan', 'Pekerjaan Umum', 'Perumahan Rakyat', 'Trantibunlinmas', 'Sosial'
        ];

        return view('complaints.index', compact('complaints', 'categories', 'request'));
    }

    public function exportPdf(Request $request)
    {
        $query = Complaint::query();

        // Apply filters
        if ($request->filled('category')) {
            $query->where('kategori_pengaduan', $request->category);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $complaints = $query->orderBy('created_at', 'desc')->get();

        // Ensure dompdf/dompdf is installed: composer require dompdf/dompdf
        $pdf = PDF::loadView('complaints.pdf', compact('complaints'));
        return $pdf->download('laporan_pengaduan.pdf');
    }

    public function exportExcel(Request $request)
    {
        // Ensure maatwebsite/excel is installed: composer require maatwebsite/excel
        // And create App\Exports\ComplaintsExport class
        return Excel::download(new ComplaintsExport($request), 'laporan_pengaduan.xlsx');
    }

    public function create()
    {
        return view('pages.pengaduan');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'kategori' => 'required|string|max:255',
            'pesan' => 'required|string',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:10',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $complaint = new Complaint();
        $complaint->nama_lengkap = $validatedData['nama'];
        $complaint->nomor_whatsapp = $validatedData['whatsapp'];
        $complaint->kategori_pengaduan = $validatedData['kategori'];
        $complaint->isi_pengaduan = $validatedData['pesan'];
        $complaint->alamat_lengkap = $validatedData['alamat'];
        $complaint->rt = $validatedData['rt'];

        if ($request->hasFile('bukti')) {
            $imagePath = $request->file('bukti')->store('complaint_bukti', 'public');
            $complaint->bukti = $imagePath;
        }

        $complaint->save();

        return redirect()->route('home')->with('success', 'Pengaduan Anda berhasil dikirim!');
    }
}
