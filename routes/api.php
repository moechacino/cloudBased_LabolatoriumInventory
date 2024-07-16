<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\AlatLabController;
use App\Http\Controllers\api\AlatTerpinjamController;
use App\Http\Controllers\api\DosenController;
use App\Http\Controllers\api\MahasiswaController;
use App\Http\Controllers\api\PeminjamanDosenController;
use App\Http\Controllers\api\PeminjamanMahasiswaController;
use App\Http\Middleware\OnlyAdmin;
use App\Http\Middleware\VerifyJWT;

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminController::class, 'login']);
    Route::get('/logout', [AdminController::class, 'logout'])->middleware([VerifyJWT::class, OnlyAdmin::class]);
});

Route::prefix('alat-lab')->group(function () {
    Route::get('/', [AlatLabController::class, 'getAll']);
    Route::get('/{rfid_uid}', [AlatLabController::class, 'getOneByRfid']);
    Route::get('/{id}', [AlatLabController::class, 'getOne'])->where('id','[0-9]+');
    Route::middleware([VerifyJWT::class, OnlyAdmin::class])->group(function () {
        Route::post('/create', [AlatLabController::class, 'create']);
        Route::delete('/{id}/delete', [AlatLabController::class, 'delete'])->where('id','[0-9]+');
        Route::put('/{id}/edit', [AlatLabController::class, 'edit'])->where('id','[0-9]+');
    });
});

Route::prefix('mahasiswa')->group(function (){
   Route::get('/', [MahasiswaController::class , "getAll"]) ;
   Route::get('/scanRfid/{rfid_uid}', [MahasiswaController::class , "getOneByRfid"]) ;
   Route::middleware([VerifyJWT::class, OnlyAdmin::class])->group(function (){
       Route::post("/create" , [MahasiswaController::class, "create"]);
       Route::get('/{id}', [MahasiswaController::class, 'getOneById'])->where('id','[0-9]+');
       Route::delete("/{id}/delete" , [MahasiswaController::class, "delete"])->where('id','[0-9]+');
       Route::put("/{id}/edit" , [MahasiswaController::class, "edit"])->where('id','[0-9]+');
   });
});

Route::prefix('dosen')->group(function (){
    Route::get('/', [DosenController::class, 'getAll']);
    Route::get('/scanRfid/{rfid_uid}' , [DosenController::class, "getOneByRfid"]);
    Route::middleware([VerifyJWT::class, OnlyAdmin::class])->group(function (){
        Route::post("/create" , [DosenController::class, "create"]);
        Route::get('/{id}', [DosenController::class, "getOneById"])->where('id','[0-9]+');
        Route::delete("/{id}/delete" , [DosenController::class, "delete"])->where('id','[0-9]+');
        Route::put("/{id}/edit" , [DosenController::class, "edit"])->where('id','[0-9]+');
    });
});

Route::prefix('peminjaman')->group(function (){
    Route::prefix('mahasiswa')->group(function (){
        Route::post('/create', [PeminjamanMahasiswaController::class, 'create']);
        Route::middleware([VerifyJWT::class, OnlyAdmin::class])->group(function (){
            Route::get("/", [PeminjamanMahasiswaController::class, 'getAll']);
            Route::get('/{id}', [PeminjamanMahasiswaController::class, 'getOne'])->where('id','[0-9]+');
            Route::patch('/{id}/accept', [PeminjamanMahasiswaController::class, 'accept'])->where('id','[0-9]+');
            Route::patch('/{id}/reject', [PeminjamanMahasiswaController::class, 'reject'])->where('id','[0-9]+');
            Route::delete('/{id}/delete', [PeminjamanMahasiswaController::class, 'delete'])->where('id','[0-9]+');
            Route::patch('/{id}/pengembalian', [PeminjamanMahasiswaController::class, "pengembalian"])->where('id','[0-9]+');
        });
    });

    Route::prefix('dosen')->group(function (){
        Route::post('/create', [PeminjamanDosenController::class, 'create']);
        Route::middleware([VerifyJWT::class, OnlyAdmin::class])->group(function (){
            Route::get("/", [PeminjamanDosenController::class, 'getAll']);
            Route::get('/{id}', [PeminjamanDosenController::class, 'getOne'])->where('id','[0-9]+');
            Route::delete('/{id}/delete', [PeminjamanDosenController::class, 'delete'])->where('id','[0-9]+');
            Route::patch('/{id}/pengembalian', [PeminjamanDosenController::class, "pengembalian"])->where('id','[0-9]+');
        });
    });
});

Route::prefix('alat-terpinjam')->group(function (){
    Route::middleware([VerifyJWT::class, OnlyAdmin::class])->group(function (){
    Route::get('/', [AlatTerpinjamController::class, "getAll"]);
    Route::get('/{id}', [AlatTerpinjamController::class, "getOne"]);
    });
});
