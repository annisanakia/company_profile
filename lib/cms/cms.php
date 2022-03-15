<?php

namespace Lib\cms;

use Illuminate\Contracts\View\View;
use Models\ng_article;
use Illuminate\Support\Facades\Auth;
use Request;

class cms {
    public function countViewsModule($object,$object_id){
        $input['object'] = $object;
        $input['object_id'] = $object_id;
        $ng_visit_module = \Models\ng_visit_module::where('object',$object)
                ->where('object_id',$object_id)
                ->first();
        if($ng_visit_module){
            $input['count_visit'] = $ng_visit_module->count_visit+1;
            $ng_visit_module->update($input);
        }else{
            $input['count_visit'] = 1;
            $ng_visit_module = \Models\ng_visit_module::create($input);
        }
    }

    public function recentPost($object,$type,$ng_department_id){
        $recents = [];
        if($object == 'ng_article'){
            $recents = ng_article::select(['title','date','slug','publish_start','publish_end'])
                    ->where('type',$type)
                    ->where('ng_department_id',$ng_department_id)
                    ->where('display',1)
                    ->orderBy('date','desc')
                    ->orderBy('id','desc')
                    ->limit(5)
                    ->get();
        }
        return $recents;
    }
}