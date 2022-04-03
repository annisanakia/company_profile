<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class article extends Model {
    use SoftDeletes;

    protected $table = 'article';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'article_category_id' => 'required',
        'name' => 'required',
        'date' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );

    public function article_category() {
        return $this->belongsTo('Models\article_category');
    }

    public function next(){
        // get next
        $date = $this->date;
        $id = $this->id;
        $article = article::select(['date','slug'])
                ->where('is_publish',1)
                ->where('company_id',$this->company_id)
                ->where('date',$date)
                ->where('id','<',$id)
                ->orderBy('date','desc')
                ->orderBy('id','desc')
                ->first();
        if(!$article){
            $article = article::select(['date','slug'])
                        ->where('is_publish',1)
                        ->where('company_id',$this->company_id)
                        ->where('date','<',$date)
                        ->where('id','!=',$id)
                        ->orderBy('date','desc')
                        ->orderBy('id','desc')
                        ->first();
        }
        return $article;
    }

    public  function previous(){
        // get previous
        $date = $this->date;
        $id = $this->id;
        $article = article::select(['date','slug'])
                ->where('is_publish',1)
                ->where('company_id',$this->company_id)
                ->where('date',$date)
                ->where('id','>',$id)
                ->orderBy('date','desc')
                ->orderBy('id','asc')
                ->first();
        if(!$article){
            $article = article::select(['date','slug'])
                        ->where('is_publish',1)
                        ->where('company_id',$this->company_id)
                        ->where('date','>',$date)
                        ->where('id','!=',$id)
                        ->orderBy('date','asc')
                        ->orderBy('id','asc')
                        ->first();
        }
        return $article;
    }

    public function newData(){
        // get first
        return article::select(['date','slug'])
                        ->where('is_publish',1)
                        ->where('company_id',$this->company_id)
                        ->orderBy('date','desc')
                        ->orderBy('id','desc')
                        ->first();
    }

    public function oldData(){
        // get last
        return article::select(['date','slug'])
                        ->where('is_publish',1)
                        ->where('company_id',$this->company_id)
                        ->orderBy('date','asc')
                        ->orderBy('id','asc')
                        ->first();
    }
    
    public function validate($data)
    {
        $v = Validator::make($data, article::$rules, article::$customMessages);
        return $v;
    }
}