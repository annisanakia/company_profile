<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class groups extends Model {

    protected $table = 'groups';
    protected $guarded = ['id'];
    
    public static $rules = array(
        'code' => 'required',
        'name' => 'required',
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, groups::$rules, groups::$customMessages);
        return $v;
    }

    public function task_acl() {
        return $this->hasMany('Models\task_acl');
    }
}