<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vm extends Model
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


    public static function getByRole($role_name) {

        $boxes = DB::table('boxes')
            ->select("boxes.*")
            ->leftJoin('users', 'users.id', '=', 'boxes.user_id')
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('roles.name', "=", $role_name)
            ->get();

        return $boxes->isEmpty() ? null : Vm::hydrate($boxes->toArray());
    }

}
