<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultaApiController extends Controller
{
    public function index()
    {
        return view('consultaApi.index');
    }
}
