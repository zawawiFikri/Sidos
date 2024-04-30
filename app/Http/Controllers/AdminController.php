<?php

namespace App\Http\Controllers;

use App\Models\dosen;
use App\Models\Admin;
use App\Models\User;
use App\Models\Serkom;
use App\Models\Ijazah;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function editProfil()
    {
        $user = auth()->user();
        $admin = $user->admin;
        return view('Admin.profil_admin', compact('user', 'admin'));
    }

    public function update(Request $request, User $user)
    {
        $message = [
            'nidn.required' => 'NIDN tidak boleh kosong',
            'nidn.numeric' => 'NIDN harus berupa angka',
            'nidn.unique' => 'NIDN sudah digunakan',
            'name.required' => 'Nama Admin tidak boleh kosong',
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
            'nidn' => 'required|numeric|unique:admin,nidn,' . $user->admin->id ?? '' . ',id',
        ], $message);

        $user->name = $request->name;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tgl_lahir = $request->tgl_lahir;
        $user->alamat = $request->alamat;
        $user->save();

        $admin = $user->admin ?? new Admin();
        $admin->nidn = $request->nidn;
        $admin->save();

        $user->admin()->save($admin);

        return redirect()->back()->with('success', 'Data berhasil diupdate.');
    }


    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();
        $admin = $user->admin ?? new Admin();

        $fotoProfil = $request->file('foto_profil');

        if ($admin->foto_profil) {
            $previousFoto = $admin->foto_profil;
    
            if ($user->id === $admin->user_id) {
                Storage::delete('public/foto_profil_admin/' . $previousFoto);
            }
        }

        if ($fotoProfil) {
            $extension = $fotoProfil->getClientOriginalExtension();
            $filename = time() . '_' . $fotoProfil->getClientOriginalName();
            $path = $fotoProfil->storeAs('foto_profil_admin', $filename, 'public');

            $admin->foto_profil = $filename;
            $admin->save();

            return redirect()->back()->with('success', 'Foto profil berhasil diupdate.');
        }

        return redirect()->back()->with('error', 'Tidak ada file yang diupload atau format file tidak valid.');
    }
}
