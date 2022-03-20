<?php

namespace App\Modules\Company_profile\Controllers;

use Models\company as companyModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Validator;
use File;

class Company_profile extends RESTful {

    public function __construct() {
        $model = new companyModel;
        $controller_name = 'Company_profile';

        $this->enable_xls_button = false;
        $this->enable_pdf_button = false;        

        parent::__construct($model, $controller_name);
    }

    public function index(Request $request){
        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'btn btn-click btn-grey responsive');
        $action[] = array('name' => 'Save', 'type' => 'submit', 'url' => '#', 'class' => 'btn btn-click btn-green responsive');
        $this->setAction($action);

        $with['actions'] = $this->actions;
        $with['data'] = $this->user;
        return View($this->controller_name . '::index', $with);
    }
}
