<?php

namespace App\Http\Controllers;

use App\Models\Boxes_waiting;
use App\Models\Role;
use App\Models\User;
use App\Models\Boxes;
use ClassPreloader\Config;
use Faker\Provider\Biased;
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
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class VMController extends Controller
{

    private $prefix = "vms";

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function jwtToken() {
        $user = Auth::user();

        $customClaims = ['user_id' => $user->id];

        $payload = JWTFactory::make($customClaims);

        return JWTAuth::encode($payload);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $boxes = Boxes::getByRole();
        $boxes_waiting = Boxes_waiting::getByRole();

        return view('vm.index')->with('vms', $boxes)->with("boxes_waiting", $boxes_waiting);
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
            $vm = Boxes::findOrFail($id);
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
            $vm = Boxes::findOrFail($id);
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
            $response = Curl::to(getenv('URL_API_FACTORY')."boxes")
                ->withData($request->except("_token"))
                ->asJson()
//                    ->withContentType('multipart/form-data')
                ->returnResponseObject()
//                    ->containsFile()
                ->withHeader("Authorization: Bearer ".$this->jwtToken())
                ->put();

            if ($response->satus != 200)
            {
                $message = $response->status != 200 ? $this->curlError($response->status) : "Box updated";
                $request->session()->flash($response->status != 200 ? 'alert-danger' : 'alert-success', $message);
                return redirect($this->prefix."/$id/edit");
            }

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
            $user = Auth::user();

            if ($user->hasRole('Students') || $user->hasRole('Student')) {
                $data = $request->except("_token");
                $data["user_id"] = $user->id;
                $data["status"] = "waiting";
                Boxes_waiting::create($data);
            }
            else {
                $response = Curl::to(getenv('URL_API_FACTORY')."boxes")
                    ->withData($request->except("_token"))
                    ->asJson()
//                    ->withContentType('multipart/form-data')
                    ->returnResponseObject()
//                    ->containsFile()
                    ->withHeader("Authorization: Bearer ".$this->jwtToken())
                    ->post();

                $message = $response->status != 201 ? $this->curlError($response->status) : "Box created";
                $request->session()->flash($response->status != 201 ? 'alert-danger' : 'alert-success', $message);

                try {
                    Boxes::findOrFail($response->content->id);
                    return redirect($this->prefix."/".$response->content->id);
                }
                catch (ModelNotFoundException $e) {
                    return redirect($this->prefix);
                }
            }

            return redirect($this->prefix);
        }
    }

    /**
     * delete the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Redirect
     */
    public function delete(Request $request, $id)
    {
        try {
            Boxes::findOrFail($id);


            $response = Curl::to(getenv('URL_API_FACTORY')."boxes/".$id)
                ->returnResponseObject()
                ->withHeader("Authorization: Bearer ".$this->jwtToken())
                ->delete();

            $message = $response->status != 200 ? $this->curlError($response->status) : "Box deleted";
            $request->session()->flash($response->status != 200 ? 'alert-danger' : 'alert-success', $message);

            var_dump($response);
            die;

        }
        catch (ModelNotFoundException $e) {
            return redirect($this->prefix);
        }
        return redirect($this->prefix);
    }

    /**
     *
     * @param Request $request
     * @param  int $id
     * @return Redirect
     */
    public function start(Request $request, $id)
    {
        try {
            $vm = Boxes::findOrFail($id);

            $response = Curl::to(getenv('URL_API_FACTORY')."$id/start")
                ->returnResponseObject()
                ->put();

            $message = $response->status != 200 ? $this->curlError($response->status) : "Box started";
            $request->session()->flash($response->status != 200 ? 'alert-danger' : 'alert-success', $message);

        }
        catch (ModelNotFoundException $e) {
            return redirect($this->prefix);
        }

        return redirect($this->prefix);
    }

    /**
     *
     * @param Request $request
     * @param  int $id
     * @return Redirect
     */
    public function stop(Request $request, $id)
    {
        try {
            $vm = Boxes::findOrFail($id);

            $response = Curl::to(getenv('URL_API_FACTORY')."$id/stop")
                ->returnResponseObject()
                ->put();

            $message = $response->status != 200 ? $this->curlError($response->status) : "Box stopped";
            $request->session()->flash($response->status != 200 ? 'alert-danger' : 'alert-success', $message);
        }
        catch (ModelNotFoundException $e) {
            return redirect($this->prefix);
        }

        return redirect($this->prefix);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|Redirect
     */
    public function waitingShow($id)
    {
        try {
            $box_waiting = Boxes_waiting::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return redirect('vms');
        }

        return view('vm.waitingShow')->with('box_waiting', $box_waiting);
    }

    /**
     * update
     *
     * @param  int $id
     * @param $status
     * @return Redirect
     * @internal param Request $request
     */
    public function statusUpdate($id, $status)
    {
        if ($status == "0" || $status == "1") {
            try {
                $box = Boxes_waiting::findOrFail($id);
                if ($status == "0") {
                    $box->delete();
                }
                else {
                    $response = Curl::to(getenv('URL_API_FACTORY')."boxes")
                        ->withData($box->toArray())
                        ->asJson()
                        ->returnResponseObject()
                        ->post();
                    $message = $response->status != 200 ? $this->curlError($response->status) : ($status == "0" ? "Box deleted" : "Box created");
                    $this->session()->flash($response->status != 200 ? 'alert-danger' : 'alert-success', $message);
                }
            }
            catch (ModelNotFoundException $e) {
                return redirect($this->prefix);
            }
        }
        return redirect($this->prefix);
    }

    private function curlError($status)
    {
        if ($status == 500) {
            $e_msg = 'Internal error';
        }
        else if ($status == 503 ){
            $e_msg = 'Service Unavailable';
        }
        elseif ($status == 404){
            $e_msg = 'Impossible to find this machine, it might be deleted or deplaced';
        }
        else{
            $e_msg = "ERROR : " . $status;
        }
        return ($e_msg);
    }
}
