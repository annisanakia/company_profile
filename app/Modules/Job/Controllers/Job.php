<?php

namespace App\Modules\Job\Controllers;

use Models\job as jobModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;

class Job extends RESTful
{

    public function __construct()
    {
        $model = new jobModel;
        $controller_name = 'Job';
        $this->enable_xls_button = false;
        $this->enable_pdf_button = false;

        parent::__construct($model, $controller_name);
    }

    public function create()
    {
        $groups = \Models\groups::all();
        $temp = array();
        foreach ($groups as $ug) {
            $temp[] = array('groups_id' => $ug->id, 'add_priv' => 0, 'edit_priv' => 0, 'remove_priv' => 0, 'name' => $ug->name, 'status' => 'disabled');
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
            $acl = \Models\acl::where('job_id', '=', $id)
                    ->where('groups_id', '=', $ug->id)
                    ->first();
            if ($acl) {
                $temp[] = array('groups_id' => $ug->id, 'add_priv' => (int) $acl->add_priv, 'edit_priv' => (int) $acl->edit_priv, 'remove_priv' => (int) $acl->remove_priv, 'name' => $ug->name, 'status' => '');
            } else {
                $temp[] = array('groups_id' => $ug->id, 'add_priv' => 0, 'edit_priv' => 0, 'remove_priv' => 0, 'name' => $ug->name, 'status' => 'disabled');
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

    public function detail($id) {
        $data = $this->model->find($id);
        if (is_null($data)) {
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }

        $groups = \Models\groups::all();
        $temp = array();
        foreach ($groups as $ug) {
            $acl = \Models\acl::where('job_id', '=', $id)
                    ->where('groups_id', '=', $ug->id)
                    ->first();
            if ($acl) {
                $temp[] = array('groups_id' => $ug->id, 'add_priv' => (int) $acl->add_priv, 'edit_priv' => (int) $acl->edit_priv, 'remove_priv' => (int) $acl->remove_priv, 'name' => $ug->name, 'status' => '');
            } else {
                $temp[] = array('groups_id' => $ug->id, 'add_priv' => 0, 'edit_priv' => 0, 'remove_priv' => 0, 'name' => $ug->name, 'status' => 'disabled');
            }
        }

        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'btn btn-click btn-grey responsive');
        if ($this->priv['delete_priv'])
            $action[] = array('name' => 'Delete', 'url' => strtolower($this->controller_name) . '/delete/' . $id, 'class' => 'btn btn-click btn-red responsive', 'attr' => 'ng-click=confirm($event)');
        $this->setAction($action);

        $content = array('title_form' => 'Detail data', 'data' => $data, 'user_group' => $temp);
        $content['actions'] = $this->actions;
        
        return View($this->controller_name . '::detail', $content);
        parent::edit($id);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $input = $this->getParams($request->all());
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $data = $this->model->create($input);
            $id = $data->id;

            $groups = $request->input('groups_id');
            $status = $request->input('status');
            $add_priv = $request->input('add_priv');
            $edit_priv = $request->input('edit_priv');
            $remove_priv = $request->input('remove_priv');

            $aclMode = new \Models\acl;
            foreach ($groups as $key => $n) {
                $param = array(
                    'groups_id' => $n,
                    'job_id' => $id,
                    'add_priv' => $add_priv[$n],
                    'edit_priv' => $edit_priv[$n],
                    'remove_priv' => $remove_priv[$n]
                );

                if ($status[$key] == 'disabled') {
                    $acl = $aclMode->where('job_id', '=', $id)
                            ->where('groups_id', '=', $n);
                    if ($acl) {
                        $acl->delete();
                    }
                } else {
                    $acl = $aclMode->where('job_id', '=', $id)
                            ->where('groups_id', '=', $n)
                            ->first();
                    if ($acl) {
                        $acl->update($param);
                    } else {
                        $aclMode->create($param);
                    }
                }
            }
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
        return Redirect::route(strtolower($this->controller_name) . '.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function update(\Illuminate\Http\Request $request, $id) {
        $input = request()->all();
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $data = $this->model->find($id);
            $data->code = $request->input('code');
            $data->name = $request->input('name');
            $data->parent = $request->input('parent');
            $data->ordering = $request->input('ordering');
            $data->display = $request->input('display');
            $data->icon = $request->input('icon');            
            $data->save();

            $groups = $request->input('groups_id');
            $status = $request->input('status');
            $add_priv = $request->input('add_priv');
            $edit_priv = $request->input('edit_priv');
            $remove_priv = $request->input('remove_priv');

            $aclMode = new \Models\acl;
            foreach ($groups as $key => $n) {
                $param = array(
                    'groups_id' => $n,
                    'job_id' => $id,
                    'add_priv' => $add_priv[$n],
                    'edit_priv' => $edit_priv[$n],
                    'remove_priv' => $remove_priv[$n]
                );

                if ($status[$key] == 'disabled') {
                    $acl = $aclMode->where('job_id', '=', $id)
                            ->where('groups_id', '=', $n);
                    if ($acl) {
                        $acl->delete();
                    }
                } else {
                    $acl = $aclMode->where('job_id', '=', $id)
                            ->where('groups_id', '=', $n)
                            ->first();
                    if ($acl) {
                        $acl->update($param);
                    } else {
                        $aclMode->create($param);
                    }
                }
            }

            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors.');
    }

}
