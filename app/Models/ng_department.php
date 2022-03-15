<?php

namespace Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_department extends Model {
    use SoftDeletes;

    protected $table = 'ng_department';
    protected $guarded = ['id'];
    public static $rules = array(
        'code' => 'required',
        'name' => 'required',
        'parent' => 'required',
        'sequence' => 'numeric|nullable',
        'fax_no' => 'numeric|nullable',
        'email' => 'email|nullable'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.',
        'numeric' => 'This field must be a number.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_department::$rules, ng_department::$customMessages);
        return $v;
    }

    public function parents() {
        return $this->hasOne('Models\ng_department', 'id', 'parent');
    }

    public function childs() {
        return $this->hasMany('Models\ng_department', 'parent', 'id')
                    ->orderBy('sequence','asc')
                    ->orderBy('id','asc');
    }

    public function ng_menu_type() {
        return $this->hasOne('Models\ng_menu_type', 'ng_department_id', 'id');
    }

    public function ng_department_level() {
        return $this->belongsTo('Models\ng_department_level');
    }

    public function setName($value) {
        $this->attributes['name'] = $value;
    }

    public function setCode($value) {
        $this->attributes['code'] = $value;
    }

    public function getParentsIndex() {
        $parentalIndex = "#" . str_pad($this->id, 3, '0', STR_PAD_LEFT);
        $this->level = 1;
         
        if ($this->parent !== null && $this->parent != 0 && $this->parents()) {
            $p = ng_department::find($this->parent);
            if ($p) {
                $parentalIndex = str_pad($p->getParentsIndex(), 3, '0', STR_PAD_LEFT) . "_" . $parentalIndex;
                $this->level += $p->level;
            }
        }
        $this->parentalIndex = $parentalIndex;
        return $parentalIndex;
    }

    public static function nestedList($tmp_depts = array()) {
        if (empty($tmp_depts)) {
            $tmp_depts = ng_department::all();
        }
        $depts = array();
        foreach ($tmp_depts as $key => $val) {
            $pi = $val->getParentsIndex();
            $prefix = '';
            for ($i = 0; $i < $val->level - 1; $i++) {
                $prefix .= '- ';
            }

            $val->setName($prefix . $val->name);
            $val->setCode($prefix . $val->code);
            $depts[$pi] = $val;
        }
        ksort($depts);
        $result = array();
        foreach ($depts as $key => $r) {
            $result[] = $r;
        }
        return $result;
    }

    public static function nestedSelect($tmp_depts = array(), $no_filter = false) {
        if (empty($tmp_depts)) {
            $tmp_depts = ng_department::select(['*']);

            $user = \Auth::user();

            if (!$no_filter) {
                if ($user) {
                    $ng_department_id = $user->ng_department_id;
                    $ng_department_ids = \Models\ng_department::getChildRecursive($ng_department_id);

                    $tmp_depts->whereIn('id', $ng_department_ids);
                }
            }
        } 
        $tmp_depts = $tmp_depts->get();
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

    public function getChilds($data, $ids = []) {
        if (isset($data->childs)) {
            if (count($data->childs) > 0) {
                foreach ($data->childs as $ch) {
                    $ids[] = $ch->id;
                    $ids = $ch->getChilds($ch, $ids);
                }
            }
        }

        return $ids;
    }

    public static function getChildRecursive($id) {
        $department = \Models\ng_department::find($id);
        if ($department) {
            return $department->getChilds($department, [$department->id]);
        } else {
            return [$id];
        }
    }

    public function getParents($data, $ids = []) {
        if (isset($data->parents)) {
            $pr = $data->parents;
            $ids[] = $pr->id;
            $ids = $pr->getParents($pr, $ids);
        }

        return $ids;
    }

    public static function getparentRecursive($id) {
        $department = \Models\ng_department::find($id);
        if ($department) {
            return $department->getParents($department, [$department->id]);
        } else {
            return [$id];
        }
    }

    public static function getAllParents($data = array()) {
        if (empty($data)) {
            $data = ng_department::all();
        }

        $ids = [];
        if (count($data) > 0) {
            foreach ($data as $row) {
                if (count($row->childs) > 0) {
                    $ids[] = $row->id;
                }
            }
        }

        return $ids;
    }

    public static function getAllParentsZero($data = array()) {
        if (empty($data)) {
            $data = ng_department::all();
        }

        $ids = [];
        if (count($data) > 0) {
            foreach ($data as $row) {
                if ($row->parent == 1001) {
                    $ids[] = $row->id;
                }
            }
        }

        return $ids;
    }
}
