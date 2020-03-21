<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuggestionStore;
use App\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('suggestions.list', ['model' => '\App\\Suggestion']);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suggestions.new');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuggestionStore $request)
    {
        $validationData = $request->validated();
        
        Suggestion::create($validationData);

        return redirect()->route('suggestions.index')->with('success', 'Sugestão adicionada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function show(Suggestion $suggestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function edit($suggestion)
    {
        return view('suggestions.edit', ['suggestion' => Suggestion::findOrFail($suggestion)]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function update(SuggestionStore $request, $suggestion)
    {
        $suggestionModel = Suggestion::findOrFail($suggestion);
        $validationData = $request->validated();        
        
        $suggestionModel->fill($validationData);
        $suggestionModel->save();

        return redirect()->route('suggestions.index')->with('success', 'Sugestão editada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function destroy($suggestion)
    {
        try {
            
            $suggestionModel = Suggestion::findOrFail($suggestion);
            $suggestionModel->delete();

        } catch (\Illuminate\Database\QueryException $e) {
                
            return redirect()->route('suggestions.index')->with('error', config('medi.constraint_error'));

        }

        return redirect()->route('suggestions.index')->with('success', 'Sugestão excluída com sucesso!');
    }
}
