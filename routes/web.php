<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PengajuanIzinController;
use App\Http\Controllers\PengajuanKronologiController;
use App\Http\Controllers\PengajuanPinjamanController;
use App\Http\Controllers\PengajuanDispensasiController;
use App\Http\Controllers\SlipGajiController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'view'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:admin,kepala'])->group(function () {
    Route::get('/staff', [StaffController::class, 'view'])->name('staff.view');
    Route::get('/staff/addView', [StaffController::class, 'addView'])->name('staff.addView');
    Route::post('/staff/add', [StaffController::class, 'add'])->name('staff.add');
    Route::get('/staff/editView/{id}', [StaffController::class, 'editView'])->name('staff.editView');
    Route::patch('/staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');

    Route::get('/pengajuan/izin', [PengajuanIzinController::class, 'view'])->name('pengajuanizin.view');
    Route::post('/pengajuan/izin/validasi/{id}', [PengajuanIzinController::class, 'validasi'])->name('pengajuanizin.validasi');
    Route::get('/pengajuan/kronologi', [PengajuanKronologiController::class, 'view'])->name('kronologi.view');
    Route::post('/pengajuan/kronologi/validasi/{id}', [PengajuanKronologiController::class, 'validasi'])->name('kronologi.validasi');
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/staff/userForm/{id}', [StaffController::class, 'userForm'])->name('staff.userForm');
    Route::post('/staff/saveUser/{id}', [StaffController::class, 'saveUser'])->name('staff.saveUser');

    Route::get('/cabang', [CabangController::class, 'view'])->name('cabang.view');
    Route::get('/cabang/addView', [CabangController::class, 'addView'])->name('cabang.addView');
    Route::post('/cabang/add', [CabangController::class, 'add'])->name('cabang.add');
    Route::get('/cabang/editView/{id}', [CabangController::class, 'editView'])->name('cabang.editView');
    Route::patch('/cabang/edit/{id}', [CabangController::class, 'edit'])->name('cabang.edit');

    Route::get('/jabatan', [JabatanController::class, 'view'])->name('jabatan.view');
    Route::get('/jabatan/addView', [JabatanController::class, 'addView'])->name('jabatan.addView');
    Route::post('/jabatan/add', [JabatanController::class, 'add'])->name('jabatan.add');
    Route::get('/jabatan/editView/{id}', [JabatanController::class, 'editView'])->name('jabatan.editView');
    Route::patch('/jabatan/edit/{id}', [JabatanController::class, 'edit'])->name('jabatan.edit');

    Route::get('/pengajuan/dispensasi', [PengajuanDispensasiController::class, 'view'])->name('pengajuandispensasi.view');
    Route::resource('hutang', HutangController::class);

    // Route::get('/slip', [SlipGajiController::class, 'index'])->name('slip.index'); // daftar hasil penggajian
    // Route::get('/slip/preview', [SlipGajiController::class, 'preview'])->name('slip.preview'); // form pilih bulan & cabang
    // Route::post('/slip/jalankan', [SlipGajiController::class, 'jalankan'])->name('slip.jalankan'); // simpan ke db
    // Route::get('/slip/{periode}/{cabang_id}', [SlipGajiController::class, 'detail'])->name('slip.periode.detail'); // lihat slip tiap periode
});

Route::middleware(['auth', 'role:admin,kepala,karyawan'])->group(function () {
    Route::get('/pengajuan/izin/addView', [PengajuanIzinController::class, 'addView'])->name('pengajuanizin.addView');
    Route::post('/pengajuan/izin/add', [PengajuanIzinController::class, 'add'])->name('pengajuanizin.add');
    Route::get('/pengajuan/izin/riwayat', [PengajuanIzinController::class, 'riwayat'])->middleware(['auth'])->name('pengajuanizin.riwayat');
    Route::get('/pengajuan/izin/{id}', [PengajuanIzinController::class, 'detail'])->name('pengajuanizin.detail');
    Route::post('/pengajuan/izin/validasi/{id}', [PengajuanIzinController::class, 'validasi'])->name('pengajuanizin.validasi');

    // Pengajuan Dispensasi (karyawan bisa ajukan, admin/kepala bisa validasi)
    Route::get('/pengajuan/dispensasi/addView', [PengajuanDispensasiController::class, 'addView'])->name('pengajuandispensasi.addView');
    Route::post('/pengajuan/dispensasi/add', [PengajuanDispensasiController::class, 'add'])->name('pengajuandispensasi.add');
    Route::get('/pengajuan/dispensasi/riwayat', [PengajuanDispensasiController::class, 'riwayat'])->middleware(['auth'])->name('pengajuandispensasi.riwayat');
    Route::get('/pengajuan/dispensasi/{id}', [PengajuanDispensasiController::class, 'detail'])->name('pengajuandispensasi.detail');
    Route::post('/pengajuan/dispensasi/validasi/{id}', [PengajuanDispensasiController::class, 'validasi'])->name('pengajuandispensasi.validasi');


    Route::get('/pengajuan/kronologi/addView', [PengajuanKronologiController::class, 'addView'])->name('kronologi.addView');
    Route::post('/pengajuan/kronologi/add', [PengajuanKronologiController::class, 'add'])->name('kronologi.add');
    Route::get('/pengajuan/kronologi/riwayat', [PengajuanKronologiController::class, 'riwayat'])->name('kronologi.riwayat');
    Route::get('/pengajuan/kronologi/{id}', [PengajuanKronologiController::class, 'detail'])->name('kronologi.detail');
});

Route::middleware('auth')->group(function () {
    Route::get('/pengajuan/pinjaman', [PengajuanPinjamanController::class, 'view'])->name('pinjaman.view');
    Route::get('/pengajuan/pinjaman/addView', [PengajuanPinjamanController::class, 'addView'])->name('pinjaman.addView');
    Route::get('/pengajuan/pinjaman/riwayat', [PengajuanPinjamanController::class, 'riwayat'])->name('pinjaman.riwayat');
    Route::post('/pengajuan/pinjaman/add', [PengajuanPinjamanController::class, 'add'])->name('pinjaman.add');
    Route::post('/pengajuan/pinjaman/{id}/validasi', [PengajuanPinjamanController::class, 'validasi'])->name('pinjaman.validasi');
    Route::get('/pengajuan/pinjaman/{id}', [PengajuanPinjamanController::class, 'detail'])->name('pinjaman.detail');

    Route::get('/slip', [SlipGajiController::class, 'view'])->name('slip.view');
    Route::get('/slip/proses', [SlipGajiController::class, 'proses'])->name('slip.proses');
    Route::get('/slip/riwayat', [SlipGajiController::class, 'riwayat'])->name('slip.riwayat');
    Route::get('/slip/karyawan/riwayat', [SlipGajiController::class, 'riwayatGajiKaryawan'])->name('slip.karyawan.riwayat');
    Route::get('/slip/karyawan/{id}', [SlipGajiController::class, 'detailGajiKaryawan'])->name('slip.karyawan.detail');
    Route::get('/slip/riwayat/pdf', [SlipGajiController::class, 'exportPdf'])->name('slip.riwayat.pdf');
    Route::get('/slip/karyawan/riwayat/pdf/{id}', [SlipGajiController::class, 'exportPdfKaryawanBulan'])->name('slip.riwayat.karyawan.pdf');

    Route::get('/resetpass', [DashboardController::class, 'showResetForm'])->name('reset.pw');
    Route::post('/resetpass', [DashboardController::class, 'updatePassword'])->name('reset.pass');
});

Route::prefix('absen')->middleware('auth')->group(function () {
    Route::get('/', [AbsenController::class, 'index'])->name('absen.index');
    Route::get('/import', [AbsenController::class, 'importForm'])->name('absen.import.form');
    Route::post('/import', [AbsenController::class, 'importProses'])->name('absen.import.proses');
});
Route::get('/absen/riwayat', [AbsenController::class, 'riwayat'])->name('absen.riwayat')->middleware('auth');

require __DIR__ . '/auth.php';
