<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/qr', function (){
    $content = shell_exec('/usr/local/bin/pdftotext '.'/storage/journals/2015.pdf'.' -');
    return $content;
    return asset('storage/journals/2015.pdf');
    $contents = Storage::get('journals/2015.pdf');
    // echo QrCode::generate('Make me into a QrCode!');
});
