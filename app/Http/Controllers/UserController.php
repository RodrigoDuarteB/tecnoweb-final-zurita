<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserPost;
use App\Http\Requests\UpdateUserPut;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = User::with('rol:id,nombre', 'cliente:id,carnet_identidad')->get();
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
        //dd($request->validated());
        user::create($request->validated());
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Inertia::render('User/Show',compact('user'));
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
