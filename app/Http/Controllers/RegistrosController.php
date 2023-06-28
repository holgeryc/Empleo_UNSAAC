<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Dompdf\Dompdf;
use App\Models\Registro;

class RegistrosController extends Controller
{
    public function index()
    {
        if (Auth::user()->Tipo=== 'Administrador' || Auth::user()->Tipo=== 'Contador' || Auth::user()->Tipo=== 'Controlador') {
            return view('livewire.registros.index');
        }
        else{
            return redirect()->route('home');
        }
    }
}
