<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_gallery_category extends Model {
    use SoftDeletes;

    protected $table = 'ng_gallery_category';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'code' => 'required',
        'name' => 'required',
        'slug' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_gallery_category::$rules, ng_gallery_category::$customMessages);
        return $v;
    }
}