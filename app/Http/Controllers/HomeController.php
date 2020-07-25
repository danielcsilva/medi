<?php

namespace App\Http\Controllers;

use App\Charts\AccessionsCharts;
use App\Dashboard;
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
        // $chart = new AccessionsCharts;
        // $chart->labels(['2 dias atrás', 'Ontem', 'Hoje']);
        // $chart->dataset('Adesões', 'line', [10, 20, 30])->options([
        //     'color' => '#FF0000',
        //     'backgroundColor' => '#FFCC00'
        // ]);

        // $chart2 = new AccessionsCharts;
        // $chart2->labels(['2 dias atrás', 'Ontem', 'Hoje']);
        // $chart2->dataset('Entrevistas', 'line', [30, 60, 20])->options([
        //     'color' => '#FF0000',
        //     'backgroundColor' => '#FFCC99'
        // ]);

        $defaultDash = '';
        $dashs = $this->resolvePowerBIDashboard();
        foreach($dashs as $dash) {
            if ($dash['type'] == 'user') {
                $defaultDash = $dash['url'];
            }
        }

        return view('home', ['powerbi_urls' => $this->resolvePowerBIDashboard(), 'powerbi_url_iframe' => $defaultDash]);
    }

    public function loadDashboard($id)
    {

        $dash = Dashboard::findOrFail($id);
        
        return view('home', ['powerbi_urls' => $this->resolvePowerBIDashboard(), 'powerbi_url_iframe' => $dash->dashboard_link]);

    }

    public function resolvePowerBIDashboard()
    {
        $powerbi_urls = [];
        
        if (Auth::user()->powerbi_url) {
            $powerbi_urls[] = ['url' => Auth::user()->powerbi_url, 'type' => 'user'];
        }

        if (Auth::user()->company_id) {
            $dashs = Dashboard::where('active', true)->where('company_id', Auth::user()->company_id)->get();
            foreach($dashs as $dash) {
                $powerbi_urls[] = ['label' => $dash->label, 'id' => $dash->id, 'type' => 'company'];
            }
        }
        
        return $powerbi_urls;
    }
}
