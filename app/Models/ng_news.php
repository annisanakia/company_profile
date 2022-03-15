<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_news extends Model {
    use SoftDeletes;

    protected $table = 'ng_news';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'title' => 'required',
        'slug' => 'required',
        'ng_news_category_id' => 'required',
        'ng_department_id' => 'required',
        'display' => 'required',
        'date' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_news::$rules, ng_news::$customMessages);
        return $v;
    }

    public function ng_news_category() {
        return $this->belongsTo('Models\ng_news_category');
    }

    public function ng_department() {
        return $this->belongsTo('Models\ng_department');
    }
}