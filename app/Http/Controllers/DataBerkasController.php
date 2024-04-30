<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Admin;
use App\Models\dosen;
use App\Models\Ijazah;
use App\Models\Serkom;
use App\Models\DataAjar;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class DataBerkasController extends Controller
{
    public function dataBerkas()
    {
        $user = auth()->user();
        $admin = $user->admin;
        $dataDosen = dosen::all();
        return view('Admin.berkas', [
            "dataDosen" => $dataDosen,
        ]);
    }

    #Serkom
    public function create_serkom(Request $request, $id)
    {
        $id = (int)$id;
        $data = new Serkom();

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

        $data->id = $request->id;
        $data->dosen_id = $id;
        $data->bidang = $request->bidang;
        $data->penerbit = $request->penerbit;
        $data->tgl_terbit = $request->tgl_terbit;
        $data->status = 1;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_serkom', $fileName);

            $data->file = $fileName;
        }

        $data->save();
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function show_serkom(int $id)
    {
        $id = (int)$id;
        $dataDosen = dosen::findOrFail($id);
        $dataSerkom = $dataDosen->serkom;
        return view('Admin.serkom', compact('dataSerkom', 'dataDosen', 'id'));
    }

    public function show_serkomm(int $id)
    {
        $id = (int)$id;
        $dataSerkom = Serkom::findOrFail($id);
        return view('Admin.show_serkom', compact('dataSerkom', 'id'));
    }

    public function update_serkom(Request $request, $id)
    {
        $data = Serkom::findOrFail($id);
        $message = [
            'bidang.required' => 'Bidang Keahlian tidak boleh kosong',
            'penerbit.required' => 'Data Penerbit tidak boleh kosong',
            'tgl_terbit.required' => 'Data Tanggal Terbit tidak boleh kosong',
        ];

        $this->validate($request, [
            'bidang' => 'required',
            'penerbit' => 'required',
            'tgl_terbit' => 'required',
        ], $message);

        $data->bidang = $request->bidang;
        $data->penerbit = $request->penerbit;
        $data->tgl_terbit = $request->tgl_terbit;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_serkom', $fileName);

            $data->file = $fileName;
        }

        $data->save();
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function update_stt_serkom($id)
    {
        $data = Serkom::findOrFail($id);
        if ($data->status == 0) {
            $data->status = 1;
        }else{
            $data->status = 0;
        }
        $data->save();
        Cache::flush();
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }


    public function destroy_serkom($id)
    {
        $srk = Serkom::find($id);
        $srk->delete();
        Cache::flush();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }


    #Ijazah
    public function create_ijasah(Request $request, $id)
    {
        $id = (int)$id;

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
        $data->dosen_id = $id;
        $data->institusi = $request->institusi;
        $data->program_study = $request->program_study;
        $data->gelar = $request->gelar;
        $data->tgl_lulus = $request->tgl_lulus;
        $data->status = 1;
        // Menyimpan file PDF
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_ijazah', $fileName);

            $data->file = $fileName;
        }

        $data->save();
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function show_ijasah(int $id)
    {
        $id = (int)$id;
        $dataDosen = dosen::findOrFail($id);
        $dataIjazah = $dataDosen->ijazah;
        return view('Admin.ijazah', compact('dataIjazah', 'dataDosen', 'id'));
    }

    public function show_ijasahh(int $id)
    {
        $id = (int)$id;
        $dataIjazah = Ijazah::findOrFail($id);
        return view('Admin.show_ijazah', compact('dataIjazah', 'id'));
    }

    public function update_ijasah(Request $request, $id)
    {
        $data = Ijazah::findOrFail($id);
        $message = [
            'institusi.required' => 'Institusi tidak boleh kosong',
            'program_study.required' => 'Program Studi tidak boleh kosong',
            'gelar.required' => 'Gelar tidak boleh kosong',
            'tgl_lulus.required' => 'Data Tanggal Lulus tidak boleh kosong',
        ];

        $this->validate($request, [
            'institusi' => 'required',
            'program_study' => 'required',
            'gelar' => 'required',
            'tgl_lulus' => 'required',
        ], $message);

        $data->institusi = $request->institusi;
        $data->program_study = $request->program_study;
        $data->gelar = $request->gelar;
        $data->tgl_lulus = $request->tgl_lulus;
        $data->status = 1;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_ijazah', $fileName);

            $data->file = $fileName;
        }

        $data->save();
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function update_stt_ijasah($id)
    {
        $data = Ijazah::findOrFail($id);
        if ($data->status == 0) {
            $data->status = 1;
        }else{
            $data->status = 0;
        }
        $data->save();
        Cache::flush();
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }


    public function destroy_ijasah($id)
    {
        $srk = Ijazah::find($id);
        $srk->delete();
        Cache::flush();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }


    #Matkul
    public function create_mata(Request $request, $id)
    {
        $id = (int)$id;

        $message = [
            'id.unique' => 'ID Data Ajar sudah digunakan',
            'matkul_id.required' => 'Data Mata Kuliah tidak boleh kosong',
            'sks.required' => 'SKS tidak boleh kosong',
            'sks.numeric' => 'Data SKS harus berupa angka',
            'kelas.required' => 'Data Kelas tidak boleh kosong',
            'thn_ajar.required' => 'Data Tahun Ajar tidak boleh kosong',
            'thn_ajar.numeric' => 'Data Tahun Ajar harus berupa angka'
        ];

        $this->validate($request, [
            'id' => 'unique:data_ajar',
            'sks' => 'required|numeric',
            'kelas' => 'required',
            'thn_ajar' => 'required|numeric'
        ], $message);

        $data = new DataAjar();
        $data->id = rand(1, 500);
        $data->dosen_id = $id;
        $data->matkul = $request->matkul;
        $data->sks = $request->sks;
        $data->kelas = $request->kelas;
        $data->thn_ajar = $request->thn_ajar;
        $data->status = 1;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_nilai', $fileName);

            $data->file = $fileName;
        }

        $data->save();
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function show_mata(int $id)
    {
        $id = (int)$id;
        $dataDosen = dosen::findOrFail($id);
        $dataMata = $dataDosen->data_ajar;
        return view('Admin.matkul', compact('dataMata', 'dataDosen', 'id'));
    }

    public function show_mataa(int $id)
    {
        $id = (int)$id;
        $dataMata = DataAjar::findOrFail($id);
        return view('Admin.show_mata', compact('dataMata', 'id'));
    }

    public function update_mata(Request $request, $id)
    {
        $data = DataAjar::findOrFail($id);
        $message = [
            'sks.required' => 'SKS tidak boleh kosong',
            'sks.numeric' => 'Data SKS harus berupa angka',
            'kelas.required' => 'Data Kelas tidak boleh kosong',
            'thn_ajar.required' => 'Data Tahun Ajar tidak boleh kosong',
            'thn_ajar.numeric' => 'Data Tahun Ajar harus berupa angka'
        ];

        $this->validate($request, [
            'sks' => 'required|numeric',
            'kelas' => 'required',
            'thn_ajar' => 'required|numeric'
        ], $message);

        $data->matkul = $request->matkul;
        $data->sks = $request->sks;
        $data->kelas = $request->kelas;
        $data->thn_ajar = $request->thn_ajar;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_nilai', $fileName);

            $data->file = $fileName;
        }

        $data->save();
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function update_stt_mata($id)
    {
        $data = DataAjar::findOrFail($id);
        if ($data->status == 0) {
            $data->status = 1;
        }else{
            $data->status = 0;
        }
        $data->save();
        Cache::flush();
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy_mata($id)
    {
        $srk = DataAjar::find($id);
        $srk->delete();
        Cache::flush();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    #Jabatan
    public function create_jbt(Request $request, $id)
    {
        $id = (int)$id;

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
        $data->dosen_id = $id;
        $data->nama_jabatan = $request->nama_jabatan;
        $data->status = 1;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_jabatan', $fileName);

            $data->file = $fileName; 
        }

        $data->save();
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function show_jbt(int $id)
    {
        $id = (int)$id;
        $dataDosen = dosen::findOrFail($id);
        $dataJbt = $dataDosen->jabatan;
        return view('Admin.jabatan', compact('dataJbt', 'dataDosen', 'id'));
    }

    public function show_jbtt(int $id)
    {
        $id = (int)$id;
        $dataJbt = Jabatan::findOrFail($id);
        return view('Admin.show_jbt', compact('dataJbt', 'id'));
    }

    public function update_jbt(Request $request, $id)
    {
        $data = Jabatan::findOrFail($id);
        $message = [
            'nama_jabatan.required' => 'Nama Jabatan tidak boleh kosong',
        ];

        $this->validate($request, [
            'nama_jabatan' => 'required',
        ], $message);

        $data->nama_jabatan = $request->nama_jabatan;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/file_jabatan', $fileName);

            $data->file = $fileName; 
        }

        $data->save();
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function update_stt_jbt($id)
    {
        $data = Jabatan::findOrFail($id);
        if ($data->status == 0) {
            $data->status = 1;
        }else{
            $data->status = 0;
        }
        $data->save();
        Cache::flush();
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy_jbt($id)
    {
        $srk = Jabatan::find($id);
        $srk->delete();
        Cache::flush();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

}
