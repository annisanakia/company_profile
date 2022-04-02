<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class contact extends Model {
    use SoftDeletes;

    protected $table = 'contact';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'name' => 'required',
        'email' => 'required|email',
        'phone_no' => 'required|numeric',
        'desc' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, contact::$rules, contact::$customMessages);
        return $v;
    }
}