<?php

namespace Rutatiina\Qbuks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    
    protected $connection = 'system';

    protected $table = 'rg_services';

    protected $primaryKey = 'id';

}
