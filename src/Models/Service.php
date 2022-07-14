<?php

namespace Rutatiina\Qbuks\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $connection = 'system';

    protected $table = 'rg_services';

    protected $primaryKey = 'id';

}
