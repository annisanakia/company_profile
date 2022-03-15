<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_module extends Model {
    use SoftDeletes;

    protected $table = 'ng_module';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'title' => 'required',
        'slug' => 'required',
        'ng_department_id' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_module::$rules, ng_module::$customMessages);
        return $v;
    }

    public function ng_department() {
        return $this->belongsTo('Models\ng_department');
    }

    public function ng_module_gallery() {
        return $this->hasMany('Models\ng_module_gallery')->orderBy('id','desc');
    }
}