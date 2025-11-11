<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PosyanduImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CakupanController extends Controller
{
    public function form()
    {
        return view('admin.cakupan.upload');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required','file','mimes:xlsx,xls']
        ]);

        $file = $request->file('file');

        $replace = (bool) $request->boolean('replace');
        Excel::import(new PosyanduImport($replace), $file);

        return redirect()->back()->with('status', 'Import berhasil. Data telah disimpan.');
    }
}
