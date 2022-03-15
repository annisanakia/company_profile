<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class task_acl extends Model {

    protected $table = 'task_acl';
    protected $guarded = ['id'];
    
    public static $rules = array(
        'groups_id' => 'required',
        'task_id' => 'required'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, task_acl::$rules);
        return $v;
    }
    
    public function groups() {
        return $this->belongsTo('Models\groups');
    }
    
    public function task() {
        return $this->belongsTo('Models\task');
    }
}