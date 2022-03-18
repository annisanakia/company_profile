<?php

namespace App\Modules\Ng_users\Controllers;

use App\Models\User as userModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Validator;
use File;

class Ng_users extends RESTful {

    public function __construct() {
        $model = new userModel;
        $controller_name = 'Ng_users';

        $this->enable_xls_button = false;
        $this->enable_pdf_button = false;
        $this->table_name = 'users';
        parent::__construct($model, $controller_name);
    }

    public function filter($data, $request, $table){
        if ($request->isMethod('post') || $request->isMethod('get')) {
            $schema = \DB::getDoctrineSchemaManager();
            $tables = $schema->listTableColumns($table);
            $filters = $this->getFilters($request);
            if ($filters) {
                foreach ($filters as $key => $value) {
                    $exclude = array('_token', 'controller_name');
                    if ($value != '' && !in_array($key, $exclude)) {
                        if ($key == 'department_name') {
                            $data->whereHas('ng_department', function($builder) use($value){
                                $builder->where('name', 'LIKE', '%' . $value . '%');
                            });
                        } elseif ($tables[$key]->getType()->getName() == 'string' || $tables[$key]->getType()->getName() == 'text') {
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

    public function store(Request $request)
    {
        $input = Request()->all();
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            unset($input['filename']);
            if ($request->hasFile('filename')) {
                $this->validate($request, [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = $request->file('filename');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/users');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }

                $image->move($destinationPath, $imagename);
                $path = $request->getSchemeAndHttpHost() . '/assets/file/users/' . $imagename;
                $filename = $path;
            }
            
            $input['password'] = \Hash::make($input['password']);
            $data = $this->model->create($input);
            $data->status = 1;
            $data->save();
            
            if(isset($filename)){
                $users_photo = \Models\users_photo::where('users_id',$data->id)
                        ->first();
                if(!$users_photo){
                    $users_photo = new \Models\users_photo();
                }
                $users_photo->users_id = $data->id;
                $users_photo->filename = $filename;
                $users_photo->save();
            }

            $groups = $request->input('groups_id');
            $status = $request->input('status');
            $default = $request->input('default');
            $id = $data->id;
            
            $user_group = new \Models\user_group;
            foreach ($groups as $key => $n) {
                $deff = 0;
                if($n == $default){
                    $deff = 1;
                }
                $param = array(
                    'groups_id' => $n,
                    'users_id' => $id,
                    'default' => $deff
                );
                
                if ($status[$key] == 'disabled') {
                    $acl = $user_group->where('users_id', '=', $id)
                            ->where('groups_id', '=', $n);
                    if ($acl) {
                        $acl->delete();
                    }
                } else {
                    $acl = $user_group->where('users_id', '=', $id)
                            ->where('groups_id', '=', $n)
                            ->first();
                    if ($acl) {
                        $acl->update($param);
                    } else {
                        $user_group->create($param);
                    }
                }
            }

            return Redirect::route(strtolower($this->controller_name) . '.index', $id);
        }
        return Redirect::route(strtolower($this->controller_name) . '.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function create()
    {
        $groups = \Models\groups::all();
        $temp = array();
        foreach ($groups as $ug) {
            $temp[] = array('groups_id' => $ug->id, 'name' => $ug->name, 'status' => 'disabled', 'default' => false);
        }
        
        $content = array('title_form' => $this->create_title != '' ? $this->create_title : 'Add data', 'subtitle_form' => '', 'user_group' => $temp);
        
        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'btn btn-click btn-grey responsive');
        $action[] = array('name' => 'Save', 'type' => 'submit', 'url' => '#', 'class' => 'btn btn-click btn-green responsive');
        $this->setAction($action);

        $content['actions'] = $this->actions;
        $content['data'] = null;

        return view($this->view_path . '::' . $this->create_view_path, $content);
    }

    public function edit($id) {
        $data = $this->model->find($id);
        if (is_null($data)) {
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }

        $groups = \Models\groups::all();
        $temp = array();
        foreach ($groups as $ug) {
            $acl = \Models\user_group::where('users_id', '=', $id)
                    ->where('groups_id', '=', $ug->id)
                    ->first();

            $default = false;

            if ($acl) {
                if ($acl->default == 1) {
                    $default = true;
                }
                $temp[] = array('groups_id' => $ug->id, 'name' => $ug->name, 'status' => '', 'default' => $default);
            } else {
                $temp[] = array('groups_id' => $ug->id, 'name' => $ug->name, 'status' => 'disabled', 'default' => $default);
            }
        }

        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'btn btn-click btn-grey responsive');if ($this->priv['delete_priv'])
        if ($this->priv['delete_priv'])
            $action[] = array('name' => 'Delete', 'url' => strtolower($this->controller_name) . '/delete/' . $id, 'class' => 'btn btn-click btn-red responsive', 'attr' => 'ng-click=confirm($event)');
        $action[] = array('name' => 'Save', 'type' => 'submit', 'url' => '#', 'class' => 'btn btn-click btn-green responsive');
        $this->setAction($action);
        
        $content = array('title_form' => 'Edit data', 'data' => $data, 'user_group' => $temp);
        $content['actions'] = $this->actions;

        return View($this->controller_name . '::edit', $content);
    }

    public function update(Request $request, $id)
    {
        $input = Request()->all();

        $rules = array(
            'username' => 'required|unique:users,username,' . $id . ',id,deleted_at,NULL',
            'name' => 'required',
            'email' => 'email',
            'phone' => 'numeric',
            'email' => 'email|nullable',
            'phone' => 'numeric|nullable'
        );
    
        $customMessages = [
            'required' => 'This field required.',
            'username.unique' => 'Username has been taken.',
            'email' => 'Invalid Email Address.'
        ];

        $validation = Validator::make($input, $rules, $customMessages);
        
        if ($validation->passes()) {
            unset($input['filename']);
            if ($request->hasFile('filename')) {
                $this->validate($request, [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = $request->file('filename');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/users');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }
                
                $image->move($destinationPath, $imagename);
                $path = 'assets/file/users/' . $imagename;
                $filename = $path;
            }

            $data = $this->model->find($id);
            if ($request['password'] == '') {
                unset($input['password']);
            }else{
                $input['password'] = \Hash::make($input['password']);
            }
            
            $data->update($input);
            if(isset($filename)){
                $users_photo = \Models\users_photo::where('users_id',$data->id)
                        ->first();
                if(!$users_photo){
                    $users_photo = new \Models\users_photo();
                }
                $users_photo->users_id = $data->id;
                $users_photo->filename = $filename;
                $users_photo->save();
            }
            
            $groups = $request->input('groups_id');
            $status = $request->input('status');
            $default = $request->input('default');
            
            $user_group = new \Models\user_group;
            foreach ($groups as $key => $n) {
                $deff = 0;
                if($n == $default){
                    $deff = 1;
                }
                $param = array(
                    'groups_id' => $n,
                    'users_id' => $id,
                    'default' => $deff
                );
                
                if ($status[$key] == 'disabled') {
                    $acl = $user_group->where('users_id', '=', $id)
                            ->where('groups_id', '=', $n);
                    if ($acl) {
                        $acl->delete();
                    }
                } else {
                    $acl = $user_group->where('users_id', '=', $id)
                            ->where('groups_id', '=', $n)
                            ->first();
                    if ($acl) {
                        $acl->update($param);
                    } else {
                        $user_group->create($param);
                    }
                }
            }
            return Redirect::route(strtolower($this->controller_name) . '.index', $id);
        }
        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function detail($id) {
        $data = $this->model->find($id);

        $groups = \Models\groups::all();
        $temp = array();
        foreach ($groups as $ug) {
            $acl = \Models\user_group::where('users_id', '=', $id)
                    ->where('groups_id', '=', $ug->id)
                    ->first();

            $default = false;

            if ($acl) {
                if ($acl->default == 1) {
                    $default = true;
                }
                $temp[] = array('groups_id' => $ug->id, 'name' => $ug->name, 'status' => '', 'default' => $default);
            } else {
                $temp[] = array('groups_id' => $ug->id, 'name' => $ug->name, 'status' => 'disabled', 'default' => $default);
            }
        }
        
        $content = array('title_form' => 'Detail data', 'data' => $data, 'user_group' => $temp);

        return View($this->controller_name . '::detail', $content);
    }

    public function delete($id)
    {
        if ($this->priv['delete_priv']) {
            $data = $this->model->find($id);
            if($data){
                \Models\user_group::where('users_id',$data->id)
                        ->delete();
                \Models\users_photo::where('users_id',$data->id)
                        ->delete();
                $data->delete();
            }
        }
        return Redirect::route(strtolower($this->controller_name) . '.index');
    }
}
