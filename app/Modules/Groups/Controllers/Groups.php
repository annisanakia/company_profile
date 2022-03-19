<?php

namespace App\Modules\Groups\Controllers;

use Models\groups as groupsModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class Groups extends RESTful {

    public function __construct() {
        $model = new groupsModel;
        $controller_name = 'Groups';

        $this->enable_xls_button = false;
        $this->enable_pdf_button = false;        

        parent::__construct($model, $controller_name);
    }
}
