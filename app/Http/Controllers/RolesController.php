<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStore;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Throwable;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles.list', ['model' => Role::class]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.new', ['permissions' => Permission::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStore $request)
    {
        $validationData = $request->validated();
        
        $role = Role::create($validationData);

        if (isset($validationData['permissions'])) {
            $role->syncPermissions($validationData['permissions']);
        }

        return redirect()->route('roles.index')->with('success', 'Grupo adicionado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        
        return view('roles.edit', ['role' => $role, 'permissions' => Permission::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function update(RoleStore $request, $id)
    {
        $role = Role::findOrFail($id);

        $validationData = $request->validated();        
        
        $role->name = $validationData['name'];
        $role->save();

        $role->syncPermissions($validationData['permissions']);

        return redirect()->route('roles.index')->with('success', 'Grupo editado com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $role = Role::findOrFail($id);
            $role->delete();

        } catch(Exception $e) {

            return back()->withInput()->with('error', config('medi.tech_error_msg') . $e->getMessage());


        } catch(Throwable $t) {

            return back()->withInput()->with('error', config('medi.tech_error_msg') . $t->getMessage());

        }

        return redirect()->route('roles.index')->with('success', 'Grupo excluído com sucesso!');

    }
}
