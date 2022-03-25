<?php

namespace App\Modules\Ng_menu\Controllers;

use Models\ng_menu as ng_menuModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class Ng_menu extends RESTful {

    public function __construct() {
        $model = new ng_menuModel;
        $controller_name = 'Ng_menu';

        $this->enable_xls_button = false;
        $this->enable_pdf_button = false;        

        parent::__construct($model, $controller_name);
    }

    public function filterComponent(Request $request) {
        $globalTools = new \Lib\core\globalTools();

        $component_type = $request->input('component_type');
        $id = $request->input('id');

        $target = 'component_link';

        $blank = false;
        if ($request->has('blank')) {
            $blank = $request->input('blank');
        }

        $datas = [];
        if($component_type == 1){
            //profile
            $datas = \Models\ng_article::where('type',1)
                        ->orderBy('title', 'asc')
                        ->orderBy('date', 'desc')
                        ->get();
        }elseif($component_type == 2){
            //news
            $datas = \Models\ng_article::where('type',2)
                        ->orderBy('title', 'asc')
                        ->orderBy('date', 'desc')
                        ->get();
        }elseif($component_type == 3){
            //events
            $datas = \Models\ng_article::where('type',3)
                        ->orderBy('title', 'asc')
                        ->orderBy('date', 'desc')
                        ->get();
        }elseif($component_type == 4){
            //prestasi
            $datas = \Models\ng_achievement::orderBy('title', 'asc')
                        ->orderBy('date', 'desc')
                        ->get();
        }elseif($component_type == 5){
            //fasilitas
            $datas = \Models\ng_gallery::whereHas('ng_gallery_category',function($builder){
                            $builder->where('code','fcy');
                        })
                        ->orderBy('title', 'asc')
                        ->orderBy('date', 'desc')
                        ->get();
        }elseif($component_type == 6){
            //gallery
            $datas = \Models\ng_gallery::whereHas('ng_gallery_category',function($builder){
                            $builder->where('code','gly');
                        })
                        ->orderBy('title', 'asc')
                        ->orderBy('date', 'desc')
                        ->get();
        }
        
        $components[''] = '-- Choose Component --';
        foreach($datas as $row){
            $components[$row->id] = $row->title . ' ( ' . (isset($row->ng_department->name)? $row->ng_department->name : '') . ' ) ';
        }

        return $globalTools->renderListArray($components, $target, $id, $blank);
    }

}
