<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokumentasiController extends Controller
{
    public function index()
    {
        return view('dokumentasi.index');
    }

    public function algoritma()
    {
        return view('dokumentasi.algoritma');
    }

    public function arsitektur()
    {
        return view('dokumentasi.arsitektur');
    }

    public function pemecahanMasalah()
    {
        return view('dokumentasi.pemecahan_masalah');
    }

    public function ekspor()
    {
        return view('dokumentasi.ekspor');
    }

    public function faq()
    {
        return view('dokumentasi.faq');
    }

    public function penggunaan()
    {
        return view('dokumentasi.penggunaan');
    }
}
