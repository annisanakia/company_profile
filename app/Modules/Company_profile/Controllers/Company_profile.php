<?php

namespace App\Modules\Company_profile\Controllers;

use Models\company as companyModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Validator;
use File;

class Company_profile extends RESTful {

    protected $company;

    public function __construct() {
        $model = new companyModel;
        $controller_name = 'Company_profile';

        $this->company = \Models\company::where('code','HSP')->first();

        $this->enable_xls_button = false;
        $this->enable_pdf_button = false;        

        parent::__construct($model, $controller_name);
    }

    public function index(Request $request){
        $with['data'] = $this->company;
        return View($this->controller_name . '::index', $with);
    }

    public function company_information(){
        $with['data'] = $this->company;
        $action = [];
        if ($this->priv['edit_priv'])
            $action[] = array('name' => 'Save', 'type' => 'button', 'class' => 'btn btn-click btn-green responsive submit');
        $this->setAction($action);

        $with['actions'] = $this->actions;
        $with['data'] = $this->company;
        return View($this->controller_name . '::company_information', $with);
    }

    public function detailInformationSave(){
        $input = Request()->all();
        $data = $this->company;
        $validation = $this->model->validate($input);
        
        if ($validation->passes()) {

            unset($input['logo']);
            if (request()->hasFile('logo')) {
                $this->validate(request(), [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = request()->file('logo');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/company');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }
                
                $image->move($destinationPath, $imagename);
                $path = 'assets/file/company/' . $imagename;
                $input['logo'] = $path;
            }

            unset($input['logo_white']);
            if (request()->hasFile('logo_white')) {
                $this->validate(request(), [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = request()->file('logo_white');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/company');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }
                
                $image->move($destinationPath, $imagename);
                $path = 'assets/file/company/' . $imagename;
                $input['logo_white'] = $path;
            }
            $data->update($input);
            \Session::flash('msg', '<b>Save Success</b>');
            return Redirect::route(strtolower($this->controller_name) . '.company_information');
        }
        return Redirect::route(strtolower($this->controller_name) . '.company_information')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function company_team()
    {
        $data = $this->company;

        $datas = \Models\company_team::select(['*'])
            ->where('company_id', $data->id)
            ->orderBy('sequence');

        $this->setMaxRow(50);
        if (request()->has('max_row')) {
            $this->setMaxRow(request()->input('max_row'));
        }

        $datas = $datas->paginate($this->max_row);

        $with['data'] = $data;
        $with['datas'] = $datas;
        $with['param'] = request()->all();
        return view($this->controller_name . '::company_team', $with);
    }

    public function editTeam()
    {
        $action = [];
        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name).'/company_team', 'class' => 'btn btn-click btn-grey responsive btn-cancel');
        if ($this->priv['edit_priv'])
            $action[] = array('name' => 'Save', 'type' => 'button', 'class' => 'btn btn-click btn-green responsive submit');
        $this->setAction($action);

        $with['data'] = \Models\company_team::find(Request()->id);
        $with['actions'] = $this->actions;
        return view($this->controller_name . '::editTeam', $with);
    }

    public function saveTeam()
    {
        $input = Request()->all();
        $model = new \Models\company_team();
        $validation = $model->validate($input);

        $data = \Models\company_team::find(Request()->id);
        if ($validation->passes()) {
            unset($input['photo']);
            if (request()->hasFile('photo')) {
                $this->validate(request(), [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = request()->file('photo');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/company');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }
                
                $image->move($destinationPath, $imagename);
                $path = 'assets/file/company/' . $imagename;
                $input['photo'] = $path;
            }
            $input['company_id'] = $this->company->id;
            if($data){
                $data->update($input);
            }else{
                $data = $model->create($input);
            }
            \Session::flash('msg', '<b>Save Success</b>');
            return Redirect::route(strtolower($this->controller_name) . '.company_team');
        }
        return Redirect::route(strtolower($this->controller_name) . '.editTeam', ['id'=>Request()->id])
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function deleteTeam()
    {
        if ($this->priv['delete_priv']) {
            $data = \Models\company_team::find(Request()->id);
            if($data){
                $data->delete();
            }
        }
        return Redirect::route(strtolower($this->controller_name) . '.company_team');
    }

    public function header_config()
    {
        $data = $this->company;

        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name).'/company_team', 'class' => 'btn btn-click btn-grey responsive btn-cancel');
        if ($this->priv['edit_priv'])
            $action[] = array('name' => 'Save', 'type' => 'button', 'class' => 'btn btn-click btn-green responsive submit');

        $with['data'] = $data;
        $with['actions'] = $action;
        return view($this->controller_name . '::header_config', $with);
    }

    public function customer()
    {
        $data = $this->company;

        $customers = \Models\customer::select(['*'])
            ->where('company_id', $data->id)
            ->get();

        $testimonis = \Models\testimoni::select(['*'])
            ->where('company_id', $data->id)
            ->orderBy('sequence','ASC')
            ->get();

        $with['data'] = $data;
        $with['customers'] = $customers;
        $with['testimonis'] = $testimonis;
        $with['param'] = request()->all();
        return view($this->controller_name . '::customer', $with);
    }

    public function editCustomer()
    {
        $action = [];
        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name).'/customer', 'class' => 'btn btn-click btn-grey responsive btn-cancel');
        if ($this->priv['edit_priv'])
            $action[] = array('name' => 'Save', 'type' => 'button', 'class' => 'btn btn-click btn-green responsive submit');
        $this->setAction($action);

        $with['data'] = \Models\customer::find(Request()->id);
        $with['actions'] = $this->actions;
        return view($this->controller_name . '::editCustomer', $with);
    }

    public function saveCustomer()
    {
        $input = Request()->all();
        $model = new \Models\customer();
        $validation = $model->validate($input);

        $data = \Models\customer::find(Request()->id);
        if ($validation->passes()) {
            unset($input['photo']);
            if (request()->hasFile('photo')) {
                $this->validate(request(), [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = request()->file('photo');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/company');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }
                
                $image->move($destinationPath, $imagename);
                $path = 'assets/file/company/' . $imagename;
                $input['photo'] = $path;
            }
            $input['company_id'] = $this->company->id;
            if($data){
                $data->update($input);
            }else{
                $data = $model->create($input);
            }
            \Session::flash('msg', '<b>Save Success</b>');
            return Redirect::route(strtolower($this->controller_name) . '.customer');
        }
        return Redirect::route(strtolower($this->controller_name) . '.editCustomer', ['id'=>Request()->id])
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function deleteCustomer()
    {
        if ($this->priv['delete_priv']) {
            $data = \Models\customer::find(Request()->id);
            if($data){
                $data->delete();
            }
        }
        return Redirect::route(strtolower($this->controller_name) . '.customer');
    }

    public function editTestimoni()
    {
        $action = [];
        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name).'/customer', 'class' => 'btn btn-click btn-grey responsive btn-cancel');
        if ($this->priv['edit_priv'])
            $action[] = array('name' => 'Save', 'type' => 'button', 'class' => 'btn btn-click btn-green responsive submit');
        $this->setAction($action);

        $with['data'] = \Models\testimoni::find(Request()->id);
        $with['actions'] = $this->actions;
        return view($this->controller_name . '::editTestimoni', $with);
    }

    public function saveTestimoni()
    {
        $input = Request()->all();
        $model = new \Models\testimoni();
        $validation = $model->validate($input);

        $data = \Models\testimoni::find(Request()->id);
        if ($validation->passes()) {
            unset($input['photo']);
            if (request()->hasFile('photo')) {
                $this->validate(request(), [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = request()->file('photo');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/company');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }
                
                $image->move($destinationPath, $imagename);
                $path = 'assets/file/company/' . $imagename;
                $input['photo'] = $path;
            }
            $input['company_id'] = $this->company->id;
            if($data){
                $data->update($input);
            }else{
                $data = $model->create($input);
            }
            \Session::flash('msg', '<b>Save Success</b>');
            return Redirect::route(strtolower($this->controller_name) . '.customer');
        }
        return Redirect::route(strtolower($this->controller_name) . '.editTestimoni', ['id'=>Request()->id])
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }
}
