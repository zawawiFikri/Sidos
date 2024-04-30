<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\dosen;
use Illuminate\Support\Facades\Storage;
class JabatanController extends Controller
{
    public function jabatan()
    {
        $user = auth()->user();
        $dosen = $user->dosen;
        $jabatan = $dosen->jabatan;
        return view('Dosen.jabatan', [
            "dataJabatan" => $jabatan,
            "dataDosen" => $dosen,
        ]);
    }

    public function create(Request $request)
    {

        $message = [
            'id.required' => 'ID Jabatan tidak boleh kosong',
            'id.numeric' => 'ID Jabatan harus berupa angka',
            'id.unique' => 'ID Jabatan sudah digunakan',
            'nama_jabatan.required' => 'Nama Jabatan tidak boleh kosong',
            'file.required' => 'File harus bertipe pdf',
        ];

        $this->validate($request, [
            'id' => 'required|numeric|unique:jabatan',
            'nama_jabatan' => 'required',
            'file' => 'required|mimes:pdf',
        ], $message);

        $data = new Jabatan();
        $data->id = $request->id;
        $dosenId = auth()->user()->dosen->id;
        $data->dosen_id = $dosenId;
        $data->nama_jabatan = $request->nama_jabatan;
        $data->status = 0;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_jabatan', $fileName);

            $data->file = $fileName; 
        }

        $data->save();
        return redirect('/jabatan')->with('success', 'Data berhasil disimpan');
    }

    public function view($id)
    {
        $jabatan = Jabatan::find($id);

        if (!$jabatan) {
            abort(404); 
        }

        $filePath = public_path('storage/file_jabatan/' . $jabatan->file);

        return response()->file($filePath, ['Content-Type' => 'application/pdf']);
    }

    public function download($id)
    {
        $jabatan = Jabatan::find($id);
        $path = Storage::disk('public')->path('file_jabatan/' . $jabatan->file);
        return response()->download($path, $jabatan->file);
    }
}
