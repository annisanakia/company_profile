<?php

namespace App\Modules\Article\Controllers;

use Models\article as articleModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use File;

class Article extends RESTful {

    protected $company;

    public function __construct() {
        $model = new articleModel;
        $controller_name = 'Article';

        $this->company = \Models\company::where('code','HSP')->first();

        $this->enable_xls_button = false;
        $this->enable_pdf_button = false;        

        parent::__construct($model, $controller_name);
    }

    public function beforeIndex($data)
    {
        $data->where('company_id',$this->company->id);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $input = Request()->all();
        $input['company_id'] = $this->company->id;
        $input['slug'] = str_replace(' ', '-', strtolower(Request()->name));
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            unset($input['photo']);
            if ($request->hasFile('photo')) {
                $this->validate($request, [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = $request->file('photo');
                $imagename = date('ymd') . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/article');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }

                $image->move($destinationPath, $imagename);
                $path = $request->getSchemeAndHttpHost() . '/assets/file/article/' . $imagename;
                $input['photo'] = $path;
            }
            
            $data = $this->model->create($input);

            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
        return Redirect::route(strtolower($this->controller_name) . '.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $input = Request()->all();
        $input['slug'] = str_replace(' ', '-', strtolower(Request()->name));
        $validation = $this->model->validate($input);
        
        $data = $this->model->find($id);
        if ($validation->passes() && $data) {
            unset($input['photo']);
            if ($request->hasFile('photo')) {
                $this->validate($request, [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = $request->file('photo');
                $imagename = date('ymd') . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/article');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }

                $image->move($destinationPath, $imagename);
                $path = $request->getSchemeAndHttpHost() . '/assets/file/article/' . $imagename;
                $input['photo'] = $path;
            }

            $data->update($input);
            
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }
}
