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
                // $destinationPath = public_path('assets/images/temp');
                $destinationPath = public_path('assets/file/users');
                // dd($destinationPath);
                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }

                $image->move($destinationPath, $imagename);

                // $sftp = new \Lib\sftp\sftpLib();
                // $s = $sftp->connect();
                // $s->put($destinationPath . $imagename, file_get_contents($destinationPath . '/' . $imagename));

                // if (file_exists($destinationPath . '/' . $imagename)) {
                //     unlink($destinationPath . '/' . $imagename);
                // }

                // $host = $s->getAdapter()->getRemotePath();
                $path = $request->getSchemeAndHttpHost() . '/assets/file/users/' . $imagename;
                // dd($path);
                $filename = $path;
            }
            $data = $this->model->create($input);
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
            return json_decode(true);
        }
        return Redirect::route(($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
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
        
        $content = array('title_form' => 'Edit data', 'data' => $data, 'user_group' => $temp);

        return View($this->controller_name . '::edit', $content);
    }

    public function update(Request $request, $id)
    {
        $input = Request()->all();

        $rules = [
            'ng_department_id' => 'required',
            'name' => 'required',
            'email' => 'email|nullable',
            'phone' => 'numeric|nullable'
        ];
    
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
                // $destinationPath = public_path('assets/images/temp');
                $destinationPath = public_path('assets/file/users');
                // dd($destinationPath);
                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }
                
                $image->move($destinationPath, $imagename);

                // $sftp = new \Lib\sftp\sftpLib();
                // $s = $sftp->connect();
                // $s->put($destinationPath . $imagename, file_get_contents($destinationPath . '/' . $imagename));

                // if (file_exists($destinationPath . '/' . $imagename)) {
                //     unlink($destinationPath . '/' . $imagename);
                // }

                // $host = $s->getAdapter()->getRemotePath();
                $path = 'assets/file/users/' . $imagename;
                // dd($path);
                $filename = $path;
            }
            $data = $this->model->find($id);
            if ($request->input('password') == '') {
                unset($input['password']);
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
            return json_decode(true);
        }
        return Redirect::route(($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '.edit', $id)
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
            \Models\user_group::where('users_id',$data->id)
                    ->delete();
            \Models\users_photo::where('users_id',$data->id)
                    ->delete();
            $data->delete();
        }
        return Redirect::route(($this->controller_mutiple != '' ? $this->controller_mutiple : strtolower($this->url_path)) . '.index');
    }
}
