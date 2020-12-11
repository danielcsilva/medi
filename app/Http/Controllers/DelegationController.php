<?php

namespace App\Http\Controllers;

use App\Accession;
use App\Delegation;
use App\User;
use Illuminate\Http\Request;

class DelegationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('delegation.list', [
            'users' => $users,
            'model' => Accession::class, 
            'filter' => ['analysis_status' => false],
            'editRoute' => 'accessions',
            'filterField' => [],
            'routeParam' => 'accession',
            'users' => User::all()->except(['id' => 1]),
            'actions' => ['Contato', 'Entrevista', 'Revisão']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $user = $request->get('user');
        $actions = $request->get('actions'); //array
        $items = explode(",", $request->get('selected_items')); //array
        
        foreach($items as $item) {
            Delegation::firstOrCreate([
                'user_id' => $user,
                'action' => implode(',', $actions),
                'accession_id' => $item
            ],
            [
                'user_id' => $user,
                'action' => implode(',', $actions),
                'accession_id' => $item
            ]);
        }

        return redirect()->route('delegation.index', ['items' => $request->get('selected_items')])->with('success', 'Processos delegados!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
