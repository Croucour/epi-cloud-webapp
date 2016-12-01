<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Boxes extends Model
{
    protected $table = 'boxes';

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

    protected $fillable = ['name', 'os', 'os_version', 'ram', 'nb_core', 'running', 'ip', 'port'];


    public static function getByStudent()
    {

        $boxes = DB::table('boxes')
            ->select("boxes.*")
            ->leftJoin('users', 'users.id', '=', 'boxes.user_id')
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
            $vms = Boxes::all();
        }
        else if ($user->hasRole('Employees') || $user->hasRole('Students')) {
            $vms = Boxes::all()->where('user_id', "=", $user->id);

            $studentVms =  Boxes::getByStudent();
            if ($studentVms != null) {
                $studentVms->merge($vms);
                $vms = $studentVms;
            }
        }
        else {
            $vms = Boxes::all()->where('user_id', "=", $user->id);
        }

        return $vms;
    }
}