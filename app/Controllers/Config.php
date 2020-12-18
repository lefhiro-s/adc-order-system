<?php 

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\ConfigModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\IncomingRequest;


class Config extends BaseController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    const OK_SUCCESS           =  0;
    const ERROR_UNKNOW         = -1;
    const ERROR_PASS_INCORRECT = -2;
    const ERROR_USER_INVALID   = -3;
    const ERROR_AUTH_NO_VALID  = -4;
    const ERROR_EMAIL_NO_VALID = -5;


    public function edit(){
        $users       = new UserModel();
        $config      = new ConfigModel();
        $data['user']        = reset($users->where('id_user', $this->session)->find());
        $data['config']      = $config->findAll();
        $data['path']        = $this->path;
        $data['title']       = 'Editar configuración';

        if($data['user']['type'] != 2 ){
            return redirect()->to(base_url());
        }

        return view('configuration/edit', $data);
    }

    public function update (){

        $requestBody   = (array) json_decode($this->request->getBody());
        $users         = new UserModel();
        $user_session  = reset($users->where('id_user', $this->session)->find());

        if($user_session['type'] != 2){
            return json_encode([
                "code"    => self::ERROR_AUTH_NO_VALID, 
                "message" => "No tiene permisos para editar el usuario", 
                "data"    => ""
            ]); 
        }

        foreach ($requestBody as $key_request => $body) {
            $config = new ConfigModel();
            $config->set(['value' => $body]);
            $config->where('name', $key_request);
            $config->update();
        }

        return json_encode([
            "code"    => self::OK_SUCCESS,
            "message" => "La configuración ha sido actualizada",
            "data"    => $requestBody
        ]);

    }

}