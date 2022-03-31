<?php

namespace Lib\cms;

use Illuminate\Contracts\View\View;
use Models\article;
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

    public function recentPost($object,$id,$company_id){
        $recents = [];
        if($object == 'article'){
            $recents = article::select(['name','date','slug'])
                    ->where('id','!=',$id)
                    ->where('company_id',$company_id)
                    ->where('is_publish',1)
                    ->orderBy('date','desc')
                    ->orderBy('id','desc')
                    ->limit(5)
                    ->get();
        }
        return $recents;
    }
}