<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class company_header extends Model {
    use SoftDeletes;

    protected $table = 'company_header';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'name' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );

    public function data_content() {
        if($this->object == 'article'){
            return $this->belongsTo('Models\article', 'object_id', 'id');
        }elseif($this->object == 'product'){
            return $this->belongsTo('Models\product', 'object_id', 'id');
        }else{
            return $this->belongsTo('Models\career', 'object_id', 'id');
        }
    }
    
    public function validate($data)
    {
        $v = Validator::make($data, company_header::$rules, company_header::$customMessages);
        return $v;
    }
}