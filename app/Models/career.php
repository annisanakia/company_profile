<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class career extends Model {
    use SoftDeletes;

    protected $table = 'career';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'career_type_id' => 'required',
        'name' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );

    public function career_type() {
        return $this->belongsTo('Models\career_type');
    }
    
    public function validate($data)
    {
        $v = Validator::make($data, career::$rules, career::$customMessages);
        return $v;
    }
}