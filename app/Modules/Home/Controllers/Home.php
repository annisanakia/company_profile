<?php

namespace App\Modules\Home\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Home extends Controller {

    protected $controller_name;

    public function __construct()
    {
        $this->middleware('auth');
        $this->controller_name = 'Home';
        $globalTools = new \Lib\core\globalTools();
        view::share('globalTools', $globalTools);

        try {
            parent::getHost();
        } catch (\Exception $e) { }
    }

    public function index(Request $request)
    {
        Session()->put('menu_as', 'home');
        $with = [];
        return view($this->controller_name . '::index', $with);
    }

}
