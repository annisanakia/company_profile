<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class article extends Model {
    use SoftDeletes;

    protected $table = 'article';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'article_category_id' => 'required',
        'name' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );

    public function article_category() {
        return $this->belongsTo('Models\article_category');
    }
    
    public function validate($data)
    {
        $v = Validator::make($data, article::$rules, article::$customMessages);
        return $v;
    }
}