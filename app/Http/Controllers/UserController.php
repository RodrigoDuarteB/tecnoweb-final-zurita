<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserPost;
use App\Http\Requests\UpdateUserPut;
use App\Models\Rol;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

use Str;
use function Laravel\Prompts\password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = User::with('rol:id,nombre', 'cliente:id,usuario_id,carnet_identidad')->get();
        return Inertia::render('User/Index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Rol::activos()
        ->where('listable', true)
        ->get();
        return Inertia::render('User/Create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserPost $request)
    {
        DB::beginTransaction();
        try {
            $password = Str::random(12);
            //sendEmail($password);
            User::create([
                ...$request->all(),
                'password' => Hash::make($password)
            ]);
            DB::commit();
            return redirect()->route('user.index');
        } catch(Exception $e) {
            DB::rollBack();
            return redirect()->route('user.index')
                ->with('error', 'Hubo un error al guardar el rol: '. $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['rol:id,nombre', 'cliente:id,usuario_id,carnet_identidad']);
        $esVer = true;
        $roles = Rol::activos()
        ->where('listable', true)
        ->get();
        return Inertia::render('User/Create',compact('user', 'esVer', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render('User/Edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserPut $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index');
    }
}
