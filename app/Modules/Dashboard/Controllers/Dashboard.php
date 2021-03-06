<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class Dashboard extends Controller {

    protected $controller_name;
    protected $view_path;
    protected $cms;
    protected $max_row;
    protected $max_row2;
    protected $department;
    protected $company;

    public function __construct()
    {
        $this->controller_name = 'Dashboard';
        $this->view_path = 'Dashboard';
        $this->cms = new \Lib\cms\cms();
        $this->max_row = 9;
        $this->max_row2 = 6;

        $globalTools = new \Lib\core\globalTools();
        $this->company = \Models\company::where('code','HSP')->first();

        view::share('url_image', '');
        view::share('company', $this->company);
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
            $main_headers = \Models\company_header::where('code','main_header')
                    ->where('is_publish',1)
                    ->orderBy('sequence')
                    ->get();
            $company_qualitys = \Models\company_quality::where('is_publish',1)
                    ->orderBy('sequence')
                    ->get();
            $products = \Models\product::where('is_publish',1)
                    ->orderBy('sequence')
                    ->limit(4)
                    ->get();
            $customers = \Models\customer::where('is_publish',1)
                    ->orderBy('id','desc')
                    ->get();
            $testimonis = \Models\testimoni::where('is_publish',1)
                    ->orderBy('sequence')
                    ->get();
            $articles = \Models\article::where('is_publish',1)
                    ->orderBy('date','desc')
                    ->limit(3)
                    ->get();

            $with['main_headers'] = $main_headers;
            $with['company_qualitys'] = $company_qualitys;
            $with['products'] = $products;
            $with['customers'] = $customers;
            $with['testimonis'] = $testimonis;
            $with['articles'] = $articles;
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
        $data = $this->company;

        if($component_type == 1){
            //1=>profile
            $company_teams = \Models\company_team::where('company_id',$data->id)
                    ->where('is_publish',1)
                    ->orderBy('sequence')
                    ->get();
            if($data){
                $profile_header = \Models\company_header::where('code','profile_header')
                        ->where('is_publish',1)
                        ->orderBy('sequence')
                        ->first();
                $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
                $with['data'] = $data;
                $with['profile_header'] = $profile_header;
                $with['company_teams'] = $company_teams;
                $with['param'] = request()->all();
                return view($this->view_path . '::profile', $with);
            }
        }elseif($component_type == 2){
            //2=>Article
            $datas = \Models\article::where('company_id',$data->id)
                    ->where('is_publish',1)
                    ->orderBy('date','desc')
                    ->orderBy('id', 'desc');
            $datas = $datas->paginate($this->max_row);
            $datas->chunk(100);
            if($datas){
                $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
                $with['datas'] = $datas;
                $with['param'] = request()->all();
                return view($this->view_path . '::article', $with);
            }
        }elseif($component_type == 3){
            //3=>product
            $datas = \Models\product::where('is_publish',1)
                        ->orderBy('sequence', 'asc')
                        ->orderBy('id', 'desc');
            $datas = $datas->paginate(8);
            $datas->chunk(100);
            if($datas){
                $product_header = \Models\company_header::where('code','product_header')
                        ->where('is_publish',1)
                        ->orderBy('sequence')
                        ->first();
                $company_qualitys = \Models\company_quality::where('is_publish',1)
                        ->orderBy('sequence')
                        ->get();
                $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
                $with['datas'] = $datas;
                $with['product_header'] = $product_header;
                $with['company_qualitys'] = $company_qualitys;
                $with['param'] = request()->all();
                return view($this->view_path . '::product', $with);
            }
        }elseif($component_type == 4){
            //4=>career
            $datas = \Models\career::where('is_publish',1)
                        ->orderBy('start_date', 'desc')
                        ->orderBy('id', 'desc');
            $datas = $datas->paginate($this->max_row);
            $datas->chunk(100);
            if($datas){
                $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
                $with['datas'] = $datas;
                $with['param'] = request()->all();
                return view($this->view_path . '::career', $with);
            }
        }elseif($component_type == 5){
            //5=>contact
            $data = $this->company;
            if($data){
                $this->cms->countViewsModule($menu->getTable(),$menu->id); //hitung visitor website
                $with['data'] = $data;
                $with['param'] = request()->all();
                return view($this->view_path . '::contact', $with);
            }
        }
        return response()->view('errors.unauthorized');
    }

    public function read($menu,$year,$month,$slug,Request $request){
        if($menu == 'article'){
            //article
            $data = \Models\article::where('is_publish',1)
                        ->where('slug',$slug)
                        ->whereYear('date',$year)
                        ->whereMonth('date',$month)
                        ->orderBy('date', 'asc')
                        ->orderBy('id', 'asc')
                        ->first();

            if($data){
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website
                $recents = $this->cms->recentPost($data->getTable(),$data->id,$data->company_id); //get Recents Post

                $with['data'] = $data;
                $with['recents'] = $recents;
                $with['next'] = $data->next()? $data->next() : $data->newData();
                $with['previous'] = $data->previous()? $data->previous() : $data->oldData();
                return view($this->view_path . '::article_detail', $with);
            }
        }elseif($menu == 'career' && $request->ajax()){
            //achievement
            $data = \Models\career::where('slug',$slug)
                        ->whereYear('start_date',$year)
                        ->whereMonth('start_date',$month)
                        ->orderBy('start_date', 'asc')
                        ->orderBy('id', 'asc')
                        ->first();

            if($data){
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website

                $with['data'] = $data;
                $with['next'] = $data->next()? $data->next() : $data->newData();
                $with['previous'] = $data->previous()? $data->previous() : $data->oldData();
                return view($this->view_path . '::career_detail', $with);
            }
        }elseif($menu == 'career'){
            //achievement
            $datas = \Models\career::where('slug',$slug)
                        ->whereYear('start_date',$year)
                        ->whereMonth('start_date',$month)
                        ->orderBy('start_date', 'asc')
                        ->orderBy('id', 'asc');
            $datas = $datas->paginate($this->max_row2);
            $datas->chunk(100);
            $data = \Models\career::select(['id','start_date','slug'])
                        ->where('slug',$slug)
                        ->whereYear('start_date',$year)
                        ->whereMonth('start_date',$month)
                        ->orderBy('start_date', 'asc')
                        ->orderBy('id', 'asc')
                        ->first();

            if($data){
                $this->cms->countViewsModule($data->getTable(),$data->id); //hitung visitor website

                $with['datas'] = $datas;
                $with['data_active'] = $data;
                $with['param'] = request()->all();
                return view($this->view_path . '::career', $with);
            }
        }
        return response()->view('errors.unauthorized');
    }

    public function storeContact()
    {
        $input = Request()->all();
        $input['date'] = date('Y-m-d');
        $model = new \Models\contact();
        $validation = $model->validate($input);

        if ($validation->passes()) {
            $data = $model->create($input);

            return Redirect::route(strtolower($this->controller_name) . '.category', 'contact');
        }
        return Redirect::route(strtolower($this->controller_name) . '.category', 'contact')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }
}