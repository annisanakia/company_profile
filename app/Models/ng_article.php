<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_article extends Model {
    use SoftDeletes;

    protected $table = 'ng_article';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'title' => 'required',
        'slug' => 'required',
        'ng_department_id' => 'required',
        'display' => 'required',
        'date' => 'required',
        'type' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_article::$rules, ng_article::$customMessages);
        return $v;
    }

    public function ng_department() {
        return $this->belongsTo('Models\ng_department');
    }

    public function users() {
        return $this->belongsTo('App\User', 'users_id', 'id');
    }

    public function ng_visit_module() {
        return $this->hasOne('Models\ng_visit_module', 'object_id')
                    ->where('object',$this->getTable());
    }

    public function next(){
        // get next
        $date = $this->date;
        $id = $this->id;
        $ng_article = ng_article::select(['date','slug'])
                ->where('type',$this->type)
                ->where('display',1)
                ->where('ng_department_id',$this->ng_department_id)
                ->where('date',$date)
                ->where('id','<',$id)
                ->orderBy('date','desc')
                ->orderBy('id','desc')
                ->first();
        if(!$ng_article){
            $ng_article = ng_article::select(['date','slug'])
                        ->where('type',$this->type)
                        ->where('display',1)
                        ->where('ng_department_id',$this->ng_department_id)
                        ->where('date','<',$date)
                        ->where('id','!=',$id)
                        ->orderBy('date','desc')
                        ->orderBy('id','desc')
                        ->first();
        }
        return $ng_article;
    }

    public  function previous(){
        // get previous
        $date = $this->date;
        $id = $this->id;
        $ng_article = ng_article::select(['date','slug'])
                ->where('type',$this->type)
                ->where('display',1)
                ->where('ng_department_id',$this->ng_department_id)
                ->where('date',$date)
                ->where('id','>',$id)
                ->orderBy('date','desc')
                ->orderBy('id','asc')
                ->first();
        if(!$ng_article){
            $ng_article = ng_article::select(['date','slug'])
                        ->where('type',$this->type)
                        ->where('display',1)
                        ->where('ng_department_id',$this->ng_department_id)
                        ->where('date','>',$date)
                        ->where('id','!=',$id)
                        ->orderBy('date','asc')
                        ->orderBy('id','asc')
                        ->first();
        }
        return $ng_article;
    }

    public function newData(){
        // get first
        return ng_article::select(['date','slug'])
                        ->where('type',$this->type)
                        ->where('display',1)
                        ->where('ng_department_id',$this->ng_department_id)
                        ->orderBy('date','desc')
                        ->orderBy('id','desc')
                        ->first();
    }

    public function oldData(){
        // get last
        return ng_article::select(['date','slug'])
                        ->where('type',$this->type)
                        ->where('display',1)
                        ->where('ng_department_id',$this->ng_department_id)
                        ->orderBy('date','asc')
                        ->orderBy('id','asc')
                        ->first();
    }
}