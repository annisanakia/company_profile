<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class job extends Model {

    protected $table = 'job';
    protected $guarded = ['id'];
    public static $rules = array(
        'code' => 'required',
        'name' => 'required',
        'parent' => 'required',
        'display' => 'required',
        'menu_type_id' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, job::$rules, job::$customMessages);
        return $v;
    }

    public function acl() {
        return $this->hasMany('Models\acl');
    }

    public function parents() {
        return $this->hasOne('Models\job', 'id', 'parent');
    }

    public function menu_type() {
        return $this->belongsTo('Models\menu_type', 'menu_type_id');
    }

    public function getParentsIndex() {
        $parentalIndex = "#" . str_pad($this->id, 3, '0', STR_PAD_LEFT);
        $this->level = 1;
        if ($this->parent !== null && $this->parent != 0) {
            $p = job::find($this->parent);
            $parentalIndex = str_pad($p->getParentsIndex(), 3, '0', STR_PAD_LEFT) . "_" . $parentalIndex;
            $this->level += $p->level;
        }
        $this->parentalIndex = $parentalIndex;
        return $parentalIndex;
    }

    public function setName($value) {
        $this->attributes['name'] = $value;
    }

    public static function nestedSelect($tmp_depts = array()) {
        if (empty($tmp_depts)) {
            $tmp_depts = job::all();
        }
        $depts = array();
        foreach ($tmp_depts as $key => $val) {
            $pi = $val->getParentsIndex();
            $prefix = '';
            for ($i = 0; $i < $val->level - 1; $i++) {
                $prefix .= '-';
            }
            $val->setName($prefix . $val->name);
            $depts[$pi . '#id_' . $val->id] = $val->name;
        }
        ksort($depts);
        $result = array();
        foreach ($depts as $key => $r) {
            $key = substr($key, strpos($key, "#id_") + 4);
            $result[$key] = $r;
        }
        return $result;
    }

    public static function nestedList($tmp_depts = array()) {
        if (empty($tmp_depts)) {
            $tmp_depts = job::all();
        }
        $depts = array();
        foreach ($tmp_depts as $key => $val) {
            $pi = $val->getParentsIndex();
            $prefix = '';
            for ($i = 0; $i < $val->level - 1; $i++) {
                $prefix .= '- ';
            }

            $val->setName($prefix . $val->name);
            $depts[$pi] = $val;
        }
        ksort($depts);
        $result = array();
        foreach ($depts as $key => $r) {
            $result[] = $r;
        }
        return $result;
    }

    // loads only direct children - 1 level
    public function children() {
        if (\Session::has('group_as')) {
            return $this->hasMany('Models\job', 'parent')->whereHas('acl', function($builder) {
                        $builder->where('groups_id', Session()->get('group_as', ''));
                    });
        } else {
            return $this->hasMany('Models\job', 'parent');
        }
    }

    // recursive, loads all descendants
    public function childrenRecursive() {
        return $this->children()->with('childrenRecursive');
    }

    // parent
    public function parentRecursive() {
        return $this->parents()->with('parentRecursive');
    }

}
