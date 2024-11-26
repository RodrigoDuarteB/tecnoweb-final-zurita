<?php

namespace App\Http\Controllers;

use App\Models\Politica;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PoliticaController extends Controller
{
    
    public function index()
    {
        $items = Politica::activos()->get();
        return Inertia::render('Politica/Index', compact('items'));
    }

 
    public function create()
    {
        return Inertia::render('Politica/Create');
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            
        ]);

        Politica::create([
            ...$validated,
            'usuario_id' => Auth::user()->id
        ]);
        return redirect()->route('politica.index')->with('success', 'Política creada con éxito.');
    }

   
    public function show(Politica $politica)
    {
        $politica->load (['usuario']);
        $esVer=true;
        return Inertia::render('Politica/Create', compact('politica','esVer'));
    }

    
    public function edit(Politica $politica)
    {
        $usuarios = User::all();
        return Inertia::render('Politica/Create', compact('politica'));
    }

 
    public function update(Request $request, Politica $politica)
    {
    
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            
        ]);

        $politica->update($validated);
        return redirect()->route('politica.index')->with('success', 'Política actualizada con éxito.');
    }

   
    public function destroy(Politica $politica)
    {
        
    try {
        $politica->estado = 'Inactivo';  // O usa 'false', dependiendo de cómo manejes el estado
        $politica->save();  // Guardamos el modelo con el nuevo estado

        
        session()->flash('jetstream.flash', [
            'banner' => 'Política desactivada correctamente!',
            'bannerStyle' => 'success'
        ]);

        // Redirigir a la lista de políticas
        return redirect()->route('politica.index');
    } catch (Exception $e) {
        // Si algo falla, mostramos el mensaje de error
        session()->flash('jetstream.flash', [
            'banner' => 'Hubo un error al desactivar la política!',
            'bannerStyle' => 'error'
        ]);
        
        // Redirigir con el error
        return redirect()->route('politica.index')->with('error', 'Hubo un error al desactivar la política: '. $e->getMessage());
    }
        
    }
}
