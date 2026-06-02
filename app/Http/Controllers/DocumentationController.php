<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function index()
    {
        return view('docs.index');
    }

    public function algorithm()
    {
        return view('docs.algorithm');
    }

    public function usage()
    {
        return view('docs.usage');
    }
}
