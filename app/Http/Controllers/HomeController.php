<?php

namespace App\Http\Controllers;

use App\Sponsor;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sponsors = Sponsor::all();
        return view('home')->with(['sponsors' => $sponsors]);
    }
}
