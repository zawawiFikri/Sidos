<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SerkomController;
use App\Http\Controllers\IjazahController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\DataAjarController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\DataDosenController;
use App\Http\Controllers\DataBerkasController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RequestAdmController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

require __DIR__ . '/auth.php';

Route::redirect('/', 'login');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});

Route::middleware('isAdmin')->group(function () {
    //User
    Route::get('userss', [DataUserController::class, 'dataUsers'])->name('userss');
    Route::post('/create_user', [DataUserController::class, 'create'])->name('create_user'); 
    Route::post('/edit_data_user/{id}', [DataUserController::class, 'update'])->name('edit_data_user');  
    Route::post('/delete_user/{id}', [DataUserController::class, 'destroy'])->name('delete_user');   
    
    //Dosen
    Route::get('dosen', [DataDosenController::class, 'dataUsers'])->name('dosen');
    Route::post('/create_data_dosen/{id}', [DataDosenController::class, 'create'])->name('create_data_dosen');  
    Route::post('/edit_data_dosen/{id}', [DataDosenController::class, 'update'])->name('edit_data_dosen');  
    Route::post('/delete_dosen/{id}', [DataDosenController::class, 'destroy'])->name('delete_dosen');   
    Route::get('/view-pdf-serdos/{id}', [DataDosenController::class, 'view'])->name('view_pdf_serdos');
    

    //Berkas
    Route::get('berkas', [DataBerkasController::class, 'dataBerkas'])->name('berkas');
    //Serkom
    Route::post('/create_serkomm/{id}', [DataBerkasController::class, 'create_serkom'])->name('create_serkomm');
    Route::get('/show-serkom/{id}', [DataBerkasController::class, 'show_serkom'])->name('show-serkom');
    Route::get('/show-serkomm/{id}', [DataBerkasController::class, 'show_serkomm'])->name('show-serkomm');
    Route::post('/edit_data_serkom/{id}', [DataBerkasController::class, 'update_serkom'])->name('edit_data_serkom');  
    Route::post('/check-serkom/{id}', [DataBerkasController::class, 'update_stt_serkom'])->name('check_serkom');
    Route::post('/delete_serkom/{id}', [DataBerkasController::class, 'destroy_serkom'])->name('delete_serkom');       
    //Ijazah
    Route::post('/create_ijasah/{id}', [DataBerkasController::class, 'create_ijasah'])->name('create_ijasah');
    Route::get('/show-ijasah/{id}', [DataBerkasController::class, 'show_ijasah'])->name('show-ijasah');
    Route::get('/show-ijasahh/{id}', [DataBerkasController::class, 'show_ijasahh'])->name('show-ijasahh');
    Route::post('/edit_data_ijasah/{id}', [DataBerkasController::class, 'update_ijasah'])->name('edit_data_ijasah');  
    Route::post('/check-ijasah/{id}', [DataBerkasController::class, 'update_stt_ijasah'])->name('check_ijasah');
    Route::post('/delete_ijasah/{id}', [DataBerkasController::class, 'destroy_ijasah'])->name('delete_ijasah');       
    //Matkul
    Route::post('/create_mata/{id}', [DataBerkasController::class, 'create_mata'])->name('create_mata');
    Route::get('/show-mata/{id}', [DataBerkasController::class, 'show_mata'])->name('show-mata');
    Route::get('/show-mataa/{id}', [DataBerkasController::class, 'show_mataa'])->name('show-mataa');
    Route::post('/edit_data_mata/{id}', [DataBerkasController::class, 'update_mata'])->name('edit_data_mata');  
    Route::post('/check-mata/{id}', [DataBerkasController::class, 'update_stt_mata'])->name('check_mata');
    Route::post('/delete_mata/{id}', [DataBerkasController::class, 'destroy_mata'])->name('delete_mata');   
    //Jabatan
    Route::post('/create_jbt/{id}', [DataBerkasController::class, 'create_jbt'])->name('create_jbt');
    Route::get('/show-jbt/{id}', [DataBerkasController::class, 'show_jbt'])->name('show-jbt');
    Route::get('/show-jbtt/{id}', [DataBerkasController::class, 'show_jbtt'])->name('show-jbtt');
    Route::post('/edit_data_jbt/{id}', [DataBerkasController::class, 'update_jbt'])->name('edit_data_jbt');  
    Route::post('/check-jbt/{id}', [DataBerkasController::class, 'update_stt_jbt'])->name('check_jbt');
    Route::post('/delete_jbt/{id}', [DataBerkasController::class, 'destroy_jbt'])->name('delete_jbt');  

    //Request
    Route::get('requests', [RequestAdmController::class, 'request'])->name('requests');
    Route::post('/create_requests', [RequestAdmController::class, 'create'])->name('create_requests');
    Route::post('/check-requests/{id}', [RequestAdmController::class, 'update'])->name('check_requests');
    Route::get('/view-pdf-requests/{id}', [RequestAdmController::class, 'view'])->name('view_pdf_requests');
    Route::post('/delete_req/{id}', [RequestAdmController::class, 'destroy'])->name('delete_req');     

    //Profil Admin
    Route::get('edit_profill', [AdminController::class, 'editProfil'])->name('edit_profill');
    Route::post('/update_profil_admin/{user}', [AdminController::class, 'update'])->name('update_profil_admin');
    Route::post('/update-fotoo', [AdminController::class, 'updateFoto'])->name('update_fotoo');

});

Route::middleware('isDosen')->group(function () {
    //Profil Dosen
    Route::get('edit_profil', [DosenController::class, 'editProfil'])->name('edit_profil');
    Route::post('/update_profil/{user}', [DosenController::class, 'update'])->name('update_profil');
    Route::post('/update-foto', [DosenController::class, 'updateFoto'])->name('update_foto');
    //File Serkom
    Route::get('serkom', [SerkomController::class, 'serkom'])->name('serkom');
    Route::post('/create_serkom', [SerkomController::class, 'create'])->name('create_serkom');
    Route::get('/view-pdf-serkom/{id}', [SerkomController::class, 'view'])->name('view_pdf_serkom');
    Route::get('/download-pdf-serkom/{id}', [SerkomController::class, 'download'])->name('download_pdf_serkom');
    //File Ijazah
    Route::get('ijazah', [IjazahController::class, 'ijazah'])->name('ijazah');
    Route::post('/create_ijazah', [IjazahController::class, 'create'])->name('create_ijazah');
    Route::get('/view-pdf-ijazah/{id}', [IjazahController::class, 'view'])->name('view_pdf_ijazah');
    Route::get('/download-pdf-ijazah/{id}', [IjazahController::class, 'download'])->name('download_pdf_ijazah');
    //File Data Ajar
    Route::get('matkul', [DataAjarController::class, 'dataAjar'])->name('dataAjar');
    Route::post('/create_dataAjar', [DataAjarController::class, 'create'])->name('create_dataAjar');
    Route::get('/view-pdf-dataAjar/{id}', [DataAjarController::class, 'view'])->name('view_pdf_dataAjar');
    Route::get('/download-pdf-dataAjar/{id}', [DataAjarController::class, 'download'])->name('download_pdf_dataAjar');
    //File Jabatan
    Route::get('jabatan', [JabatanController::class, 'jabatan'])->name('jabatan');
    Route::post('/create_jabatan', [JabatanController::class, 'create'])->name('create_jabatan');
    Route::get('/view-pdf-jabatan/{id}', [JabatanController::class, 'view'])->name('view_pdf_jabatan');
    Route::get('/download-pdf-jabatan/{id}', [JabatanController::class, 'download'])->name('download_pdf_jabatan');
    //File Request
    Route::get('request', [RequestController::class, 'request'])->name('request');
    Route::post('/create_request', [RequestController::class, 'create'])->name('create_request');
    Route::get('/view-pdf-request/{id}', [RequestController::class, 'view'])->name('view_pdf_request');
    Route::post('/hapus/{id}', [RequestController::class, 'hapus'])->name('hapus');     

});
