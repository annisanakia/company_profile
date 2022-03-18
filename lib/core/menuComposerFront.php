<?php

namespace Lib\core;

use Illuminate\Contracts\View\View;
use Models\ng_menu;
use Models\ng_article;
use Illuminate\Support\Facades\Auth;
use Request;

class menuComposerFront {
    public function compose() {
        $menu = ng_menu::where('display', 1)
                    // ->where('parent',0)
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

    function makeTree($menu, $class = 'navbar-nav', $attribute = '') {
        $tree = '<ul  class="' . $class . '" ' . $attribute . '>';
        $component_types = getComponentType();
        foreach ($menu as $id => $menuItem) {
            $link_class = '';
            $nav_class = '';
            $active = '';
            
            $component_type = array_key_exists($menuItem['component_type'],$component_types)? $component_types[$menuItem['component_type']] : '';
            $url = 'category/'.$menuItem['slug'].'.html';
            $nav_class = 'nav-item';
            if (!empty($menuItem['children'])){
                $nav_class = 'nav-item dropdown';
                $link_class = 'nav-link dropdown-toggle';
            } else {
                $link_class = 'nav-link';
                if($menuItem['slug'] == 'dashboard'){
                    $url = '';
                }elseif(ng_menu::where('parent', '=', $id)->first()) {
                    $url = 'category/'.$menuItem['slug'].'.html';
                }elseif($menuItem['parent'] != 0){
                    $nav_class = '';
                    $link_class = 'menu-sub';
                }
            }
            $target = '';
            if($menuItem['component_type'] == 6){ //eksternal link
                $url = $menuItem['component_link'];
                $target = 'target="_blank"';
            }

            if (Session()->has('menu_as')) {
                if (Session()->get('menu_as', '') == $menuItem['slug']) {
                    $active = 'active';
                }
            }

            if (!empty($menuItem['children'])) {
                $tree .= '<li class="' . $nav_class . ' ' . $active . '">
                    <a class="' . $link_class . '" href="' . url($url) . '"
                    id="navbarDropdownMenuLink" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">' . $menuItem['name'] . '</a>';
                $tree .= $this->makeTreeSubMenu($menuItem['children'], 'menu-content', '');
            }else{
                $tree .= '<li class="' . $nav_class . ' ' . $active . '"><a '.$target.' href="' . url($url) . '" class="' . $link_class . '">' . $menuItem['name'] . '</a>';
            }

            $tree .= '</li>';
        }

        return $tree . '</ul>';
    }

    function makeTreeSubMenu($menu, $class = 'navbar-nav', $attribute = '') {
        $tree = '<div class="dropdown-menu">';
        $component_types = getComponentType();
        foreach ($menu as $id => $menuItem) {
            $link_class = 'dropdown-item';
            $active = '';
            
            $component_type = array_key_exists($menuItem['component_type'],$component_types)? $component_types[$menuItem['component_type']] : '';
            $url = 'category/'.$menuItem['slug'].'.html';

            if (Session()->has('menu_as')) {
                if (Session()->get('menu_as', '') == $menuItem['slug']) {
                    $active = 'active';
                }
            }
            
            $target = '';
            if($menuItem['component_type'] == 6){ //eksternal link
                $url = $menuItem['component_link'];
                $target = 'target="_blank"';
            }

            $tree .= '<a '.$target.' href="' . url($url) . '" class="' . $link_class . '">' . $menuItem['name'] . '</a>';
        }

        return $tree . '</div>';
    }

    public function getSegment() {
        return array(Request::segment(1), Request::segment(2));
    }
}
