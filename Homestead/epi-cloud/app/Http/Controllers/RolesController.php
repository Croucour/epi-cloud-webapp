<?php

namespace App\Http\Controllers;

use App\Models\Boxes_waiting;
use App\Models\Role;
use App\Models\User;
use App\Models\Boxes;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    protected $prefix = "roles/";

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
        $users = User::all()->except(1);
        $roles = Role::pluck('name', 'id');

        return view("roles.index")->with("users", $users)->with("roles", $roles);
    }
}
