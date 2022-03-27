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

    public function filterHeaderContent(Request $request) {
        $globalTools = new \Lib\core\globalTools();

        $content_type = $request->input('content_type');
        $id = $request->input('id');

        $target = 'object_id';
        if ($request->has('target')) {
            $target = $request->input('target');
        }

        $blank = false;
        if ($request->has('blank')) {
            $blank = $request->input('blank');
        }

        $datas = [];
        if($content_type == 1){
            //article
            $datas = \Models\article::orderBy('name', 'asc')
                        ->orderBy('date', 'desc')
                        ->get();
        }elseif($content_type == 2){
            //product
            $datas = \Models\product::orderBy('name', 'asc')
                        ->orderBy('sequence', 'asc')
                        ->get();
        }elseif($content_type == 3){
            //career
            $datas = \Models\career::orderBy('name', 'asc')
                        ->orderBy('start_date', 'desc')
                        ->get();
        }
        
        $components[''] = '-- Choose Component --';
        foreach($datas as $row){
            $components[$row->id] = $row->name;
        }

        return $globalTools->renderListArray($components, $target, $id, $blank);
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
        $main_headers = \Models\company_header::where('code','main_header')
                ->orderBy('sequence')
                ->get();
        $profile_header = \Models\company_header::where('code','profile_header')
                ->orderBy('sequence')
                ->first();
        $product_header = \Models\company_header::where('code','product_header')
                ->orderBy('sequence')
                ->first();
                
        $with['main_headers'] = $main_headers;
        $with['profile_header'] = $profile_header;
        $with['product_header'] = $product_header;
        return view($this->controller_name . '::header_config', $with);
    }

    public function editHeader()
    {
        $action = [];
        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name).'/header_config', 'class' => 'btn btn-click btn-grey responsive btn-cancel');
        if ($this->priv['edit_priv'])
            $action[] = array('name' => 'Save', 'type' => 'button', 'class' => 'btn btn-click btn-green responsive submit');
        $this->setAction($action);

        $data = \Models\company_header::find(Request()->id);
        $object = isset($data->object)? $data->object : '';
        $content_type = isset($data)? 'custom' : '';
        if($object == 'article'){
            $content_type = 1;
        }elseif($object == 'product'){
            $content_type = 2;
        }elseif($object == 'career'){
            $content_type = 3;
        }

        $with['code'] = request()->code;
        $with['data'] = $data;
        $with['content_type'] = $content_type;
        $with['actions'] = $this->actions;
        return view($this->controller_name . '::editHeader', $with);
    }

    public function validationCustomHeader($input){
        $rules = array(
            'is_publish' => 'required',
            'name' => 'required'
        );

        $validation = Validator::make($input, $rules);

        return $validation;
    }

    public function validationHeader($input){
        $rules = array(
            'is_publish' => 'required',
            'content_type' => 'required',
            'object_id' => 'required'
        );
    
        $customMessages = [
            'object_id.required' => 'This Content Name field required.'
        ];

        $validation = Validator::make($input, $rules, $customMessages);

        return $validation;
    }

    public function saveHeader()
    {
        $model = new \Models\company_header();

        $input = [
            'code' => request()->code,
            'sequence'=> request()->sequence,
            'is_publish'=> request()->is_publish
        ];
        $content_type = request()->content_type;
        if($content_type == 'custom'){
            $input['name'] = request()->name;
            $input['desc'] = request()->desc;
            $validation = $this->validationCustomHeader($input);
        }else{
            $input['content_type'] = request()->content_type;
            $input['object'] = array_key_exists($content_type,getContentType())? strtolower(getContentType()[$content_type]) : '';
            $input['object_id'] = request()->object_id;
            $validation = $this->validationHeader($input);
        }
        
        $data = \Models\company_header::find(Request()->id);
        if ($validation->passes()) {
            unset($input['photo']);
            if (request()->hasFile('photo')) {
                $this->validate(request(), [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = request()->file('photo');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/header');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }
                
                $image->move($destinationPath, $imagename);
                $path = 'assets/file/header/' . $imagename;
                $input['photo'] = $path;
            }
            $input['company_id'] = $this->company->id;
            if($data){
                $data->update($input);
            }else{
                $data = $model->create($input);
            }
            \Session::flash('msg', '<b>Save Success</b>');
            return Redirect::route(strtolower($this->controller_name) . '.header_config');
        }
        return Redirect::route(strtolower($this->controller_name) . '.editHeader', ['id'=>Request()->id])
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function deleteHeader()
    {
        if ($this->priv['delete_priv']) {
            $data = \Models\company_header::find(Request()->id);
            if($data){
                $data->delete();
            }
        }
        return Redirect::route(strtolower($this->controller_name) . '.header_config');
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

    public function deleteTestimoni()
    {
        if ($this->priv['delete_priv']) {
            $data = \Models\testimoni::find(Request()->id);
            if($data){
                $data->delete();
            }
        }
        return Redirect::route(strtolower($this->controller_name) . '.customer');
    }

    public function other_information()
    {
        $data = $this->company;

        $company_qualitys = \Models\company_quality::select(['*'])
            ->where('company_id', $data->id)
            ->orderBy('sequence','ASC')
            ->get();
            
        $with['data'] = $data;
        $with['company_qualitys'] = $company_qualitys;
        $with['param'] = request()->all();
        return view($this->controller_name . '::other_information', $with);
    }

    public function editQuality()
    {
        $action = [];
        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name).'/other_information', 'class' => 'btn btn-click btn-grey responsive btn-cancel');
        if ($this->priv['edit_priv'])
            $action[] = array('name' => 'Save', 'type' => 'button', 'class' => 'btn btn-click btn-green responsive submit');
        $this->setAction($action);

        $with['data'] = \Models\company_quality::find(Request()->id);
        $with['actions'] = $this->actions;
        return view($this->controller_name . '::editQuality', $with);
    }

    public function saveQuality()
    {
        $input = Request()->all();
        $model = new \Models\company_quality();
        $validation = $model->validate($input);

        $data = \Models\company_quality::find(Request()->id);
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
            return Redirect::route(strtolower($this->controller_name) . '.other_information');
        }
        return Redirect::route(strtolower($this->controller_name) . '.editQuality', ['id'=>Request()->id])
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function deleteQuality()
    {
        if ($this->priv['delete_priv']) {
            $data = \Models\company_quality::find(Request()->id);
            if($data){
                $data->delete();
            }
        }
        return Redirect::route(strtolower($this->controller_name) . '.other_information');
    }
}
