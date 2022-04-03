<?php

namespace App\Modules\Contact\Controllers;

use Models\contact as contactModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use File;

class Contact extends RESTful {

    public function __construct() {
        $model = new contactModel;
        $controller_name = 'Contact';

        $this->enable_xls_button = false;
        $this->enable_pdf_button = false;        

        parent::__construct($model, $controller_name);
    }

    public function beforeIndex($data)
    {
        $action = [];
        if ($this->priv['delete_priv'])
            $action[] = array('name' => 'Delete', 'type' => 'button', 'url' => strtolower($this->controller_name) . '/delete_row', 'class' => 'red-button delete-row delete-data', 'icon' => 'far fa-trash-alt');
         
        $this->setAction($action);
    }
}
