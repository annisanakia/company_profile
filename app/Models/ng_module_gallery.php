<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_module_gallery extends Model {
    use SoftDeletes;

    protected $table = 'ng_module_gallery';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'ng_module_id' => 'required',
        'name' => 'required',
        'ng_department_id' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_module_gallery::$rules, ng_module_gallery::$customMessages);
        return $v;
    }

    public function ng_module() {
        return $this->belongsTo('Models\ng_module');
    }
}