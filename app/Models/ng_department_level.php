<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class ng_department_level extends Model {

    protected $table = 'ng_department_level';
    protected $guarded = ['id'];
    public static $rules = array(
        'code' => 'required',
        'name' => 'required'
    );

    public function ng_department() {
        return $this->hasMany('Models\ng_department');
    }

    public function validate($data) {
        $v = Validator::make($data, ng_department_level::$rules);
        return $v;
    }

    public function setName($value) {
        $this->attributes['name'] = $value;
    }

    public static function nestedList($tmp_depts = array()) {
        if (empty($tmp_depts)) {
            $tmp_depts = ng_department_level::all();
        }
        $depts = array();
        foreach ($tmp_depts as $key => $val) {
            $val->setName($val->name . ' (' . $val->code . ')');
            $depts[$val->id] = $val->name;
        }
        return $depts;
    }
}
