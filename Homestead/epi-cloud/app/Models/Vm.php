<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vm extends Model
{
    protected $table = 'boxes';

    protected $user_id;
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
}
