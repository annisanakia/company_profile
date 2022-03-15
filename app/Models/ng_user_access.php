<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ng_user_access extends Model
{
    protected $table = 'ng_user_access';
    protected $guarded = ['id'];
    
    public static $rules = [];
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_user_access::$rules);
        return $v;
    }
}
