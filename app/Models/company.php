<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class company extends Model {
    use SoftDeletes;

    protected $table = 'company';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'title' => 'required',
        'slug' => 'required',
        'ng_department_id' => 'required',
        'display' => 'required',
        'date' => 'required',
        'type' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_article::$rules, ng_article::$customMessages);
        return $v;
    }

    public function ng_department() {
        return $this->belongsTo('Models\ng_department');
    }

    public function users() {
        return $this->belongsTo('App\User', 'users_id', 'id');
    }

    public function ng_visit_module() {
        return $this->hasOne('Models\ng_visit_module', 'object_id')
                    ->where('object',$this->getTable());
    }
}