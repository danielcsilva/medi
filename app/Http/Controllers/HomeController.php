<?php

namespace App\Http\Controllers;

use App\Charts\AccessionsCharts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $chart2 = new AccessionsCharts;
        $chart2->labels(['2 dias atrás', 'Ontem', 'Hoje']);
        $chart2->dataset('Entrevistas', 'line', [30, 60, 20])->options([
            'color' => '#FF0000',
            'backgroundColor' => '#FFCC99'
        ]);

        return view('home', ['chart' => $chart, 'chart2' => $chart2, 'powerbi_url' => $this->resolvePowerBIDashboard()]);
    }

    public function resolvePowerBIDashboard()
    {
        $powerbi_url = Auth::user()->powerbi_url;
        $html = "";
        $file = 'dashboard_' . Auth::user()->id . '.html';
        $url = "";

        if ($powerbi_url != '') {
            ///$html = file_get_contents($powerbi_url); 
            //Storage::disk('public')->put($file, $html);
            //$url = Storage::url($file);
        }

        return $powerbi_url;
    }
}
