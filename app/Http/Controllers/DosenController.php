<?php

namespace App\Http\Controllers;

use App\Models\dosen;
use App\Models\User;
use App\Models\Serkom;
use App\Models\Ijazah;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function editProfil()
    {
        $user = auth()->user();
        $dosen = $user->dosen;
        $serkom = $dosen->serkom;
        $ijazah = $dosen->ijazah;
        $jabatan = $dosen->jabatan;
        return view('Dosen.profil_dosen', compact('user', 'dosen', 'serkom', 'ijazah', 'jabatan'));
    }

    public function update(Request $request, User $user)
    {
        $message = [
            'nidn.required' => 'NIDN tidak boleh kosong',
            'nidn.numeric' => 'NIDN harus berupa angka',
            'nidn.unique' => 'NIDN sudah digunakan',
            'serdos.required' => 'Sertifikat Dosen tidak boleh kosong',
            'serdos.numeric' => 'Sertifikat Dosen harus berupa angka',
            'serdos.unique' => 'NIDN sudah digunakan',
            'name.required' => 'Nama Dosen tidak boleh kosong',
            'jenis_kelamin.required' => 'Data Jenis Kelamin tidak boleh kosong',
            'tgl_lahir.required' => 'Data Tanggal Lahir tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
        ];

        $this->validate($request, [
            //user
            'name' => 'required',
            'jenis_kelamin' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            //dosen
            'nidn' => 'required|numeric|unique:dosen,nidn,' . $user->dosen->id ?? '' . ',id',
            'serdos' => 'required|numeric|unique:dosen,serdos,' . $user->dosen->id ?? '' . ',id',
        ], $message);

        $user->name = $request->name;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tgl_lahir = $request->tgl_lahir;
        $user->alamat = $request->alamat;
        $user->save();

        $dosen = $user->dosen ?? new dosen();
        $dosen->nidn = $request->nidn;
        $dosen->serdos = $request->serdos;
        $dosen->save();

        $user->dosen()->save($dosen);

        return redirect('/edit_profil')->with('success', 'Data berhasil diperbarui');
    }


    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();
        $dosen = $user->dosen ?? new Dosen();

        $fotoProfil = $request->file('foto_profil');

        if ($dosen->foto_profil) {
            $previousFoto = $dosen->foto_profil;
    
            if ($user->id === $dosen->user_id) {
                Storage::delete('public/foto_profil_dosen/' . $previousFoto);
            }
        }

        if ($fotoProfil) {
            $extension = $fotoProfil->getClientOriginalExtension();
            $filename = time() . '_' . $fotoProfil->getClientOriginalName();
            $path = $fotoProfil->storeAs('foto_profil_dosen', $filename, 'public');

            $dosen->foto_profil = $filename;
            $dosen->save();

            return redirect()->back()->with('success', 'Foto profil berhasil diupdate.');
        }

        return redirect()->back()->with('error', 'Tidak ada file yang diupload atau format file tidak valid.');
    }
}
