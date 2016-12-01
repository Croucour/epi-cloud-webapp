<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Boxes_waiting extends Model
{
    protected $table = 'boxes_waiting';

    protected $user_id;
    protected $name;
    protected $os;
    protected $os_version;
    protected $ram;
    protected $nb_core;
    /**
     * @var boolean $running
     */
    protected $running;
    protected $ip;
    protected $port;
    protected $status;

    protected $fillable = ['user_id', 'name', 'os', 'os_version', 'ram', 'nb_core', 'running', 'ip', 'port', "status"];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getByStudent()
    {

        $boxes = DB::table('boxes_waiting')
            ->select("boxes_waiting.*")
            ->leftJoin('users', 'users.id', '=', 'boxes_waiting.user_id')
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('roles.name', "=", "Student")
            ->get();

        return $boxes->isEmpty() ? null : Boxes::hydrate($boxes->toArray());
    }

    public static function getByRole()
    {
        $user = Auth::user();

        $vms = null;
        if ($user->hasRole('SysAdmin')) {
            $vms = Boxes_waiting::all();
        }
        else if ($user->hasRole('Employees') || $user->hasRole('Students')) {
            $vms = Boxes_waiting::all()->where('user_id', "=", $user->id);

            $studentVms =  Boxes_waiting::getByStudent();
            if ($studentVms != null) {
                $studentVms->merge($vms);
                $vms = $studentVms;
            }
        }
        else {
            $vms = Boxes_waiting::all()->where('user_id', "=", $user->id);
        }

        return $vms->isEmpty() ? null : $vms;
    }
}