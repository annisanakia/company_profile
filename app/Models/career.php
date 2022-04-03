<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class career extends Model {
    use SoftDeletes;

    protected $table = 'career';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'career_type_id' => 'required',
        'name' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );

    public function career_type() {
        return $this->belongsTo('Models\career_type');
    }

    public function next(){
        // get next
        $start_date = $this->start_date;
        $id = $this->id;
        $career = career::select(['start_date','slug'])
                ->where('is_publish',1)
                ->where('company_id',$this->company_id)
                ->where('start_date',$start_date)
                ->where('id','<',$id)
                ->orderBy('start_date','desc')
                ->orderBy('id','desc')
                ->first();
        if(!$career){
            $career = career::select(['start_date','slug'])
                        ->where('is_publish',1)
                        ->where('company_id',$this->company_id)
                        ->where('start_date','<',$start_date)
                        ->where('id','!=',$id)
                        ->orderBy('start_date','desc')
                        ->orderBy('id','desc')
                        ->first();
        }
        return $career;
    }

    public  function previous(){
        // get previous
        $start_date = $this->start_date;
        $id = $this->id;
        $career = career::select(['start_date','slug'])
                ->where('is_publish',1)
                ->where('company_id',$this->company_id)
                ->where('start_date',$start_date)
                ->where('id','>',$id)
                ->orderBy('start_date','desc')
                ->orderBy('id','asc')
                ->first();
        if(!$career){
            $career = career::select(['start_date','slug'])
                        ->where('is_publish',1)
                        ->where('company_id',$this->company_id)
                        ->where('start_date','>',$start_date)
                        ->where('id','!=',$id)
                        ->orderBy('start_date','asc')
                        ->orderBy('id','asc')
                        ->first();
        }
        return $career;
    }

    public function newData(){
        // get first
        return career::select(['start_date','slug'])
                        ->where('is_publish',1)
                        ->where('company_id',$this->company_id)
                        ->orderBy('start_date','desc')
                        ->orderBy('id','desc')
                        ->first();
    }

    public function oldData(){
        // get last
        return career::select(['start_date','slug'])
                        ->where('is_publish',1)
                        ->where('company_id',$this->company_id)
                        ->orderBy('start_date','asc')
                        ->orderBy('id','asc')
                        ->first();
    }
    
    public function validate($data)
    {
        $v = Validator::make($data, career::$rules, career::$customMessages);
        return $v;
    }
}