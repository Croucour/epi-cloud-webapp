<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vm;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $vms = Vm::getByRole();

        return view('dashboard')->with('nb_vms', $vms->count());
    }
}
