<?php

namespace App\Http\Controllers;

use App\Models\Req;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class RequestController extends Controller
{
    public function request()
    {
        $user = auth()->user();
        $dosen = $user->dosen;
        $requests = $dosen->request()->withTrashed()->where('hapus', 0)->get();

        return view('Dosen.request', [
            "dataRequest" => $requests,
        ]);
    }



    public function create(Request $request)
    {

        $message = [
            'id.unique' => 'Nomer request sudah digunakan',
            'jenis_req.required' => 'Jenis Request tidak boleh kosong',
            'isi_req.required' => 'Isi Request tidak boleh kosong',
        ];

        $this->validate($request, [
            'id' => 'unique:request',
            'jenis_req' => 'required',
            'isi_req' => 'required',
        ], $message);

        $data = new Req();
        $data->id = rand(1, 500);
        $dosenId = auth()->user()->dosen->id;
        $data->dosen_id = $dosenId;
        $data->jenis_req = $request->jenis_req;
        $data->isi_req = $request->isi_req;
        $data->status = 0;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_request', $fileName);

            $data->file = $fileName;
        }

        $data->save();
        return redirect('/request')->with('success', 'Data berhasil disimpan');
    }

    public function view($id)
    {
        $request = Req::withTrashed()->find($id);

        if (!$request) {
            abort(404); // Jika tidak menemukan data request
        }

        $filePath = public_path('storage/file_request/' . $request->file);

        return response()->file($filePath, ['Content-Type' => 'application/pdf']);
    }

    public function hapus($id)
    {
        $data = Req::findOrFail($id);
        $data->hapus = 1;
        $data->save();
        Cache::flush();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
