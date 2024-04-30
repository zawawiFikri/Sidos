<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dosen;
use App\Models\Serkom;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SerkomController extends Controller
{
    public function serkom()
    {
        $user = auth()->user();
        $dosen = $user->dosen;
        $serkom = $dosen->serkom;
        return view('Dosen.serkom', [
            "dataSerkom" => $serkom,
        ]);
    }

    public function create(Request $request)
    {

        $message = [
            'id.required' => 'Nomer Serkom tidak boleh kosong',
            'id.numeric' => 'Nomer Serkom harus berupa angka',
            'id.unique' => 'Nomer Serkom sudah digunakan',
            'bidang.required' => 'Bidang Keahlian tidak boleh kosong',
            'penerbit.required' => 'Data Penerbit tidak boleh kosong',
            'tgl_terbit.required' => 'Data Tanggal Terbit tidak boleh kosong',
            'file.required' => 'File harus bertipe pdf',
        ];

        $this->validate($request, [
            'id' => 'required|numeric|unique:serkom',
            'bidang' => 'required',
            'penerbit' => 'required',
            'tgl_terbit' => 'required',
            'file' => 'required|mimes:pdf',
        ], $message);

        $data = new Serkom();
        $data->id = $request->id;
        $dosenId = auth()->user()->dosen->id;
        $data->dosen_id = $dosenId;
        $data->bidang = $request->bidang;
        $data->penerbit = $request->penerbit;
        $data->tgl_terbit = $request->tgl_terbit;
        $data->status = 0;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_serkom', $fileName);

            $data->file = $fileName;
        }

        $data->save();
        return redirect('/serkom')->with('success', 'Data berhasil disimpan');
    }

    public function view($id)
    {
        $serkom = Serkom::find($id);

        if (!$serkom) {
            abort(404); // Jika tidak menemukan data Serkom
        }

        $filePath = public_path('storage/file_serkom/' . $serkom->file);

        return response()->file($filePath, ['Content-Type' => 'application/pdf']);
    }

    public function download($id)
    {
        $serkom = Serkom::find($id);
        $path = Storage::disk('public')->path('file_serkom/' . $serkom->file);
        return response()->download($path, $serkom->file);
    }
}
