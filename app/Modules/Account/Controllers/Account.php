<?php

namespace App\Modules\Account\Controllers;

use App\Models\User as userModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Validator;
use File;

class Account extends RESTful {

    public function __construct() {
        $model = new userModel;
        $controller_name = 'Account';

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

    public function update(Request $request, $id)
    {
        $input = Request()->all();

        $rules = array(
            'name' => 'required',
            'email' => 'email',
            'phone' => 'numeric',
            'email' => 'email|nullable',
            'phone' => 'numeric|nullable'
        );
    
        $customMessages = [
            'required' => 'This field required.',
            'username.unique' => 'Username has been taken.',
            'email' => 'Invalid Email Address.'
        ];

        $validation = Validator::make($input, $rules, $customMessages);
        
        if ($validation->passes()) {
            unset($input['filename']);
            if ($request->hasFile('filename')) {
                $this->validate($request, [
                    'file' => 'max:10240',
                    'extension' => 'in:jpeg,png,jpg'
                ]);

                $image = $request->file('filename');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/file/users');

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }
                
                $image->move($destinationPath, $imagename);
                $path = 'assets/file/users/' . $imagename;
                $filename = $path;
            }

            $data = $this->model->find($id);
            if ($request['password'] == '') {
                unset($input['password']);
            }else{
                $input['password'] = \Hash::make($input['password']);
            }
            
            $data->update($input);
            if(isset($filename)){
                $users_photo = \Models\users_photo::where('users_id',$data->id)
                        ->first();
                if(!$users_photo){
                    $users_photo = new \Models\users_photo();
                }
                $users_photo->users_id = $data->id;
                $users_photo->filename = $filename;
                $users_photo->save();
            }

            return Redirect::route(strtolower($this->controller_name) . '.index', $id);
        }
        return Redirect::route(strtolower($this->controller_name) . '.index', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }
}
