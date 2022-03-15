<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class menu_type extends Model {

    protected $table = 'menu_type';
    
    protected $guarded = ['id'];
    
    public static $rules = array(
        'code' => 'required',
        'name' => 'required',
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, menu_type::$rules);
        return $v;
    }
}