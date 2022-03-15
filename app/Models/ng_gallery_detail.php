<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ng_gallery_detail extends Model {
    use SoftDeletes;

    protected $table = 'ng_gallery_detail';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    public static $rules = array(
        'ng_gallery_id' => 'required',
        'title' => 'required',
        'type' => 'required',
        'slug' => 'required'
    );
    
    public static $customMessages = array(
        'required' => 'This field required.'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, ng_gallery_detail::$rules, ng_gallery_detail::$customMessages);
        return $v;
    }

    public function ng_gallery() {
        return $this->belongsTo('Models\ng_gallery');
    }

    public function next(){
        // get next
        return ng_gallery_detail::select(['ng_gallery_id','slug'])
                        ->where('ng_gallery_id',$this->ng_gallery_id)
                        ->where('id','<',$this->id)
                        ->orderBy('id','desc')
                        ->first();
    }

    public  function previous(){
        // get previous
        return ng_gallery_detail::select(['ng_gallery_id','slug'])
                        ->where('ng_gallery_id',$this->ng_gallery_id)
                        ->where('id','>',$this->id)
                        ->orderBy('id','asc')
                        ->first();
    }

    public function newData(){
        // get first
        return ng_gallery_detail::select(['ng_gallery_id','slug'])
                        ->where('ng_gallery_id',$this->ng_gallery_id)
                        ->orderBy('id','desc')
                        ->first();
    }

    public function oldData(){
        // get last
        return ng_gallery_detail::select(['ng_gallery_id','slug'])
                        ->where('ng_gallery_id',$this->ng_gallery_id)
                        ->orderBy('id','asc')
                        ->first();
    }
}