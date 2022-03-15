<?php

namespace Lib\core;

use Illuminate\Contracts\View\View;
use Models\job;
use Models\user_group;
use Illuminate\Support\Facades\Auth;
use Request;

class menuComposer {
    public function compose() {
        $this->user = Auth::user();
        $job = '';

        if (Auth::check()) {
            $user_group = user_group::select(['groups_id'])->where('users_id', '=', $this->user->getAttributes()['id'])->get();
            $this->user_groups = array();
            foreach ($user_group as $ug) {
                $this->user_groups[] = $ug->groups_id;
            }

            $job = job::whereHas('acl', function($builder) {
                                $builder->where('groups_id', Session()->get('group_as', ''));
                                //$builder->whereIn('groups_id', $this->user_groups);
                                //$builder->where('groups_id', $this->user->getAttributes()['user_group_id']);
                            })
                            ->where('display', 1)
                            ->where('menu_type_id', 1)
                            ->orderBy('ordering', 'asc')
                            ->get()->toArray();
            if ($job) {
                $job = $this->createMenu($job);
            }
        }
        return $job;
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

    function makeTree($menu, $class = 'nav flex-column', $attribute = '') {
        $tree = '<ul  class="' . $class . '" ' . $attribute . '>';
        foreach ($menu as $id => $menuItem) {
            $arrow = '';
            $link_class = '';
            $nav_class = '';
            $active = '';
            
            $class_sub = 'menu-title';
            $url = $menuItem['code'];
            $nav_class = 'nav-item';
            if (!empty($menuItem['children'])) {
                $link_class = 'nav-link parent';
                $arrow = '<span class="arrow float-right"></span>';
            } else {
                $link_class = 'nav-link';
                if (job::where('parent', '=', $id)->first()) {
                    $url = 'blank/' . $menuItem['code'];
                }elseif($menuItem['parent'] != 0){
                    $nav_class = '';
                    $link_class = 'menu-sub';
                }
            }

            if (Session()->has('menu_as')) {
                if (Session()->get('menu_as', '') == $menuItem['code']) {
                    $active = 'active';
                }
            }

            $icon = !empty($menuItem['icon']) ? $menuItem['icon'] : 'fa fa-th-list';

            $tree .= '<li class="' . $nav_class .'"><a href="' . url($url) . '" class="' . $link_class . ' ' . $active . '"><i class="' . $icon . '"></i> <span class="'.$class_sub.'">' . $menuItem['name'] . '</span> ' . $arrow . '</a>';

            if (!empty($menuItem['children'])) {
                $tree .= $this->makeTree($menuItem['children'], 'menu-content', '');
            }

            $tree .= '</li>';
        }

        return $tree . '</ul>';
    }

    public function compose2() {
        $this->user = Auth::user();
        $job = '';
        $code = Request::segment(1) != 'blank' ? Request::segment(1) : Request::segment(2);
        if (Auth::check()) {
            $user_group = user_group::select(['groups_id'])->where('users_id', '=', $this->user->getAttributes()['id'])->get();
            $this->user_groups = array();
            foreach ($user_group as $ug) {
                $this->user_groups[] = $ug->groups_id;
            }

            $parent = job::select(['*'])->where('code', '=', strtolower($code))->first();

            if ($parent) {
                if ($parent->menu_type_id != 1) {
                    $type = $parent->parents->menu_type_id;
                    $parent = $parent->parents;
                    while ($type != 1) {
                        $parent = $parent->parents;
                        $type = $parent->menu_type_id;
                    }
                }

                $job = job::with('childrenRecursive')
                                ->whereHas('acl', function($builder) {
                                    $builder->where('groups_id', Session()->get('group_as', ''));
                                })
                                ->where('parent', $parent->id)
                                ->where('display', 1)
                                ->where('menu_type_id', 2)
                                ->orderBy('ordering', 'asc')
                                ->get()->toArray();

                $job = $this->makeTree2($job);
            }
        }

        return $job;
    }

    function makeTree2($menu, $class = 'nav navbar-nav page-top-menu', $attribute = '') {
        if (count($menu) > 0) {
            $tree = '<ul  class="' . $class . '" ' . $attribute . '>';
            foreach ($menu as $id => $menuItem) {
                $arrow = '';
                $link_class = '';
                $li_class = '';
                $link_attr = '';
                if (!empty($menuItem['children_recursive'])) {
                    $url = '#';
                    $link_class = 'dropdown-toggle';
                    $link_attr = 'data-toggle="dropdown"';
                    $li_class = 'dropdown';
                } else {
                    $url = $menuItem['code'];
                    //$link_class = 'ajaxify nav-link';
                }

                $icon = '';
                if (\Route::current()->getAction()) {
                    if (\Route::current()->getAction()['prefix'] == $url) {
                        $li_class .= ' active';
                    }
                }

                $tree .= '<li class="' . $li_class . '"><a href="' . url($url) . '" class="' . $link_class . '" ' . $link_attr . '><i class="' . $icon . '"></i> <span class="title">' . trans('say.' . $menuItem['name']) . '</span> ' . $arrow . '</a>';

                if (!empty($menuItem['children_recursive'])) {
                    $tree .= $this->makeTree2($menuItem['children_recursive'], 'dropdown-menu', '');
                }

                $tree .= '</li>';
            }

            return $tree . '</ul>';
        } else {
            return '';
        }
    }

    public function getSegment() {
        return array(Request::segment(1), Request::segment(2));
    }
}
