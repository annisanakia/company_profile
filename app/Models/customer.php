<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class customer extends Model {
    use SoftDeletes;

    protected $table = 'customer';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'name' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, customer::$rules, customer::$customMessages);
        return $v;
    }
}