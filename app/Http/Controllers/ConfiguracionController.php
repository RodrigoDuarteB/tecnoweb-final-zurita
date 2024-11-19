<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConfiguracionController extends Controller
{

    public function index() {
        return Inertia::render('Configuracion');
    }

    public function store(Request $request) {
        Session::put('tema', $request->tema);
    }
}
