<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserPost;
use App\Http\Requests\UpdateUserPut;
use App\Models\Rol;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;


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
            $password = 'gobernacion123';//Str::random(12);
            //sendEmail($password);
            User::create([
                ...$request->all(),
                'password' => Hash::make($password)
            ]);
            DB::commit();
            session()->flash('jetstream.flash', [
                'banner' => 'Usuario creado corretamente!',
                'bannerStyle' => 'success'
            ]);
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
        $roles = Rol::activos()->get();
        return Inertia::render('User/Create',compact('user', 'esVer', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $esEdit = true;
        return Inertia::render('User/Create',compact('user', 'esEdit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserPut $request, User $user)
    {
        //dd($request->all());
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $datos = [
                'name' => $request->name,
                'email' => $request->email
            ];
            if(!empty($request->password)) {
                $datos['password'] = Hash::make($request->password);
            }
            $user->update($datos);
            DB::commit();
            $emailChanged = $user->email !== $request->email;
            $passwordChanged = !empty($request->password);
            if ($emailChanged || $passwordChanged) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('message', 'Your email or password has been updated. Please log in again.');
            }
            session()->flash('jetstream.flash', [
                'banner' => 'Tu usuario fue modificado corretamente!',
                'bannerStyle' => 'success'
            ]);
            return redirect()->route('dashboard');
        } catch(Exception $e) {
            DB::rollBack();
            return redirect()->route('user.index')
                ->with('error', 'Hubo un error al guardar el rol: '. $e->getMessage());
        }
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
