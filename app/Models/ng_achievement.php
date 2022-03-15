<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_achievement extends Model {
    use SoftDeletes;

    protected $table = 'ng_achievement';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'title' => 'required',
        'name' => 'required',
        'slug' => 'required',
        'ng_department_id' => 'required',
        'date' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );

    public function validate($data)
    {
        $v = Validator::make($data, ng_achievement::$rules, ng_achievement::$customMessages);
        return $v;
    }

    public function ng_department() {
        return $this->belongsTo('Models\ng_department');
    }

    public function next(){
        // get next
        $date = $this->date;
        $id = $this->id;
        $ng_achievement = ng_achievement::select(['date','slug'])
                ->where('ng_department_id',$this->ng_department_id)
                ->where('date',$date)
                ->where('id','<',$id)
                ->orderBy('date','desc')
                ->orderBy('id','desc')
                ->first();
        if(!$ng_achievement){
            $ng_achievement = ng_achievement::select(['date','slug'])
                        ->where('ng_department_id',$this->ng_department_id)
                        ->where('date','<',$date)
                        ->where('id','!=',$id)
                        ->orderBy('date','desc')
                        ->orderBy('id','desc')
                        ->first();
        }
        return $ng_achievement;
    }

    public  function previous(){
        // get previous
        $date = $this->date;
        $id = $this->id;
        $ng_achievement = ng_achievement::select(['date','slug'])
                ->where('ng_department_id',$this->ng_department_id)
                ->where('date',$date)
                ->where('id','>',$id)
                ->orderBy('date','desc')
                ->orderBy('id','asc')
                ->first();
        if(!$ng_achievement){
            $ng_achievement = ng_achievement::select(['date','slug'])
                        ->where('ng_department_id',$this->ng_department_id)
                        ->where('date','>',$date)
                        ->where('id','!=',$id)
                        ->orderBy('date','asc')
                        ->orderBy('id','asc')
                        ->first();
        }
        return $ng_achievement;
    }

    public function newData(){
        // get first
        return ng_achievement::select(['date','slug'])
                        ->where('ng_department_id',$this->ng_department_id)
                        ->orderBy('date','desc')
                        ->orderBy('id','desc')
                        ->first();
    }

    public function oldData(){
        // get last
        return ng_achievement::select(['date','slug'])
                        ->where('ng_department_id',$this->ng_department_id)
                        ->orderBy('date','asc')
                        ->orderBy('id','asc')
                        ->first();
    }
}