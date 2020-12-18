<?php 

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\UserOfficeModel;
use App\Models\OfficeModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\OrderTypesEnum;
use CodeIgniter\HTTP\IncomingRequest;


class Office extends BaseController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    const OK_SUCCESS           =  0;
    const ERROR_UNKNOW         = -1;
    const ERROR_PASS_INCORRECT = -2;
    const ERROR_USER_INVALID   = -3;
    const ERROR_AUTH_NO_VALID  = -4;
    const ERROR_EMAIL_NO_VALID = -5;

    public function update (){

        $requestBody   = json_decode($this->request->getBody());
        $userOffices   = new UserOfficeModel();
        $users         = new UserModel();
        $userOffices   = $userOffices->where('id_t_user', $requestBody->id_user)->find();
        $user_session  = reset($users->where('id_user', $this->session)->find());

        if($user_session['type'] != 2){
            return json_encode([
                "code"    => self::ERROR_AUTH_NO_VALID, 
                "message" => "No tiene permisos para editar el usuario", 
                "data"    => ""
            ]); 
        }

        $user_office['id_t_user'] = $requestBody->id_user;
        $offices                  = $requestBody->offices_ids; 

        foreach ($offices as $id_office => $insert_office) {
            $user_office['id_t_office'] = $id_office;
            $exist = false;

            if(in_array($id_office, array_column($userOffices, "id_t_office"))){
                $exist = true;
            }

            if($insert_office && $exist == false){
                $this->insert($user_office);
            }elseif(!$insert_office && $exist){
                $this->delete($user_office);
            }

        }

        return json_encode([
            "code"    => self::OK_SUCCESS,
            "message" => "Las oficinas del usuario se han actualizado existosamente!",
            "data"    => ''
        ]);


    }
    
    // Service CRUD
    public function insert($row_user_office){
        $usersOffice = new UserOfficeModel();
        $usersOffice->insert($row_user_office);
    }

    public function delete($row_user_office){
        $usersOffice = new UserOfficeModel();
        $usersOffice->where('id_t_office', $row_user_office['id_t_office']);
        $usersOffice->where('id_t_user', $row_user_office['id_t_user']);
        $usersOffice->delete();
    }

}