<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
     protected $table = 'users';

      protected $primaryKey = 'users_id';

     public $timestamps = false;
}
