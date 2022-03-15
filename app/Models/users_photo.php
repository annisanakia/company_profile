<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class users_photo extends Model {
    use SoftDeletes;

    protected $table = 'users_photo';
    protected $guarded = ['id'];
    
    public static $rules = array(
        'filename' => 'required'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, users_photo::$rules);
        return $v;
    }
}