<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vm;
use ClassPreloader\Config;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VMController extends Controller
{

    private $prefix = "vms";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('SysAdmin')) {
            $vms = Vm::all();
        }
        else if ($user->hasRole('Employees')) {
            $vms = Vm::all()->where('user_id', "=", $user->id);
        }
        else {
            $vms = Vm::all()->where('user_id', "=", $user->id);
        }

        return view('vm.index')->with('vms', $vms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view("vm.create");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $vm = Vm::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return redirect('vms');
        }

        return view('vm.show')->with('vm', $vm);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $vm = Vm::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return redirect($this->prefix);
        }

        return view("vm.edit")->with("vm", $vm);
    }

    /**
     * update
     *
     * @param Request $request
     * @param  int $id
     * @return Redirect
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'name'             => 'required|max:100',
        );

        $validator = Validator::make($request->all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {

            $messages = $validator->messages();

            return Redirect::to($this->prefix."/$id/edit")
                ->withErrors($validator);

        } else {
            //TODO send update request
//            Vm::find($id)->update($request->all());

            return redirect($this->prefix."/$id");
        }
    }

    /**
     * store the specified resource in storage.
     *
     * @param Request $request
     * @return Redirect
     */
    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required|max:100',
        );

        $validator = Validator::make($request->all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {

            $messages = $validator->messages();

            //TODO redirect back
            return Redirect::to($this->prefix."/create")->withErrors($validator);
        } else {
            //TODO send create request
//            Vm::find($id)->update($request->all());

            return redirect($this->prefix);
        }
    }

    /**
     * delete the specified resource in storage.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function delete($id)
    {
        try {
            $vm = Vm::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return redirect($this->prefix);
        }

        //TODO send delete request
        return redirect($this->prefix);
    }
}
