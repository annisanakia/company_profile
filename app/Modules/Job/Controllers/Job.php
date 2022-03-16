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

    public function store(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $data = $this->model->create($input);
            
            if($data){
                $groups = $request->input('groups_id');
                $status = $request->input('status');
                $add_priv = $request->input('add_priv');
                $edit_priv = $request->input('edit_priv');
                $remove_priv = $request->input('remove_priv');
    
                $aclMode = new \Models\acl;
                foreach ($groups as $key => $n) {
                    $param = array(
                        'groups_id' => $n,
                        'job_id' => $data->id,
                        'add_priv' => $add_priv[$n],
                        'edit_priv' => $edit_priv[$n],
                        'remove_priv' => $remove_priv[$n]
                    );
                    if ($status[$key] != 'disabled'){
                        $aclMode->create($param);
                    }
                }
            }

            return Redirect::route(($this->controller_mutiple != '' ? strtolower($this->controller_mutiple) : strtolower($this->url_path)) . '.index');
        }
        return Redirect::route(($this->controller_mutiple != '' ? strtolower($this->controller_mutiple) : strtolower($this->url_path)) . '.create')
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

        $content = array('title_form' => 'Edit data', 'data' => $data, 'user_group' => $temp);

        $action[] = array('name' => 'Simpan', 'type' => 'submit', 'url' => '#', 'class' => 'orange-button', 'img' => 'assets/images/templates/save-page.png');
        if ($this->priv['delete_priv'])
            $action[] = array('name' => 'Hapus', 'url' => strtolower($this->controller_name) . '/delete/' . $id, 'class' => 'red-button', 'attr' => 'ng-click=confirm($event)', 'img' => 'assets/images/templates/delete-page-red.png');
        $action[] = array('name' => 'Batal', 'url' => strtolower($this->controller_name), 'class' => 'green-button', 'img' => 'assets/images/templates/cancel-page.png');

        $this->setAction($action);
        $content['actions'] = $this->actions;

        return View($this->controller_name . '::edit', $content);
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $input = request()->all();
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $data = $this->model->find($id);
            $data->code = $request->input('code');
            $data->name = $request->input('name');
            $data->parent = $request->input('parent');
            $data->ordering = $request->input('ordering');
            $data->display = $request->input('display');
            $data->menu_type_id = $request->input('menu_type_id');
            $data->icon = $request->input('icon');
            $data->icon_2 = $request->input('icon_2');
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

            return Redirect::route(strtolower($this->controller_name) . '.index', $id);
        }
        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }
}