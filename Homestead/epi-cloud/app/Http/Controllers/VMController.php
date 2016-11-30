<?php

namespace App\Http\Controllers;

use App\Models\Role;
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
use Ixudra\Curl\Facades\Curl;
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

            $studentVms =  Vm::getByRole("Student");
            if ($studentVms != null) {
                $vms->merge($studentVms);
            }
        }
        else {
            $vms = Vm::all()->where('user_id', "=", $user->id);
        }

        return view('vm.index')->with('vms', $studentVms);
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
            'name' => 'required|max:100',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->messages();

            return redirect($this->prefix."/$id/edit")
                ->withErrors($validator);

        } else {
//            $params = $request->except('_token');
//            $client = new Client(['http_errors' => false]);
//            $res = $client->request(
//                'PUT', "https://epi-cloud-vm-service.herokuapp.com/api/v1" . '/boxes/' . $id, [
//                'form_params' => $params
//            ]);
//            echo $res->getStatusCode();
//            if ($res->getStatusCode() != 200)
//            {
//                if ($res->getStatusCode() == 503){
//                    $e_msg = 'Service Unavailable';
//                }
//                elseif ($res->getStatusCode() == 404){
//                    $e_msg = 'Impossible to find this machine, it might be deleted or deplaced';
//                }
//                else{
//                    $e_msg = "ERROR : " . $res->getStatusCode();
//                }
//                $request->session()->flash('alert-danger', $e_msg);
//                return redirect($this->prefix."/$id/edit");
//            }

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

            return redirect($this->prefix."/create")
                ->withErrors($validator)
                ->withInput();
        } else {
            $response = Curl::to(getenv('URL_API_FACTORY')."/boxes")
                ->withData($request->all())
                ->asJson()
                ->returnResponseObject()
                ->post();

            var_dump($response);
            die;

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

    /**
     *
     * @param  int  $id
     * @return Redirect
     */
    public function start($id)
    {
        try {
            $vm = Vm::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return redirect($this->prefix);
        }

        $response = Curl::to(getenv('URL_API_FACTORY')."/$id/start")
            ->returnResponseObject()
            ->put();
        return redirect($this->prefix);
    }

    /**
     *
     * @param  int  $id
     * @return Redirect
     */
    public function stop($id)
    {
        try {
            $vm = Vm::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return redirect($this->prefix);
        }

        $response = Curl::to(getenv('URL_API_FACTORY')."/$id/stop")
            ->returnResponseObject()
            ->put();
        return redirect($this->prefix);
    }
}
