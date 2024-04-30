<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Admin;
use App\Models\dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class DataDosenController extends Controller
{
    public function dataUsers()
    {
        $user = auth()->user();
        $admin = $user->admin;
        $dataDosen = dosen::all();
        return view('Admin.dosen', [
            "dataDosen" => $dataDosen
        ]);
    }

    public function create(Request $request, $id)
    {

        if ($id == 0) {
            return redirect()->back()->with('warning', 'Data dosen tidak boleh kosong.');
        }

        $data = dosen::find($id);
        $message = [
            'nidn.unique' => 'Nomor NIDN sudah digunakan',
            'serdos.required' => 'Nomor Serdos tidak boleh kosong',
        ];

        $this->validate($request, [
            'nidn' => 'required',
            'serdos' => 'required',
        ], $message);

        if ($request->hasFile('foto_profil')) {
            $fotoProfil = $request->file('foto_profil');
            $extension = $fotoProfil->getClientOriginalExtension();
            $filename = time() . '_' . $fotoProfil->getClientOriginalName();
            $path = $fotoProfil->storeAs('foto_profil_dosen', $filename, 'public');

            $data->foto_profil = $filename;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_serdos', $fileName);

            $data->file = $fileName;
        }

        $data->nidn = $request->nidn;
        $data->serdos = $request->serdos;
        $data->save();
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function update(Request $request, $id)
    {

        $data = dosen::find($id);
        $message = [
            'nidn.unique' => 'Nomor NIDN sudah digunakan',
        ];

        $this->validate($request, [
            'nidn' => 'required',
        ], $message);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_serdos', $fileName);

            $data->file = $fileName;

        }
        $data->nidn = $request->nidn;
        $data->serdos = $request->serdos;
        if ($request->hasFile('foto_profil')) {
            $fotoProfil = $request->file('foto_profil');
            $extension = $fotoProfil->getClientOriginalExtension();
            $filename = time() . '_' . $fotoProfil->getClientOriginalName();
            $path = $fotoProfil->storeAs('foto_profil_dosen', $filename, 'public');

            $data->foto_profil = $filename;

        }

        $data->save();
        return redirect('/dosen')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $dsn = Dosen::find($id);
        if (
            $dsn->ijazah()->exists() ||
            $dsn->data_ajar()->exists() ||
            $dsn->jabatan()->exists() ||
            $dsn->serkom()->exists()
        ) {
            return redirect('/dosen')->with('warning', 'Data memiliki relasi!');
        }
        $dsn->delete();
        $dsn->user()->delete();
        Cache::flush();
        return redirect('/dosen')->with('success', 'Data berhasil dihapus');
    }

    public function view($id)
    {
        $dsn = Dosen::find($id);

        if (!$dsn) {
            abort(404);
        }

        $filePath = public_path('storage/file_serdos/' . $dsn->file);

        return response()->file($filePath, ['Content-Type' => 'application/pdf']);
    }
}
