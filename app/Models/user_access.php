<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class user_access extends Model
{
    protected $table = 'user_access';
    protected $guarded = ['id'];
    
    public static $rules = [];
    
    public function validate($data)
    {
        $v = Validator::make($data, user_access::$rules);
        return $v;
    }
}
