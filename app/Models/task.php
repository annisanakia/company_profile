<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class task extends Model {

    protected $table = 'task';
    protected $guarded = ['id'];
    
    public static $rules = array(
        'code' => 'required',
        'name' => 'required',
        'description' => 'required',
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    
    public function validate($data)
    {
        $v = Validator::make($data, task::$rules, task::$customMessages);
        return $v;
    }

    public function task_acl() {
        return $this->hasMany('Models\task_acl');
    }
}