<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_news_category extends Model {
    use SoftDeletes;

    protected $table = 'ng_news_category';
    protected $guarded = ['id'];
    public static $rules = array(
        'code' => 'required',
        'name' => 'required',
        'slug' => 'required',
        'parent' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_news_category::$rules, ng_news_category::$customMessages);
        return $v;
    }

    public function parents() {
        return $this->hasOne('Models\ng_news_category', 'id', 'parent');
    }
	
	public function getParent() {
        $parent =  \Models\ng_news_category::where('id',$this->parent)->first();
		if(!$parent){
			return $this;
		}
		return $parent;
    }

    public function childs() {
        return $this->hasMany('Models\ng_news_category', 'parent', 'id');
    }

    public function getParentsIndex() {
        $parentalIndex = "#" . str_pad($this->id, 3, '0', STR_PAD_LEFT);
        $this->level = 1;
        try{
            if ($this->parent !== null && $this->parent != 0) {
                $p = ng_news_category::find($this->parent);
                if ($p) {
                    $parentalIndex = str_pad($p->getParentsIndex(), 3, '0', STR_PAD_LEFT) . "_" . $parentalIndex;
                    $this->level += $p->level;
                }
            }
            $this->parentalIndex = $parentalIndex;
        }catch(Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            die();
        }
        return $parentalIndex;
    }

    public function setName($value) {
        $this->attributes['name'] = $value;
    }

    public function setCode($value) {
        $this->attributes['code'] = $value;
    }

    public static function nestedList($tmp_depts = array()) {
        if (empty($tmp_depts)) {
            $tmp_depts = ng_news_category::all();
        }
        $depts = array();
        foreach ($tmp_depts as $key => $val) {
            $pi = $val->getParentsIndex();
            $prefix = '';
            for ($i = 0; $i < $val->level - 1; $i++) {
                $prefix .= '-';
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

    public static function nestedSelect($tmp_depts = array()) {
        if (empty($tmp_depts)) {
            $tmp_depts = ng_news_category::orderBy("id", "DESC");
        }

        $user = \Auth::user();

        $tmp_depts = $tmp_depts->get();

        $depts = array();
        foreach ($tmp_depts as $key => $val) {
            $pi = $val->getParentsIndex();
            $prefix = '';
            for ($i = 0; $i < $val->level - 1; $i++) {
                $prefix .= '-';
            }
            $val->setName($prefix . $val->name);
            $depts[$pi . '#id_' . $val->id] = isset($val->ng_department) ? $val->name . ' ( ' . $val->ng_department->name . ' )' : $val->name;
        }
        ksort($depts);
        $result = array();
        foreach ($depts as $key => $r) {
            $key = substr($key, strpos($key, "#id_") + 4);
            $result[$key] = $r;
        }
        return $result;
    }

    public function ng_va_student() {
        return $this->hasOne('Models\ng_va_student');
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
        $ng_news_category = \Models\ng_news_category::find($id);
        if ($ng_news_category) {
            return $ng_news_category->getChilds($ng_news_category, [$ng_news_category->id]);
        } else {
            return [$id];
        }
    }
    
    public static function getAllParents() {
        $data = ng_news_category::all();
        
        $ids = [];
        if (count($data) > 0) {
            foreach ($data as $row) {
                if(count($row->childs) > 0){
                    $ids[] = $row->id;
                }
            }
        }

        return $ids;
    }

}
