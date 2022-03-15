<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class user_group extends Model {
    use SoftDeletes;

    protected $table = 'user_group';
    protected $guarded = ['id'];
    public static $rules = array(
        'groups_id' => 'required',
        'users_id' => 'required'
    );

    public function validate($data) {
        $v = Validator::make($data, user_group::$rules);
        return $v;
    }

    public function groups() {
        return $this->belongsTo('Models\groups', 'groups_id', 'id');
    }

    public function user() {
        return $this->belongsTo('user');
    }

    public function group_user_notif() {
        return $this->hasMany('group_user_notif');
    }
}
