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

    public function architecture()
    {
        return view('docs.architecture');
    }

    public function troubleshooting()
    {
        return view('docs.troubleshooting');
    }

    public function export()
    {
        return view('docs.export');
    }

    public function faq()
    {
        return view('docs.faq');
    }

    public function usage()
    {
        return view('docs.usage');
    }
}
