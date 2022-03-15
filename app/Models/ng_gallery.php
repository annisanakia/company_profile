<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_gallery extends Model {
    use SoftDeletes;

    protected $table = 'ng_gallery';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'title' => 'required',
        'slug' => 'required',
        'ng_department_id' => 'required',
        'display' => 'required',
        'ng_gallery_category_id' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_gallery::$rules, ng_gallery::$customMessages);
        return $v;
    }

    public function ng_department() {
        return $this->belongsTo('Models\ng_department');
    }

    public function ng_gallery_category() {
        return $this->belongsTo('Models\ng_gallery_category');
    }

    public function ng_gallery_detail() {
        return $this->hasMany('Models\ng_gallery_detail')->orderBy('id','desc');
    }

    public function ng_gallery_detail_one() {
        return $this->hasOne('Models\ng_gallery_detail')->orderBy('id','desc');
    }

    public function users() {
        return $this->belongsTo('App\User', 'users_id', 'id');
    }

    public function next(){
        // get next
        $date = $this->date;
        $id = $this->id;
        $ng_gallery = ng_gallery::select(['date','slug'])
                ->where('ng_gallery_category_id',$this->ng_gallery_category_id)
                ->where('display',1)
                ->where('ng_department_id',$this->ng_department_id)
                ->where('date',$date)
                ->where('id','<',$id)
                ->orderBy('date','desc')
                ->orderBy('id','desc')
                ->first();
        if(!$ng_gallery){
            $ng_gallery = ng_gallery::select(['date','slug'])
                        ->where('ng_gallery_category_id',$this->ng_gallery_category_id)
                        ->where('display',1)
                        ->where('ng_department_id',$this->ng_department_id)
                        ->where('date','<',$date)
                        ->where('id','!=',$id)
                        ->orderBy('date','desc')
                        ->orderBy('id','desc')
                        ->first();
        }
        return $ng_gallery;
    }

    public  function previous(){
        // get previous
        $date = $this->date;
        $id = $this->id;
        $ng_gallery = ng_gallery::select(['date','slug'])
                ->where('ng_gallery_category_id',$this->ng_gallery_category_id)
                ->where('display',1)
                ->where('ng_department_id',$this->ng_department_id)
                ->where('date',$date)
                ->where('id','>',$id)
                ->orderBy('date','desc')
                ->orderBy('id','asc')
                ->first();
        if(!$ng_gallery){
            $ng_gallery = ng_gallery::select(['date','slug'])
                        ->where('ng_gallery_category_id',$this->ng_gallery_category_id)
                        ->where('display',1)
                        ->where('ng_department_id',$this->ng_department_id)
                        ->where('date','>',$date)
                        ->where('id','!=',$id)
                        ->orderBy('date','asc')
                        ->orderBy('id','asc')
                        ->first();
        }
        return $ng_gallery;
    }

    public function newData(){
        // get first
        return ng_gallery::select(['date','slug'])
                        ->where('ng_gallery_category_id',$this->ng_gallery_category_id)
                        ->where('display',1)
                        ->where('ng_department_id',$this->ng_department_id)
                        ->orderBy('date','desc')
                        ->orderBy('id','desc')
                        ->first();
    }

    public function oldData(){
        // get last
        return ng_gallery::select(['date','slug'])
                        ->where('ng_gallery_category_id',$this->ng_gallery_category_id)
                        ->where('display',1)
                        ->where('ng_department_id',$this->ng_department_id)
                        ->orderBy('date','asc')
                        ->orderBy('id','asc')
                        ->first();
    }
}