<?php

namespace App\Http\Controllers;
use App\Models\DataAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataAjarController extends Controller
{
    public function dataAjar()
    {
        $user = auth()->user();
        $dosen = $user->dosen;
        $data_ajar = $dosen->data_ajar;
        return view('Dosen.matkul', [
            "dataAjar" => $data_ajar,
        ]);
    }

    public function create(Request $request)
    {

        $message = [
            'id.unique' => 'ID Data Ajar sudah digunakan',
            'matkul_id.required' => 'Data Mata Kuliah tidak boleh kosong',
            'sks.required' => 'SKS tidak boleh kosong',
            'sks.numeric' => 'Data SKS harus berupa angka',
            'kelas.required' => 'Data Kelas tidak boleh kosong',
            'thn_ajar.required' => 'Data Tahun Ajar tidak boleh kosong',
            'thn_ajar.numeric' => 'Data Tahun Ajar harus berupa angka',
            'file.required' => 'File harus bertipe pdf',
        ];

        $this->validate($request, [
            'id' => 'unique:data_ajar',
            'sks' => 'required|numeric',
            'kelas' => 'required',
            'thn_ajar' => 'required|numeric',
            'file' => 'required|mimes:pdf',
        ], $message);

        $data = new DataAjar();
        $data->id = rand(1, 500);
        $dosenId = auth()->user()->dosen->id;
        $data->dosen_id = $dosenId;
        $data->matkul = $request->matkul;
        $data->sks = $request->sks;
        $data->kelas = $request->kelas;
        $data->thn_ajar = $request->thn_ajar;
        $data->status = 0;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_nilai', $fileName);

            $data->file = $fileName;
        }

        $data->save();
        return redirect('/matkul')->with('success', 'Data berhasil disimpan');
    }

    public function view($id)
    {
        $dataAjar = DataAjar::find($id);

        if (!$dataAjar) {
            abort(404); // Jika tidak menemukan Data ajar
        }

        $filePath = public_path('storage/file_nilai/' . $dataAjar->file);

        return response()->file($filePath, ['Content-Type' => 'application/pdf']);
    }

    public function download($id)
    {
        $dataAjar = DataAjar::find($id);
        $path = Storage::disk('public')->path('file_nilai/' . $dataAjar->file);
        return response()->download($path, $dataAjar->file);
    }
}
