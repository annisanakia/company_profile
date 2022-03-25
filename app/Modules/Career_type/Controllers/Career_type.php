<?php

namespace App\Modules\Career_type\Controllers;

use Models\career_type as typeModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class Career_type extends RESTful {

    public function __construct() {
        $model = new typeModel;
        $controller_name = 'Career_type';

        $this->enable_xls_button = false;
        $this->enable_pdf_button = false;        

        parent::__construct($model, $controller_name);
    }
}
