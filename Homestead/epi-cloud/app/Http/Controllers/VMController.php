<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vm;
use ClassPreloader\Config;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
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
        $vms = Vm::all();
//        $client = new Client(['http_errors' => false]);
//        $res = $client->request(
//            'GET', 'https://epi-cloud-vm-service.herokuapp.com/api/v1' . '/boxes', []);
//        if ($res->getStatusCode() == 503)
//            return view('serverout');
//        // "200"
//        echo $res->getHeader('content-type');
//        echo $res->getBody();

        return view('vm.index')->with('vms', $vms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client(['http_errors' => false]);
        $res = $client->request(
            'POST', Config::get('urls.VM_SERVER') . '/boxes', [
            'form_params' => [
                "os" => "ubuntu",
                "os_version" => "trusty64",
                "nb_core" => 1,
                "ram" => 512,
                "name" => "test_vm_name",
            ]
        ]);
        echo $res->getStatusCode();
        // "200"
        echo $res->getHeader('content-type');
        // 'application/json; charset=utf8'
        echo $res->getBody();
        // {"type":"User"...'
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
     * store the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Redirect
     */
    public function store(Request $request, $id)
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
            Vm::find($id)->update($request->all());

            return redirect($this->prefix."/$id");
        }
    }

    /**
     * delete the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return redirect($this->prefix);
    }
}
