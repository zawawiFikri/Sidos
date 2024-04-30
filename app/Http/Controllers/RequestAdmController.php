<?php

namespace App\Http\Controllers;

use App\Models\Req;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class RequestAdmController extends Controller
{
    public function request()
    {
        $dataReq = Req::all();
        return view('Admin.request',[
            "dataRequest" => $dataReq,
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
        return redirect('/requests')->with('success', 'Data berhasil disimpan');
    }

    public function view($id)
    {
        $request = Req::find($id);

        if (!$request) {
            abort(404); 
        }

        $filePath = public_path('storage/file_request/' . $request->file);

        return response()->file($filePath, ['Content-Type' => 'application/pdf']);
    }

    public function update($id)
    {
        $request = Req::find($id);
        if (!$request) {
            abort(404);
        }
        $request->status = 1;
        $request->save();
        Cache::flush();
        return redirect('/requests')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $request = Req::find($id);
        $request->delete();
        Cache::flush();
        return redirect('/requests')->with('success', 'Data berhasil dibersiihkan');
    }

}
