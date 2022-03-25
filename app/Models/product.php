<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model {
    use SoftDeletes;

    protected $table = 'product';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'product_category_id' => 'required',
        'name' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );

    public function product_category() {
        return $this->belongsTo('Models\product_category');
    }
    
    public function validate($data)
    {
        $v = Validator::make($data, product::$rules, product::$customMessages);
        return $v;
    }
}