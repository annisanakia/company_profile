<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

class Dashboard extends Controller {

    protected $controller_name;
    protected $view_path;
    protected $cms;
    protected $max_row;
    protected $max_row2;
    protected $department;

    public function __construct()
    {
        $this->controller_name = 'Dashboard';
        $this->view_path = 'Dashboard';
        $this->cms = new \Lib\cms\cms();
        $this->max_row = 9;
        $this->max_row2 = 6;

        $globalTools = new \Lib\core\globalTools();

        view::share('url_image', '');
        view::share('globalTools', $globalTools);
        try {
            parent::getHost();
        } catch (\Exception $e) { }
    }

    public function index(Request $request)
    {
        Session()->put('menu_as', 'dashboard');

        $menu = \Models\menu::where('slug','dashboard')
                ->where('display', 1)
                ->first();
        
        if($menu){
            $with = [];
            $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
            return view($this->controller_name . '::index', $with);
        }
        return response()->view('errors.unauthorized');
    }

    public function category($category, Request $request){
        $menu = \Models\menu::where('slug',$category)
                ->where('display', 1)
                ->first();
        if(isset($menu->parents->slug)){
            Session()->put('menu_as', $menu->parents->slug);
        }else{
            Session()->put('menu_as', $category);
        }

        if(!$menu){
            return response()->view('errors.unauthorized');
        }

        $data = null;
        $with['menu'] = $menu;

        if($menu->component_link != ''){
            return $this->getViewsComponentId($with,$menu);
        }else{
            return $this->getViewsComponentType($with,$menu,$request);
        }
    }

    public function getViewsComponentId($with,$menu){
        $component_type = $menu->component_type;
        if($component_type == 1){
            //1=>profile
            $data = \Models\article::where('type',1)
                        ->where('display',1)
                        ->find($menu->component_link);

            if($data){
                Session()->put('menu_profile', $menu->slug);
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website
                $with['data'] = $data;
                return view($this->view_path . '::profile', $with);
            }
        }elseif($component_type == 2){
            //2=>news
            $data = \Models\article::where('type',2)
                        ->where('display',1)
                        ->find($menu->component_link);

            if($data){
                $with['data'] = $data;
                $date = getDateSlug($data->date);
                return redirect('read/news/'.$date.$data->slug.'.html');
            }
        }elseif($component_type == 3){
            //3=>events
            $data = \Models\article::where('type',3)
                        ->where('display',1)
                        ->find($menu->component_link);

            if($data){
                $with['data'] = $data;
                $date = getDateSlug($data->date);
                return redirect('read/events/'.$date.$data->slug.'.html');
            }
        }elseif($component_type == 4){
            //achievement
            $data = \Models\ng_achievement::find($menu->component_link);

            if($data){
                $with['data'] = $data;
                $date = getDateSlug($data->date);
                return redirect('read/achiev/'.$date.$data->slug.'.html');
            }
        }elseif($component_type == 5){
            //facility
            $data = \Models\ng_gallery::whereHas('ng_gallery_category',function($builder){
                            $builder->where('code','fcy');
                        })
                        ->where('display',1)
                        ->find($menu->component_link);

            if($data){
                $with['data'] = $data;
                $date = getDateSlug($data->date);
                return redirect('read/facilities/'.$date.$data->slug.'.html');
            }
        }elseif($component_type == 6){
            //gallery
            $data = \Models\ng_gallery::whereHas('ng_gallery_category',function($builder){
                            $builder->where('code','gly');
                        })
                        ->where('display',1)
                        ->find($menu->component_link);

            if($data && $data->ng_gallery_detail_one){
                $with['data'] = $data;
                $date = getDateSlug($data->date);
                return redirect('read/gallery/'.$date.$data->slug.'/'.$data->ng_gallery_detail_one->slug.'.html');
            }
        }

        return response()->view('errors.unauthorized');
    }

    public function getViewsComponentType($with,$menu,$request){
        $component_type = $menu->component_type;
        if($component_type == 1){
            //1=>profile
            if($menu->child){
                return redirect('category/' . $menu->child->slug . '.html');
            }
        }elseif($component_type == 2){
            //2=>news
            $datas = \Models\article::where('type',2)
                        ->where('display',1)
                        ->orderBy('date', 'desc')
                        ->orderBy('id', 'desc');
            $datas = $datas->paginate($this->max_row);
            $datas->chunk(100);
            if($datas){
                $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
                $with['datas'] = $datas;
                $with['param'] = Input::all();
                return view($this->view_path . '::news', $with);
            }
        }elseif($component_type == 3){
            //3=>events
            $datas = \Models\article::where('type',3)
                        ->where('display',1)
                        // kalo udh lebih dari waktu skrg event hilang
                        ->where('publish_end', '>=' , date("Y-m-d H:i:s", strtotime('+7 hours')))
                        ->orderBy('date', 'desc')
                        ->orderBy('id', 'desc');    
            // dump(date("Y-m-d H:i:s", strtotime('+7 hours')));
            $datas = $datas->paginate($this->max_row2);
            $datas->chunk(100);
            if($datas){
                $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
                $with['datas'] = $datas;
                $with['param'] = Input::all();
                return view($this->view_path . '::events', $with);
            }
        }elseif($component_type == 4){
            //4=>achievement
            $datas = \Models\ng_achievement::orderBy('date', 'desc')
                        ->orderBy('id', 'desc');
            $datas = $datas->paginate($this->max_row2);
            $datas->chunk(100);
            if($datas){
                $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
                $with['datas'] = $datas;
                $with['param'] = Input::all();
                return view($this->view_path . '::achievements', $with);
            }
        }elseif($component_type == 5){
            //5=>facility
            $datas = \Models\ng_gallery::whereHas('ng_gallery_category',function($builder){
                            $builder->where('code','fcy');
                        })
                        ->where('display',1)
                        ->orderBy('date', 'desc')
                        ->orderBy('id', 'desc');
            $datas = $datas->paginate($this->max_row2);
            $datas->chunk(100);
            if($datas){
                $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
                $with['datas'] = $datas;
                $with['param'] = Input::all();
                return view($this->view_path . '::facilities', $with);
            }
        }elseif($component_type == 6){
            //6=>gallery
            $datas = \Models\ng_gallery::whereHas('ng_gallery_category',function($builder){
                            $builder->where('code','gly');
                        })
                        ->where('display',1)
                        ->orderBy('date', 'desc')
                        ->orderBy('id', 'desc');
            $datas = $datas->paginate($this->max_row2);
            $datas->chunk(100);
            if($datas){
                $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
                $with['datas'] = $datas;
                $with['param'] = Input::all();
                return view($this->view_path . '::gallery', $with);
            }
        }
        return response()->view('errors.unauthorized');
    }

    public function read($menu,$year,$month,$slug,Request $request){
        if($menu == 'news'){
            //news
            $data = \Models\article::where('type',2)
                        ->where('display',1)
                        ->where('slug',$slug)
                        ->whereYear('date',$year)
                        ->whereMonth('date',$month)
                        ->orderBy('date', 'asc')
                        ->orderBy('id', 'asc')
                        ->first();

            if($data){
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website
                $recents = $this->cms->recentPost($data->getTable(),$data->type,$data->ng_department_id); //get Recents Post

                $with['data'] = $data;
                $with['recents'] = $recents;
                $with['next'] = $data->next()? $data->next() : $data->newData();
                $with['previous'] = $data->previous()? $data->previous() : $data->oldData();
                return view($this->view_path . '::news_detail', $with);
            }
        }elseif($menu == 'events'){
            //events
            $data = \Models\article::where('type',3)
                        ->where('display',1)
                        ->where('slug',$slug)
                        ->whereYear('date',$year)
                        ->whereMonth('date',$month)
                        ->orderBy('date', 'asc')
                        ->orderBy('id', 'asc')
                        ->first();

            if($data){
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website
                $recents = $this->cms->recentPost($data->getTable(),$data->type,$data->ng_department_id); //get Recents Post

                $with['data'] = $data;
                $with['recents'] = $recents;
                $with['next'] = $data->next()? $data->next() : $data->oldData();
                $with['previous'] = $data->previous()? $data->previous() : $data->newData();
                return view($this->view_path . '::events_detail', $with);
            }
        }elseif($menu == 'achiev' && $request->ajax()){
            //achievement
            $data = \Models\ng_achievement::where('slug',$slug)
                        ->whereYear('date',$year)
                        ->whereMonth('date',$month)
                        ->orderBy('date', 'asc')
                        ->orderBy('id', 'asc')
                        ->first();

            if($data){
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website

                $with['data'] = $data;
                $with['next'] = $data->next()? $data->next() : $data->newData();
                $with['previous'] = $data->previous()? $data->previous() : $data->oldData();
                return view($this->view_path . '::achievements_detail', $with);
            }
        }elseif($menu == 'achiev'){
            //achievement
            $datas = \Models\ng_achievement::where('slug',$slug)
                        ->whereYear('date',$year)
                        ->whereMonth('date',$month)
                        ->orderBy('date', 'asc')
                        ->orderBy('id', 'asc');
            $datas = $datas->paginate($this->max_row2);
            $datas->chunk(100);
            $data = \Models\ng_achievement::select(['id','date','slug'])
                        ->where('slug',$slug)
                        ->whereYear('date',$year)
                        ->whereMonth('date',$month)
                        ->orderBy('date', 'asc')
                        ->orderBy('id', 'asc')
                        ->first();

            if($data){
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website

                $with['datas'] = $datas;
                $with['data_active'] = $data;
                $with['param'] = Input::all();
                return view($this->view_path . '::achievements', $with);
            }
        }elseif($menu == 'facilities' && $request->ajax()){
            //facilities
            $data = \Models\ng_gallery::whereHas('ng_gallery_category',function($builder){
                            $builder->where('code','fcy');
                        })
                        ->where('slug',$slug)
                        ->whereYear('date',$year)
                        ->whereMonth('date',$month)
                        ->orderBy('date', 'asc')
                        ->orderBy('id', 'asc')
                        ->first();

            if($data){
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website

                $with['data'] = $data;
                $with['next'] = $data->next()? $data->next() : $data->newData();
                $with['previous'] = $data->previous()? $data->previous() : $data->oldData();
                return view($this->view_path . '::facilities_detail', $with);
            }
        }elseif($menu == 'facilities'){
            //facilities
            $datas = \Models\ng_gallery::whereHas('ng_gallery_category',function($builder){
                            $builder->where('code','fcy');
                        })
                        ->where('slug',$slug)
                        ->whereYear('date',$year)
                        ->whereMonth('date',$month)
                        ->orderBy('date', 'asc')
                        ->orderBy('id', 'asc');
            $datas = $datas->paginate($this->max_row2);
            $datas->chunk(100);
            $data = \Models\ng_gallery::select(['id','date','slug'])
                        ->whereHas('ng_gallery_category',function($builder){
                            $builder->where('code','fcy');
                        })
                        ->where('slug',$slug)
                        ->whereYear('date',$year)
                        ->whereMonth('date',$month)
                        ->orderBy('date', 'asc')
                        ->orderBy('id', 'asc')
                        ->first();

            if($data){
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website

                $with['datas'] = $datas;
                $with['data_active'] = $data;
                $with['param'] = Input::all();
                return view($this->view_path . '::facilities', $with);
            }
        }
        return response()->view('errors.unauthorized');
    }

    public function read_subslug($menu,$year,$month,$slug,$subslug,Request $request){
        if($menu == 'gallery' && $request->ajax()){
            //gallery
            $data = \Models\ng_gallery_detail::where('slug',$subslug)
                        ->whereHas('ng_gallery',function($builder) use($year,$month,$slug){
                            $builder->where('slug',$slug)
                                ->whereYear('date',$year)
                                ->whereMonth('date',$month)
                                ->where('ng_department_id',$this->department->id)
                                ->whereHas('ng_gallery_category',function($builder){
                                    $builder->where('code','gly');
                                });
                        })
                        ->orderBy('id', 'asc')
                        ->first();
                        
            if($data){
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website

                $with['data'] = $data;
                $with['next'] = $data->next()? $data->next() : $data->newData();
                $with['previous'] = $data->previous()? $data->previous() : $data->oldData();
                return view($this->view_path . '::gallery_detail', $with);
            }
        }elseif($menu == 'gallery'){
            //gallery
            $data = \Models\ng_gallery_detail::where('slug',$subslug)
                        ->whereHas('ng_gallery',function($builder) use($year,$month,$slug){
                            $builder->where('slug',$slug)
                                ->whereYear('date',$year)
                                ->whereMonth('date',$month)
                                ->where('ng_department_id',$this->department->id)
                                ->whereHas('ng_gallery_category',function($builder){
                                    $builder->where('code','gly');
                                });
                        })
                        ->orderBy('id', 'asc')
                        ->first();

            if($data){
                $datas = \Models\ng_gallery::where('id',$data->ng_gallery_id);
                $datas = $datas->paginate($this->max_row2);
                $datas->chunk(100);
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website

                $with['datas'] = $datas;
                $with['data_active'] = $data;
                $with['param'] = Input::all();
                return view($this->view_path . '::gallery', $with);
            }
        }
        return response()->view('errors.unauthorized');
    }
}