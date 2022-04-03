<?php

namespace Lib\core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Models\job as jobModel;
use Models\acl as aclModel;
use Illuminate\Support\Facades\Auth;
use View;
use Lib\core\globalTools;

class RESTful extends Controller
{

    protected $model;
    protected $controller_name;
    protected $max_row = 50;
    protected $user;
    protected $priv;
    protected $title = '';
    protected $create_title = '';
    protected $edit_title = '';
    protected $subtitle = '';
    protected $actions = array();
    protected $middleware_except = '';
    protected $table_name = '';
    protected $filter_string = '';
    protected $enable_xls = false;
    protected $enable_pdf = false;
    protected $enable_xls_button = true;
    protected $enable_pdf_button = true;
    protected $view_path = '';
    protected $url_path = '';
    protected $create_view_path = 'create';
    protected $edit_view_path = 'edit';
    protected $detail_view_path = 'detail';
    protected $job_id;
    protected $request = NULL;
    protected $add_param_to_custom_filters = [];

    public function __construct($model, $controller_name)
    {
        $this->middleware('auth', ['except' => $this->middleware_except]);
        $this->user = Auth::user();

        if (Auth::check()) {
            $this->model = $model;
            $this->controller_name = $controller_name;
            $this->priv['edit_priv'] = false;
            $this->priv['add_priv'] = false;
            $this->priv['delete_priv'] = false;

            $globalTools = new globalTools();

            $this->view_path = $this->view_path != '' ? $this->view_path : $this->controller_name;
            $this->url_path = $this->url_path != '' ? $this->url_path : $this->controller_name;

            $grup_as = Session()->get('group_as', '');
            $job = jobModel::select(['id', 'icon', 'name'])
                ->where('code', '=', strtolower($controller_name))
                ->whereHas('acl', function ($builder) use ($grup_as) {
                    $builder->where('groups_id', $grup_as);
                })
                ->first();

            Session()->put('menu_as', strtolower($controller_name));

            if (!Session()->has('group_as')) {
                $group_as = \Models\user_group::select(['groups_id'])
                        ->where('users_id', '=', Auth::user()->getAttributes()['id'])
                        ->where('default', '=', 1)
                        ->first();

                if($group_as){
                    request()->session()->put('group_as', $group_as->groups_id);
                }else{
                    Redirect::to('/admin')->send();
                }
            }

            if ($job) {
                $this->job_id = $job->id;
                $acl = aclModel::select('*')
                    ->where('job_id', '=', $job->id)
                    ->where('groups_id', '=', Session()->get('group_as', ''))
                    ->first();
                if ($acl) {
                    $this->priv['edit_priv'] = $acl->edit_priv;
                    $this->priv['add_priv'] = $acl->add_priv;
                    $this->priv['delete_priv'] = $acl->remove_priv;
                }

                $this->setTitle($job->name);

                view::share('icon', $job->icon != '' ? $job->icon : 'fa fa-th-list');
            }

            view::share('priv', $this->priv);
            view::share('title', $this->title);
            view::share('subtitle', $this->subtitle);
            view::share('user', $this->user);
            view::share('globalTools', $globalTools);
            view::share('controller_name', strtolower($controller_name));
            view::share('view_path', $this->view_path);
        }
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $this->request = $request;
        $request = $this->request;
        $with = $this->getList($request);

        if ($request->ajax()) {
            return view($this->view_path . '::list', $with);
        }

        return view($this->view_path . '::index', $with);
    }

    public function getList(Request $request, $start = '', $end = '')
    {
        $data = $this->model->select(['*']);

        $table = $this->table_name != '' ? $this->table_name : strtolower($this->controller_name);
        $this->filter($data, $request, $table);
        $this->order($data, $request);
        if ($request->has('max_row')) {
            $this->setMaxRow($request->input('max_row'));
        }

        $this->filter_string = http_build_query($request->all());

        if ($this->priv['add_priv'])
            $this->actions[] = array('name' => 'Add Data', 'url' => strtolower($this->controller_name) . '/create', 'class' => 'orange-button', 'icon' => 'far fa-plus-square');
        if ($this->priv['delete_priv'])
            $this->actions[] = array('name' => 'Delete', 'type' => 'button', 'url' => strtolower($this->controller_name) . '/delete_row', 'class' => 'red-button delete-row delete-data', 'icon' => 'far fa-trash-alt');

        $url_xls = '#';
        if ($this->enable_xls) {
            $url_xls = strtolower($this->url_path) . '/getListAsXls?' . $this->filter_string;
        }

        $url_pdf = '#';
        if ($this->enable_pdf) {
            $url_pdf = strtolower($this->url_path) . '/getListAsPdf?' . $this->filter_string;
        }

        if ($this->enable_xls_button) {
            $this->actions[] = array('name' => 'Export Excel', 'url' => $url_xls, 'attr' => 'target="_blank"', 'class' => 'green-button', 'img' => 'assets/images/templates/xlsx-page.png');
        }

        if ($this->enable_pdf_button) {
            $this->actions[] = array('name' => 'Export PDF', 'url' => $url_pdf, 'attr' => 'target="_blank"', 'class' => 'red-button', 'img' => 'assets/images/templates/pdf-page.png');
        }

        $this->beforeIndex($data);

        $data = $data->paginate($this->max_row);
        $data->chunk(100);

        $with['datas'] = $data;
        $with['param'] = $request->all();

        $with['actions'] = $this->actions;

        return $with;
    }

    public function beforeIndex($data)
    { }

    public function filter($data, $request, $table)
    {
        if ($request->isMethod('post') || $request->isMethod('get')) {
            $schema = \DB::getDoctrineSchemaManager();
            $tables = $schema->listTableColumns($table);
            $filters = $this->getFilters($request);
            if ($filters) {
                $newFilters = [];
                foreach ($filters as $key => $value) {
                    if ($value != '') {
                        if ($this->add_param_to_custom_filters) {
                            if (is_array($this->add_param_to_custom_filters)) {
                                if (array_key_exists($key, $this->add_param_to_custom_filters)) {
                                    $newFilters[$key] = $value;
                                }
                            }
                        }
                        if (array_key_exists($key, $tables)) {
                            if ($tables[$key]->getType()->getName() == 'string' || $tables[$key]->getType()->getName() == 'text') {
                                if($key == 'desc'){
                                    dd('aw',$value);
                                }
                                $data->where($key, 'LIKE', '%' . $value . '%');
                            } elseif ($tables[$key]->getType()->getName() == 'date' || $tables[$key]->getType()->getName() == 'time') {
                                if ($key == 'start' || $key == 'start_date') {
                                    $data->where($key, '>=', $value);
                                }
                                if ($key == 'end' || $key == 'end_date') {
                                    $data->where($key, '<=', $value);
                                }
                                if ($key == 'date') {
                                    $data->whereDate($key, $value);
                                }
                            } else {
                                $data->where($key, '=', $value);
                            }
                        } else {
                            $newFilters[$key] = $value;
                        }
                    }
                }
                /** Jika Module extend dari restfull ingin menambahkan filter pencarian
                 *  maka tidak perlu membuat method dengan nama filter (istilahnya override function) tp buat method dengan nama customFilter di Module
                 *  sehingga filter yang sudah ada di restfull tidak perlu ditulis ulang, contoh penggunaannya bisa dilihat di Module Ng_academic_cost
                 *  sehingga di method index jika membutuhkan filter tetap ditambahkan $this->filter($data, $request, 'nama_tabel') tidak perlu bikin method filter lagi; 
                 */
                if (method_exists($this, 'customFilter')) {
                    $this->customFilter($data, $newFilters);
                }
            }
        }
    }

    public function order($data, $request)
    {
        if ($request->isMethod('post') || $request->isMethod('get')) {
            if ($request->input('sort_field') != '' && $request->input('sort_type') != '') {
                $data->orderBy($request->input('sort_field'), $request->input('sort_type'));
            } else {
                $data->orderBy('id', 'desc');
            }
        }
    }

    public function create()
    {
        $content = array('title_form' => $this->create_title != '' ? $this->create_title : 'Add data', 'subtitle_form' => '');
        
        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'btn btn-click btn-grey responsive');
        $action[] = array('name' => 'Save', 'type' => 'submit', 'url' => '#', 'class' => 'btn btn-click btn-green responsive');
        $this->setAction($action);

        $content['actions'] = $this->actions;
        $content['data'] = null;

        return view($this->view_path . '::' . $this->create_view_path, $content);
    }

    public function store(Request $request)
    {
        $input = $this->getParams($request->all());
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $this->model->create($input);
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
        return Redirect::route(strtolower($this->controller_name) . '.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function edit($id)
    {
        $data = $this->model->find($id);
        if (is_null($data)) {
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
        $content = array('title_form' => $this->edit_title != '' ? $this->edit_title : 'Edit data', 'subtitle_form' => '', 'data' => $data);

        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'btn btn-click btn-grey responsive');if ($this->priv['delete_priv'])
        if ($this->priv['delete_priv'])
            $action[] = array('name' => 'Delete', 'url' => strtolower($this->controller_name) . '/delete/' . $id, 'class' => 'btn btn-click btn-red responsive', 'attr' => 'ng-click=confirm($event)');
        $action[] = array('name' => 'Save', 'type' => 'submit', 'url' => '#', 'class' => 'btn btn-click btn-green responsive');
        $this->setAction($action);

        $content['actions'] = $this->actions;

        return View($this->view_path . '::' . $this->edit_view_path, $content);
    }

    public function detail($id)
    {
        $data = $this->model->find($id);
        if (is_null($data)) {
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
        $content = array('title_form' => $this->edit_title != '' ? $this->edit_title : 'Detail data', 'subtitle_form' => '', 'data' => $data);

        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'btn btn-click btn-grey responsive');
        if ($this->priv['delete_priv'])
            $action[] = array('name' => 'Delete', 'url' => strtolower($this->controller_name) . '/delete/' . $id, 'class' => 'btn btn-click btn-red responsive', 'attr' => 'ng-click=confirm($event)');
        $this->setAction($action);
        
        $content['actions'] = $this->actions;

        return View($this->view_path . '::' . $this->detail_view_path, $content);
    }

    public function update(Request $request, $id)
    {
        $input = $this->getParams($request->all());
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $data = $this->model->find($id);
            $data->update($input);
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function delete($id)
    {
        if ($this->priv['delete_priv']) {
            $data = $this->model->find($id);
            if($data){
                $data->delete();
            }
        }
        return Redirect::route(strtolower($this->controller_name) . '.index');
    }

    public function delete_row(Request $request)
    {
        if ($request->has('select_row')) {
            if ($this->priv['delete_priv']) {
                $select_row = $request->input('select_row');
                $this->model->whereIn('id', $select_row)->delete();
            }
        }
    }

    public function copy_row(Request $request)
    {
        $with = ['title_form' => 'Copy data', 'subtitle_form' => ''];

        $data = [];
        if ($request->has('select_row')) {
            $data = $this->model->whereIn('id', $request->input('select_row'))
                ->get();
        }

        $action[] = array('name' => 'Save', 'type' => 'submit', 'url' => '#', 'class' => 'orange-button', 'img' => 'assets/images/templates/save-page.png');
        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'green-button', 'img' => 'assets/images/templates/cancel-page.png');

        $this->setAction($action);
        $with['actions'] = $this->actions;

        $with['datas'] = $data;

        return view($this->view_path . '::copyRow', $with);
    }

    public function storeCopy(Request $request)
    {
        $input = request()->all();

        unset($input['_token']);

        foreach ($input as $key => $row) {
            ${$key} = $request->input($key);
        }

        foreach (${$key} as $k => $r) {
            $data[$k] = [];
            foreach ($input as $ke => $row) {
                $data[$k][$ke] = ${$ke}[$k];
            }
            $this->model->create($data[$k]);
        }

        return Redirect::route(strtolower($this->url_path) . '.index');
    }

    function setMaxRow($max)
    {
        $this->max_row = $max;
    }

    function setTitle($title)
    {
        $this->title = $title;
    }

    function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    function setAction($action = array())
    {
        $this->actions = $action;
    }

    function setExceptMiddleware($except)
    {
        $this->middleware_except = $except;
    }

    function setTableName($table)
    {
        $this->table_name = $table;
    }

    public static function has_task($code, $dept = false)
    {
        $globalTools = new globalTools();

        return $globalTools->has_task($code, $dept);
    }

    public function getFilters(Request $request)
    {
        $filters = [];
        if ($request->has('filter')) {
            foreach ($request->input('filter') as $key => $value) {
                if (empty($value)) {
                    Session()->forget('filter.' . $key);
                }
            }
            if (Session()->has('filter')) {
                if (array_key_exists('controller_name', Session()->get('filter'))) {
                    if (Session()->get('filter')['controller_name'] != $this->controller_name) {
                        if (!$request->ajax()) {
                            Session()->forget('filter');
                        }

                        Session()->put('filter', $request->input('filter'));
                        Session()->put('filter.controller_name', $this->controller_name);
                        $filters = Session()->get('filter');
                    } else {
                        $temps = [];
                        foreach (Session()->get('filter') as $key => $s) {
                            if (in_array($key, $request->input('filter'))) {
                                $temps[$key] = $s;
                            }
                        }
                        foreach ($request->input('filter') as $f => $v) {
                            if ($request->has('department_name') && $f == 'ng_department_id') {
                                $temps['department_name'] = $request->input('department_name');
                            }
                            $temps[$f] = $v;
                        }

                        Session()->put('filter', $temps);
                        Session()->put('filter.controller_name', $this->controller_name);
                        $filters = Session()->get('filter');
                    }
                } else {
                    Session()->put('filter', $request->input('filter'));
                    Session()->put('filter.controller_name', $this->controller_name);
                    $filters = Session()->get('filter');
                }
            } else {

                Session()->put('filter', $request->input('filter'));
                Session()->put('filter.controller_name', $this->controller_name);
                $filters = Session()->get('filter');
            }
        } else {
            if (Session()->has('filter')) {
                if (array_key_exists('controller_name', Session()->get('filter'))) {
                    if (Session()->get('filter')['controller_name'] == $this->controller_name) {
                        $filters = Session()->get('filter');
                    } else {
                        Session()->forget('filter');
                    }
                } else {
                    Session()->forget('filter');
                }
            }
        }

        if (array_key_exists('controller_name', $filters)) {
            unset($filters['controller_name']);
        }
        unset($filters['_token']);
        return $filters;
    }

    public function getParams($params)
    {
        /** cara pake method ini bisa dilihat di modul ng_coa */
        if (method_exists($this, 'customInput')) {
            return $this->customInput($params);
        } else {
            return $params;
        }
    }
}