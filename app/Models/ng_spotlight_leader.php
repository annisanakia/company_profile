<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_spotlight_leader extends Model {
    use SoftDeletes;

    protected $table = 'ng_spotlight_leader';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'name' => 'required',
        'slug' => 'required',
        'ng_department_id' => 'required',
        'display' => 'required',
        'date' => 'required',
        'sex' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_spotlight_leader::$rules, ng_spotlight_leader::$customMessages);
        return $v;
    }

    public function ng_news_category() {
        return $this->belongsTo('Models\ng_news_category');
    }

    public function ng_department() {
        return $this->belongsTo('Models\ng_department');
    }
}