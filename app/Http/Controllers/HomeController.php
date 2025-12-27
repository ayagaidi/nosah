<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

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

        // Fetch statistics data
        $doctorsCount = doctor::count();
        $clinicsCount = Clinic::count();
        $patientsCount = \App\Models\Patient::count();

        return view('home')->with('doctorsCount', $doctorsCount)
            ->with('clinicsCount', $clinicsCount)
            ->with('patientsCount', $patientsCount);
    }

}
