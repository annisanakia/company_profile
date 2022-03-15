<?php

namespace Lib\core;

use Illuminate\Contracts\View\View;
use Models\ng_menu;
use Models\ng_article;
use Illuminate\Support\Facades\Auth;
use Request;

class menuComposerFront {
    public function compose($menu_type_id) {
        $menu = ng_menu::where('display', 1)
                    ->where('ng_menu_type_id', $menu_type_id)
                    ->where('parent',0)
                    ->orderBy('ordering', 'asc')
                    ->get()
                    ->toArray();
                    
        if ($menu) {
            $menu = $this->createMenu($menu);
        }

        return $menu;
    }

    function createMenu($data) {
        foreach ($data as $row) {
            $menu[$row['id']] = $row;
        }

        $addedAsChildren = array();

        foreach ($menu as $id => &$menuItem) { // note that we use a reference so we don't duplicate the array
            if (!empty($menuItem['parent']) && $menuItem['parent'] != 0) {
                if (!array_key_exists($menuItem['parent'], $menu)) {
                    unset($menu[$id]);
                } else {
                    $addedAsChildren[] = $id; // it should be removed from root, but we'll do that later

                    if (!isset($menu[$menuItem['parent']]['children'])) {
                        $menu[$menuItem['parent']]['children'] = array($menuItem['id'] => &$menuItem); // & means we use the REFERENCE
                    } else {
                        $menu[$menuItem['parent']]['children'][$menuItem['id']] = &$menuItem; // & means we use the REFERENCE
                    }
                }
            }
            // unset($menuItem['parent']); // we don't need parent any more                
        }

        unset($menuItem); // unset the reference

        foreach ($addedAsChildren as $itemID) {
            unset($menu[$itemID]); // remove it from root so it's only in the ['children'] subarray
        }

        return $this->makeTree($menu);
    }

    function makeTree($menu, $class = 'navbar-nav mr-auto', $attribute = '') {
        $tree = '<ul  class="' . $class . '" ' . $attribute . '>';
        $component_types = [1 => 'article', 'news', 'facilities', 'gallery', 'contact', 'module', 'external Link'];
        foreach ($menu as $id => $menuItem) {
            $link_class = '';
            $nav_class = '';
            $active = '';
            
            $component_type = array_key_exists($menuItem['component_type'],$component_types)? $component_types[$menuItem['component_type']] : '';
            $url = 'category/'.$menuItem['slug'].'.html';
            $nav_class = 'nav-item';
            if (!empty($menuItem['children'])) {
                $link_class = 'nav-link parent';
            } else {
                $link_class = 'nav-link';
                if($menuItem['slug'] == 'home'){
                    $url = '';
                }elseif(ng_menu::where('parent', '=', $id)->first()) {
                    // $child = ng_menu::where('parent', '=', $id)->orderBy('id','desc')->first();
                    $url = 'category/'.$menuItem['slug'].'.html';
                }elseif($menuItem['parent'] != 0){
                    $nav_class = '';
                    $link_class = 'menu-sub';
                }
            }
            $target = '';
            if($menuItem['component_type'] == 8){
                $url = $menuItem['component_link'];
                $target = 'target="_blank"';
            }

            if (Session()->has('menu_as')) {
                if (Session()->get('menu_as', '') == $menuItem['slug']) {
                    $active = 'active';
                }
            }

            $tree .= '<li class="' . $nav_class . ' ' . $active . '"><a '.$target.' href="' . url($url) . '" class="' . $link_class . '">' . strtoupper($menuItem['name']) . '</a>';

            if (!empty($menuItem['children'])) {
                $tree .= $this->makeTree($menuItem['children'], 'menu-content', '');
            }

            $tree .= '</li>';
        }

        return $tree . '</ul>';
    }

    public function compose2($menu_type_id,$department) {
        $menu = ng_menu::where('display', 1)
                    ->where('ng_menu_type_id', $menu_type_id)
                    ->orderBy('ordering', 'asc')
                    ->get()
                    ->toArray();
                    
        if ($menu) {
            $menu = $this->createMenu2($menu,$department);
        }

        return $menu;
    }

    function createMenu2($data,$department) {
        foreach ($data as $row) {
            $menu[$row['id']] = $row;
        }

        $addedAsChildren = array();

        foreach ($menu as $id => &$menuItem) { // note that we use a reference so we don't duplicate the array
            if (!empty($menuItem['parent']) && $menuItem['parent'] != 0) {
                if (!array_key_exists($menuItem['parent'], $menu)) {
                    unset($menu[$id]);
                } else {
                    $addedAsChildren[] = $id; // it should be removed from root, but we'll do that later

                    if (!isset($menu[$menuItem['parent']]['children'])) {
                        $menu[$menuItem['parent']]['children'] = array($menuItem['id'] => &$menuItem); // & means we use the REFERENCE
                    } else {
                        $menu[$menuItem['parent']]['children'][$menuItem['id']] = &$menuItem; // & means we use the REFERENCE
                    }
                }
            }
            // unset($menuItem['parent']); // we don't need parent any more                
        }

        unset($menuItem); // unset the reference

        foreach ($addedAsChildren as $itemID) {
            unset($menu[$itemID]); // remove it from root so it's only in the ['children'] subarray
        }

        return $this->makeTree2($menu,$department);
    }

    function makeTree2($menu,$department, $class = 'navbar-nav ml-auto', $attribute = '') {
        $tree = '<ul  class="' . $class . '" ' . $attribute . '>';
        $component_types = [1 => 'article', 'news', 'facilities', 'gallery', 'contact', 'module', 'external Link'];
        foreach ($menu as $id => $menuItem) {
            $link_class = '';
            $nav_class = '';
            $active = '';
            
            $component_type = array_key_exists($menuItem['component_type'],$component_types)? $component_types[$menuItem['component_type']] : '';
            $url = $department.'/category/'.$menuItem['slug'].'.html';
            $nav_class = 'nav-item';
            $div = '';
            if (!empty($menuItem['children'])) {
                $link_class = 'nav-link parent';
            }
            $link_class = 'nav-link';
            if($menuItem['slug'] == 'home'){
                $url = $department;
            }elseif(ng_menu::where('parent', '=', $id)->first()) {
                // $child = ng_menu::where('parent', '=', $id)->orderBy('id','desc')->first();
                $url = $department.'/category/'.$menuItem['slug'].'.html';
            }elseif($menuItem['parent'] != 0){
                $nav_class = '';
                $link_class = 'menu-sub';
            }
            $icon = !empty($menuItem['icon']) ? $menuItem['icon'] : 'fa fa-th-list';
            $div = '<div class="d-block text-lg-center"><i class="'. $icon .'" aria-hidden="true"></i>' . $menuItem['name'] . '</div>';
            
            $target = '';
            if($menuItem['component_type'] == 8){
                $url = $menuItem['component_link'];
                $target = 'target="_blank"';
            }

            if (Session()->has('menu_as')) {
                if (Session()->get('menu_as', '') == $menuItem['slug']) {
                    $active = 'active';
                }
            }

            $tree .= '<li class="' . $nav_class . ' ' . $active . '"><a '.$target.' href="' . url($url) . '" class="' . $link_class . '">'.$div.'</a>';

            if (!empty($menuItem['children'])) {
                // $tree .= $this->makeTree($menuItem['children'], 'menu-content', '');
            }

            $tree .= '</li>';
        }

        return $tree . '</ul>';
    }

    public function composeProfile($menu_type_id) {
        $datas = ng_menu::where('display', 1)
                    ->where('ng_menu_type_id', $menu_type_id)
                    ->orderBy('ordering', 'asc')
                    ->whereHas('parents',function($builder) use($menu_type_id){
                        $builder->where('ng_menu_type_id', $menu_type_id)
                            ->where('component_type',1);
                    })
                    ->where('component_type',1)
                    ->get();

        if ($datas) {
            $datas = $this->makeTreeProfile($datas);
        }

        return $datas;
    }

    function makeTreeProfile($datas, $class = 'nav flex-column navbar-nav mr-auto', $attribute = '') {
        $tree = '<ul  class="' . $class . '" ' . $attribute . '>';
        foreach ($datas as $data) {
            $nav_class = 'nav-item text-center';
            $link_class = 'nav-link';
            $active = '';
            
            $url = 'category/'.$data->slug.'.html';
            if (Session()->has('menu_profile')) {
                if (Session()->get('menu_profile', '') == $data->slug) {
                    $active = 'active';
                }
            }
            $tree .= '<li class="' . $nav_class . '">';
            $tree .= '<a href="' . url($url) . '" class="' . $link_class . ' ' . $active . '">' . ucwords(strtolower($data->name)) . '</a>';
            $tree .= '</li>';
        }

        return $tree . '</ul>';
    }

    public function composeProfile2($menu_type_id,$department) {
        $datas = ng_menu::where('display', 1)
                    ->where('ng_menu_type_id', $menu_type_id)
                    ->orderBy('ordering', 'asc')
                    ->whereHas('parents',function($builder) use($menu_type_id){
                        $builder->where('ng_menu_type_id', $menu_type_id)
                            ->where('component_type',1);
                    })
                    ->where('component_type',1)
                    ->get();

        if ($datas) {
            $datas = $this->makeTreeProfile2($datas,$department);
        }

        return $datas;
    }

    function makeTreeProfile2($datas,$department, $class = 'nav flex-column navbar-nav mr-auto', $attribute = '') {
        $tree = '<ul  class="' . $class . '" ' . $attribute . '>';
        foreach ($datas as $data) {
            $nav_class = 'nav-item text-center';
            $link_class = 'nav-link';
            $active = '';
            
            $url = $department.'/category/'.$data->slug.'.html';
            if (Session()->has('menu_profile')) {
                if (Session()->get('menu_profile', '') == $data->slug) {
                    $active = 'active';
                }
            }
            $tree .= '<li class="' . $nav_class . '">';
            $tree .= '<a href="' . url($url) . '" class="' . $link_class . ' ' . $active . '">' . ucwords(strtolower($data->name)) . '</a>';
            $tree .= '</li>';
        }

        return $tree . '</ul>';
    }

    public function getSegment() {
        return array(Request::segment(1), Request::segment(2));
    }
}
