<?php

namespace Lib\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Models\job as jobModel;
use Models\acl as aclModel;
use Models\user_group;
use Illuminate\Support\Facades\Auth;
use View;
use Lib\core\globalTools;

class RESTful extends Controller
{

    protected $model;
    protected $controller_name;
    protected $controller_mutiple;
    protected $max_row;
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
            $this->priv['publish_priv'] = false;
            $this->setMaxRow(50);
            $globalTools = new globalTools();

            $this->view_path = $this->view_path != '' ? $this->view_path : $this->controller_name;
            $this->url_path = $this->url_path != '' ? $this->url_path : $this->controller_name;

            $grup_as = Session()->get('group_as', '');
            $job = jobModel::select(['id', 'icon', 'name'])
                ->where('code', '=', $this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($controller_name))
                ->whereHas('acl', function ($builder) use ($grup_as) {
                    $builder->where('groups_id', $grup_as);
                })
                ->first();

            Session()->put('menu_as', strtolower($controller_name));

            if (!Session()->has('group_as')) {
                Redirect::to('/')->send();
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

        if (Input::has('max_row')) {
            $this->setMaxRow($request->input('max_row'));
        }

        $this->filter_string = http_build_query(Input::all());

        if ($this->priv['add_priv'])
            $this->actions[] = array('name' => 'Tambah Data', 'url' => ($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->controller_name)) . '/create', 'class' => 'orange-button add-data', 'icon' => 'far fa-plus-square', 'attr'=>'data-toggle=modal data-target=#addModal data-target2=#container-add');
        if ($this->priv['delete_priv'])
            $this->actions[] = array('name' => 'Hapus', 'type' => 'button', 'url' => ($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->controller_name)) . '/delete_row', 'class' => 'red-button delete-row', 'icon' => 'far fa-trash-alt');

        $url_xls = '#';
        if ($this->enable_xls) {
            $url_xls = ($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '/getListAsXls?' . $this->filter_string;
        }

        $url_pdf = '#';
        if ($this->enable_pdf) {
            $url_pdf = ($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '/getListAsPdf?' . $this->filter_string;
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
        $with['param'] = Input::all();

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
                foreach ($filters as $key => $value) {
                    $exclude = array('_token', 'controller_name');
                    if ($value != '' && !in_array($key, $exclude)) {
                        if (array_key_exists($key, $tables)) {
                            if ($tables[$key]->getType()->getName() == 'string' || $tables[$key]->getType()->getName() == 'text') {
                                $data->where($key, 'LIKE', '%' . $value . '%');
                            } elseif ($tables[$key]->getType()->getName() == 'date' || $tables[$key]->getType()->getName() == 'time') {
                                if ($key == 'start') {
                                    $data->where($key, '>=', $value);
                                }
                                if ($key == 'end') {
                                    $data->where($key, '<=', $value);
                                }
                            } else {
                                $data->where($key, '=', $value);
                            }
                        }
                    }
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

    public function create(Request $request)
    {

        $publish = $this->has_task('group_access_publish');

        $content = array('title_form' => $this->create_title != '' ? $this->create_title : 'Tambah data', 'subtitle_form' => '', 'publish' => $publish);
        $action[] = array('name' => 'Simpan', 'type' => 'submit', 'url' => '#', 'class' => 'orange-button', 'img' => 'assets/images/templates/save-page.png');
        $action[] = array('name' => 'Batal', 'type' => 'button', 'attr'=>'data-dismiss=modal', 'class' => 'green-button', 'img' => 'assets/images/templates/cancel-page.png');
        $this->setAction($action);
        $content['actions'] = $this->actions;

        return view($this->view_path . '::' . $this->create_view_path, $content);
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $this->model->create($input);
            return json_decode(true);
        }
        return Redirect::route(($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function edit($id)
    {

        $publish = $this->has_task('group_access_publish');
        $data = $this->model->find($id);
        if (is_null($data)) {
            return Redirect::route(($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '.index');
        }
        $content = array('title_form' => $this->edit_title != '' ? $this->edit_title : 'Edit data', 'subtitle_form' => '', 'data' => $data, 'publish' => $publish);

        $action[] = array('name' => 'Simpan', 'type' => 'submit', 'url' => '#', 'class' => 'orange-button', 'img' => 'assets/images/templates/save-page.png');
        if ($this->priv['delete_priv'])
            $action[] = array('name' => 'Hapus', 'url' => ($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '/delete/' . $id, 'class' => 'red-button', 'attr' => 'ng-click=confirm($event)', 'img' => 'assets/images/templates/delete-page-red.png');
        $action[] = array('name' => 'Batal', 'url' => ($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)), 'class' => 'green-button', 'img' => 'assets/images/templates/cancel-page.png');

        $this->setAction($action);
        $content['actions'] = $this->actions;

        return View($this->view_path . '::' . $this->edit_view_path, $content);
    }

    public function detail($id)
    {
        $data = $this->model->find($id);
        if (is_null($data)) {
            return Redirect::route(($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '.index');
        }
        $content = array('title_form' => $this->edit_title != '' ? $this->edit_title : 'Detail data', 'subtitle_form' => '', 'data' => $data);

        if ($this->priv['delete_priv'])
            $action[] = array('name' => 'Hapus', 'url' => ($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '/delete/' . $id, 'class' => 'red-button', 'attr' => 'ng-click=confirm($event)', 'img' => 'assets/images/templates/delete-page-red.png');
        $action[] = array('name' => 'Batal', 'url' => ($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)), 'class' => 'green-button', 'img' => 'assets/images/templates/cancel-page.png');

        $this->setAction($action);
        $content['actions'] = $this->actions;

        return View($this->view_path . '::' . $this->detail_view_path, $content);
    }

    public function update(Request $request, $id)
    {
        $input = Input::all();
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $data = $this->model->find($id);
            $data->update($input);
            return json_decode(true);
        }
        return Redirect::route(($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '.edit', $id)
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
        return Redirect::route(($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '.index');
    }

    public function delete_row(Request $request)
    {
        if (Input::has('select_row')) {
            if ($this->priv['delete_priv']) {
                $select_row = $request->input('select_row');
                $this->model->whereIn('id', $select_row)->delete();
            }
        }
    }

    public function copy_row(\Illuminate\Http\Request $request)
    {
        $with = ['title_form' => 'Copy data', 'subtitle_form' => ''];

        $data = [];
        if (Input::has('select_row')) {
            $data = $this->model->whereIn('id', $request->input('select_row'))
                ->get();
        }

        $action[] = array('name' => 'Simpan', 'type' => 'submit', 'url' => '#', 'class' => 'orange-button', 'img' => 'assets/images/templates/save-page.png');
        $action[] = array('name' => 'Batal', 'url' => ($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)), 'class' => 'green-button', 'img' => 'assets/images/templates/cancel-page.png');

        $this->setAction($action);
        $with['actions'] = $this->actions;

        $with['datas'] = $data;

        return view($this->view_path . '::copyRow', $with);
    }

    public function storeCopy(\Illuminate\Http\Request $request)
    {
        $input = Input::all();

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

        return Redirect::route(($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '.index');
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
        $filters = NULL;
        if (Input::has('filter')) {
            if (\Session::has('filter')) {
                if (array_key_exists('controller_name', \Session::get('filter'))) {
                    if (\Session::get('filter')['controller_name'] != $this->controller_name) {
                        if (!$request->ajax()) {
                            \Session::forget('filter');
                        }

                        \Session::put('filter', $request->input('filter'));
                        \Session::put('filter.controller_name', $this->controller_name);
                        $filters = \Session::get('filter');
                    } else {
                        $temps = [];
                        foreach (\Session::get('filter') as $key => $s) {
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

                        \Session::put('filter', $temps);
                        \Session::put('filter.controller_name', $this->controller_name);
                        $filters = \Session::get('filter');
                    }
                } else {
                    \Session::put('filter', $request->input('filter'));
                    \Session::put('filter.controller_name', $this->controller_name);
                    $filters = \Session::get('filter');
                }
            } else {
                \Session::put('filter', $request->input('filter'));
                \Session::put('filter.controller_name', $this->controller_name);
                $filters = \Session::get('filter');
            }
        } else {
            if (\Session::has('filter')) {
                if (array_key_exists('controller_name', \Session::get('filter'))) {
                    if (\Session::get('filter')['controller_name'] == $this->controller_name) {
                        $filters = \Session::get('filter');
                    } else {
                        \Session::forget('filter');
                    }
                } else {
                    \Session::forget('filter');
                }
            }
        }
        return $filters;
    }
}