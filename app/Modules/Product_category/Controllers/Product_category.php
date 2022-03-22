<?php

namespace App\Modules\Product_category\Controllers;

use Models\product_category as categoryModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class Product_category extends RESTful {

    public function __construct() {
        $model = new categoryModel;
        $controller_name = 'Product_category';

        $this->enable_xls_button = false;
        $this->enable_pdf_button = false;        

        parent::__construct($model, $controller_name);
    }
}
