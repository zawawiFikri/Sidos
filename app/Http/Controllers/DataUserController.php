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

class DataUserController extends Controller
{
    public function dataUsers()
    {
        $user = auth()->user();
        $admin = $user->admin;
        $dataUser = User::all();
        $dataLevel = Role::all();
        return view('Admin.user', [
            "dataUser" => $dataUser,
            "dataLevel" => $dataLevel,
        ]);
    }

    public function create(Request $request)
    {
        $message = [
            'id.unique' => 'ID User sudah digunakan',
            'nik.unique' => 'Nomor NIDN sudah digunakan',
            'role_id.required' => 'Data Level tidak boleh kosong',
            'name.required' => 'Nama tidak boleh kosong',
            'jenis_kelamin.required' => 'Data Gender tidak boleh kosong',
            'tgl_lahir.required' => 'Data Tanggal Lahir tidak boleh kosong',
            'email.required' => 'Data Email tidak boleh kosong',
            'alamat.required' => 'Data Alamat tidak boleh kosong',
            'password.required' => 'Data Password tidak boleh kosong',
        ];

        $this->validate($request, [
            'id' => 'unique:dataUser',
            'nik' => 'required',
            'role_id' => 'required',
            'name' => 'required',
            'jenis_kelamin' => 'required',
            'tgl_lahir' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'password' => 'required',
        ], $message);

        $data = new User();
        $data->id = $request->id;
        $data->role_id = $request->input('role_id');
        $data->nik = $request->nik;
        $data->name = $request->name;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->email = $request->email;
        $data->alamat = $request->alamat;
        $data->password = Hash::make($request->password);
        $data->role_id = $request->input('role_id');

        $data->save();
        if ($request->input('role_id') == 1) {
            $admin = new Admin();
            $admin->user_id = $data->id;
            $admin->save();
        } else {
            $dosen = new dosen();
            $dosen->user_id = $data->id;
            $dosen->save();
        }
        return redirect('/userss')->with('success', 'Data berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $data = User::find($id);
        $message = [
            'nik.unique' => 'Nomor NIDN sudah digunakan',
            'role_id.required' => 'Data Level tidak boleh kosong',
            'name.required' => 'Nama tidak boleh kosong',
            'jenis_kelamin.required' => 'Data Gender tidak boleh kosong',
            'tgl_lahir.required' => 'Data Tanggal Lahir tidak boleh kosong',
            'email.required' => 'Data Email tidak boleh kosong',
            'alamat.required' => 'Data Alamat tidak boleh kosong',
        ];

        $this->validate($request, [
            'nik' => 'required',
            'role_id' => 'required',
            'name' => 'required',
            'jenis_kelamin' => 'required',
            'tgl_lahir' => 'required',
            'email' => 'required',
            'alamat' => 'required',
        ], $message);

        $data->nik = $request->nik;
        $data->name = $request->name;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->email = $request->email;
        $data->alamat = $request->alamat;
        $data->role_id = $request->input('role_id');

        if ($request->password) {
            $data->password = Hash::make($request->password);
        }

        if ($request->input('role_id') == 1) {
            $admin = new Admin();
            $admin->user_id = $data->id;
            $existingAdmin = Admin::where('user_id', $data->id)->count();

            if ($existingAdmin == 0) {
                $admin->save();
            }

            $dosen = dosen::where('user_id', $data->id)->first();

            if ($dosen) {
                $dosen->delete();
            }
        } else {
            $dosen = new dosen();
            $dosen->user_id = $data->id;
            $existingDosen = dosen::where('user_id', $data->id)->count();

            if ($existingDosen == 0) {
                $dosen->save();
            }

            $admin = Admin::where('user_id', $data->id)->first();

            if ($admin) {
                $admin->delete();
            }
        }

        $data->save();
        return redirect('/userss')->with('success', 'Data berhasil disimpan');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->admin) {            
            $user->admin()->delete();
            $user->delete();
            Cache::flush();
            return redirect('/userss')->with('success', 'Data berhasil dihapus');
        }

        if (
            $user->dosen->ijazah()->exists() ||
            $user->dosen->data_ajar()->exists() ||
            $user->dosen->serkom()->exists() ||
            $user->dosen->jabatan()->exists()
        ) {
            return redirect('/userss')->with('warning', 'Data memiliki relasi!');
        }
    
        $user->dosen->request()->forceDelete();
        
        $user->dosen()->delete();
        $user->delete();
        Cache::flush();

        return redirect('/userss')->with('success', 'Data berhasil dihapus');
    }

}
