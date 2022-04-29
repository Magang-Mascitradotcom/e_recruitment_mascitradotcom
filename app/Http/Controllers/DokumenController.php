<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Dokumen;

class DokumenController extends Controller
{
    public function create()
    {
        $dokumens = Dokumen::orderBy('created_at', 'DESC')->get();
        return view('form.dokumen.create', compact('dokumens'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'file' => 'required|mimes:doc,docx,xls,xlsx,pdf,jpg,jpeg,png,bmp',
        'jenis' => 'required'
    ]);

    if($request->hasFile('file')) {
        $uploadPath = public_path('uploads');

        if(!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true, true);
        }

        $file = $request->file('file');
        $explode = explode('.', $file->getClientOriginalName());
        $originalName = $explode[0];
        $extension = $file->getClientOriginalExtension();
        $rename = 'file_' . date('YmdHis') . '.' . $extension;
        $jenis = $request->jenis;

        if($file->move($uploadPath, $rename)) {
            $dokumen = new Dokumen;
            $dokumen->jenis = $jenis;
            $dokumen->nama_file = $originalName;
            $dokumen->file = $rename;
            $dokumen->ekstensi = $extension;
            $dokumen->save();

        return redirect()->back()->with('message', 'Berhasil, file telah di upload');
    }
        return redirect()->back()->with('message', 'Error, file tidak dapat di upload');
    }
        return redirect()->back()->with('message', 'Error, tidak ada file ditemukan');
    }

    public function destroy($id)
    {
    $dokumen = Dokumen::find($id);

    if($dokumen) {
        $file = public_path('uploads/' . $dokumen->file);

        if(File::exists($file)) {
            File::delete($file);
        }

        $dokumen->delete();

        return redirect()->back()->with('message', 'Berhasil, file berhasil dihapus');
    }

        return redirect()->back()->with('message', 'Error, tidak ada file ditemukan');
    }
}
