<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class acl extends Model {

    protected $table = 'acl';
    protected $guarded = ['id'];
    
    public static $rules = array(
        'groups_id' => 'required',
        'job_id' => 'required'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, acl::$rules);
        return $v;
    }
    
    public function job() {
        return $this->belongsTo('Models\job');
    }
    
    public function groups() {
        return $this->belongsTo('Models\groups');
    }
}
