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
}
