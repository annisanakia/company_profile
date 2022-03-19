<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class ng_menu extends Model {

    protected $table = 'ng_menu';
    protected $guarded = ['id'];
    public static $rules = array(
        'name' => 'required',
        'slug' => 'required',
        'parent' => 'required',
        'display' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_menu::$rules, ng_menu::$customMessages);
        return $v;
    }

    public function parents() {
        return $this->hasOne('Models\ng_menu', 'id', 'parent');
    }

    public function childs() {
        return $this->hasMany('Models\ng_menu', 'parent', 'id')
                ->orderBy('ordering','asc')
                ->orderBy('id','asc');
    }

    public function child() {
        return $this->hasOne('Models\ng_menu', 'parent', 'id')
                ->orderBy('ordering','asc')
                ->orderBy('id','asc');
    }

    public function getParentsIndex() {
        $parentalIndex = "#" . str_pad($this->id, 3, '0', STR_PAD_LEFT);
        $this->level = 1;
        if ($this->parent !== null && $this->parent != 0) {
            $p = ng_menu::find($this->parent);
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
            $tmp_depts = ng_menu::all();
        }
        $depts = array();
        foreach ($tmp_depts as $key => $val) {
            $pi = $val->getParentsIndex();
            $prefix = '';
            for ($i = 0; $i < $val->level - 1; $i++) {
                $prefix .= '-';
            }
            $val->setName($prefix . $val->name);
            $depts[$pi . '#id_' . $val->id] = $val->name : '');
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
            $tmp_depts = ng_menu::all();
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
            return $this->hasMany('Models\ng_menu', 'parent')->whereHas('acl', function($builder) {
                        $builder->where('groups_id', Session()->get('group_as', ''));
                    });
        } else {
            return $this->hasMany('Models\ng_menu', 'parent');
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
