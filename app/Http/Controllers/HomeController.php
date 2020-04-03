<?php

namespace App\Http\Controllers;

use App\Charts\AccessionsCharts;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $chart = new AccessionsCharts;
        $chart->labels(['2 dias atrás', 'Ontem', 'Hoje']);
        $chart->dataset('Adesões', 'line', [10, 20, 30])->options([
            'color' => '#FF0000',
            'backgroundColor' => '#FFCC00'
        ]);

        return view('home', ['chart' => $chart]);
    }
}
