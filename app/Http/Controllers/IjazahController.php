<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ijazah;
use App\Models\dosen;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class IjazahController extends Controller
{
    public function ijazah()
    {
        $user = auth()->user();
        $dosen = $user->dosen;
        $ijazah= $dosen->ijazah;
        return view('Dosen.ijazah', [
            "dataIjazah" => $ijazah,
        ]);
    }

    public function create(Request $request)
    {

        $message = [
            'id.required' => 'Nomer Ijazah tidak boleh kosong',
            'id.numeric' => 'Nomer Ijazah harus berupa angka',
            'id.unique' => 'Nomer Ijazah sudah digunakan',
            'institusi.required' => 'Institusi tidak boleh kosong',
            'program_study.required' => 'Program Studi tidak boleh kosong',
            'gelar.required' => 'Gelar tidak boleh kosong',
            'tgl_lulus.required' => 'Data Tanggal Lulus tidak boleh kosong',
            'file.required' => 'File harus bertipe pdf',
        ];

        $this->validate($request, [
            'id' => 'required|numeric|unique:ijazah',
            'institusi' => 'required',
            'program_study' => 'required',
            'gelar' => 'required',
            'tgl_lulus' => 'required',
            'file' => 'required|mimes:pdf',
        ], $message);

        $data = new Ijazah();
        $data->id = $request->id;
        $dosenId = auth()->user()->dosen->id;
        $data->dosen_id = $dosenId;
        $data->institusi = $request->institusi;
        $data->program_study = $request->program_study;
        $data->gelar = $request->gelar;
        $data->tgl_lulus = $request->tgl_lulus;
        $data->status = 0;
        // Menyimpan file PDF
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_ijazah', $fileName);

            $data->file = $fileName;
        }

        $data->save();
        return redirect('/ijazah')->with('success', 'Data berhasil disimpan');
    }

    public function view($id)
    {
        $ijazah = Ijazah::find($id);

        if (!$ijazah) {
            abort(404); // Jika tidak menemukan data Ijazah
        }

        $filePath = public_path('storage/file_ijazah/' . $ijazah->file);

        return response()->file($filePath, ['Content-Type' => 'application/pdf']);
    }

    public function download($id)
    {
        $ijazah = Ijazah::find($id);
        $path = Storage::disk('public')->path('file_ijazah/' . $ijazah->file);
        return response()->download($path, $ijazah->file);
    }
}
