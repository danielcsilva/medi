<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\UserStore;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.list', ['model' => '\App\\User']);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.new', ['roles' => Role::where('name', '<>', 'SuperAdmin')->get(), 'companies' => Company::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {
        $roles = $request->get('roles');
        $validationData = $request->validated();
        
        if (isset($validationData['password']) && $validationData['password'] != '') {
            $validationData['password'] = Hash::make($validationData['password']);
        }

        $user = User::create($validationData);

        if (Auth::user()->can('Editar Usuários')) {
            $user->assignRole($roles);
        }

        return redirect()->route('users.index')->with('success', 'Usuário adicionado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        return view('users.edit', ['user' => User::findOrFail($user), 'roles' => Role::where('name', '<>', 'SuperAdmin')->get(), 'companies' => Company::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserStore $request, $user)
    {
        $userModel = User::findOrFail($user);
        $roles = $request->get('roles');
        
        $validationData = $request->validated();        

        if (isset($validationData['password']) && $validationData['password'] != '') {
            $validationData['password'] = Hash::make($validationData['password']);
        } else {
            unset($validationData['password']);
            unset($validationData['password_confirmation']);
        }

        $userModel->fill($validationData);
        $userModel->save();

        if (Auth::user()->can('Editar Usuários')) {
            $userModel->assignRole($roles);
        }

        return redirect()->route('users.index')->with('success', 'Usuário editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        try {
            
            $userModel = user::findOrFail($user);
            $userModel->delete();

        } catch (\Illuminate\Database\QueryException $e) {
                
            return redirect()->route('users.index')->with('error', config('medi.constraint_error'));

        }    

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    
    }
}
