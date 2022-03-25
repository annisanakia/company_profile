<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class career_type extends Model {
    use SoftDeletes;

    protected $table = 'career_type';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'code' => 'required',
        'name' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, career_type::$rules, career_type::$customMessages);
        return $v;
    }
}