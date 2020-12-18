<?php 

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\OfficeModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\UserTypesEnum;

class User extends BaseController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    const OK_SUCCESS           =  0;
    const ERROR_UNKNOW         = -1;
    const ERROR_PASS_INCORRECT = -2;
    const ERROR_USER_INVALID   = -3;
    const ERROR_AUTH_NO_VALID  = -4;
    const ERROR_EMAIL_NO_VALID = -5;

    public function index()
	{
		$users      = new UserModel();
        $user_type  = new UserTypesEnum();
        $user_type  = $user_type::getTypesUser();
		$data['user']  = reset($users->where('id_user', $this->session)->find());
		$data['path']  = $this->path;
        $data['title'] = 'Perfil';
        $data['user']['type_name'] = $user_type[$data['user']['type']];

		return view('profile/index', $data);
    }

    public function validation()
    {
        $requestBody = json_decode($this->request->getBody());
        $users = new UserModel;
        $users = $users->findAll();

        foreach ($users as $key_user => $user) {
            // Se valida el correo se encuentre asociado a un usuario
            if(strtolower($user['email']) == $requestBody->email){

                // Se valida si el usuario esta desactivado
                if($user['type'] == 0){
                    return json_encode(['validated' => false, 'message' => 0]);
                }

                // Se valida la password se igual
                if(md5($requestBody->password) == $user['pass']){
                    
                    // Se valida si se desea recordar el correo del usuario
                    if($requestBody->remember_me){
                        setcookie("cook-remember", strtolower($user['email']), time() + (60 * 60 * 24 * 60),  '/', NULL);
                    }else{
                        setcookie("cook-remember", '', 1,  '/', NULL);
                    }

                    // Se guarda la sesión en una cookie
                    setcookie("cook-login", $user['id_user'] , time() + (60 * 60 * 24 * 5),  '/', NULL);

                    $user['last_login'] = new Time('now', $requestBody->timezone);

                    $users = $this->update($user);

                    return json_encode(['validated'=> true, 'message' => 1]);
                }
            }
        }
        return json_encode(['validated'=> false, 'message' => 2]);
    }

    public function create()
	{
        $users = new UserModel();
        $user_type  = new UserTypesEnum();
        $user_type  = $user_type::getTypesUser();
        $data['user_type'] = $user_type;
		$data['user']  = reset($users->where('id_user', $this->session)->find());
		$data['path']  = $this->path;
        $data['title'] = 'Crear Usuario';

        if($data['user']['type'] != 2 ){
            return redirect()->to(base_url());
        }

		return view('create_user', $data);
		
    }
    
    public function list()
	{
        $users      = new UserModel();
        $user_type  = new UserTypesEnum();
        $user_type  = $user_type::getTypesUser();
        $data_user  = $users->findAll() ;
        $data['user_type'] = $user_type;
		$data['user']  = reset($users->where('id_user', $this->session)->find());
		$data['path']  = $this->path;
        $data['title'] = 'Lista de usuarios';

        foreach ($data_user as $key_user => $row_user) {
            $data_user[$key_user]['type_name'] = $user_type[$row_user['type']];
        }

        $data['users'] = $data_user;

        if($data['user']['type'] != 2 ){
            return redirect()->to(base_url());
        }

        return view('list_user', $data);
    }
    
    public function associateOffice()
	{
        $users           = new UserModel();
        $offices         = new officeModel();
        $offices         = $offices->findAll();
        $data['user']    = reset($users->where('id_user', $this->session)->find());
        $users           = $users->join('t_user_office', 't_user_office.id_t_user   = t_user.id_user', 'left')->find();
		$data['path']    = $this->path;
        $data['title']   = 'Gestor de oficinas del usuario';
        $data_user       = [];
        $data_office     = [];

        foreach ($users as $key_user => $row_user) {
            $user_id   = $row_user['id_user'];
            $office_id = $row_user['id_t_office'];
            $data_user[$user_id]['user'] = $row_user;

            if($row_user['id_t_office'] > 0){
                $data_user[$user_id]['offices'][] = reset(array_filter($offices, function($e) use($office_id){
                    return $e['id_office'] == $office_id;
                }));
            }
        }

        foreach ($offices as $key_offices => $row_office) {
            $data_office[$row_office['id_office']] = $row_office;
        }

        $data['users']   = $data_user;
        $data['offices'] = $data_office;

        if($data['user']['type'] != 2 ){
            return redirect()->to(base_url());
        }

        return view('associate_office', $data);
    }

    public function logout()
    {
        setcookie("cook-login", '' , 1,  '/', NULL);
        return redirect()->to(base_url('/index.php/'));
    }

    public function edit()
    {
        $users         = new UserModel();
        $user_session  = reset($users->where('id_user', $this->session)->find());
        $requestBody   = json_decode($this->request->getBody());

        if($user_session['type'] == 2 || $this->session == $requestBody->id_user){
            $user          = reset($users->where('id_user', $requestBody->id_user)->find());
            $user['type']  = isset($requestBody->type) ? $requestBody->type : $user['type'];
            $user['pass']  = !empty($requestBody->pass) ? md5($requestBody->pass) : $user['pass'];
        }else{
            return json_encode([
                "code"    => self::ERROR_AUTH_NO_VALID, 
                "message" => "No tiene permisos para editar el usuario", 
                "data"    => ""
                ]);
        }

        $user['name']  = !empty($requestBody->name) ? $requestBody->name : $user['name'];

        if(empty($user)){
            return json_encode([
                "code"    => self::ERROR_USER_INVALID, 
                "message" => "Usuario no encontrado", 
                "data"    => ""
                ]);  
        }

        if(!empty($requestBody->password_old)){
            if(md5($requestBody->password_old) != $user['pass']){
                return json_encode([
                    "code"    => self::ERROR_PASS_INCORRECT, 
                    "message" => "Clave de usuario incorrecta", 
                    "data"    => ""
                    ]);
            }
            $user['pass'] = md5($requestBody->password);
        }
        
        $user_updated = $this->update($user);

        return json_encode([
                    "code"    => self::OK_SUCCESS, 
                    "message" => "La información fue actualizada exitosamente", 
                    "data"    => $user
                    ]);
    }

    public function save()
    {
        $users         = new UserModel();
        $user_session  = reset($users->where('id_user', $this->session)->find());
        $user_all      = $users->findAll();
        $requestBody   = json_decode($this->request->getBody());



        if($user_session['type'] != 2){
            return json_encode([
                "code"    => self::ERROR_AUTH_NO_VALID,
                "message" => "No tiene permisos para crear usuarios",
                "data"    => ""
                ]);
        }

        foreach ($user_all as $key_user => $usr) {
            // Se valida el correo se encuentre asociado a un usuario
            if($usr['email'] == $requestBody->email){
                return json_encode([
                    "code"    => self::ERROR_EMAIL_NO_VALID,
                    "message" => "El correo ya se encuentra registrado",
                    "data"    => ""
                    ]);
            }
        }

        $user = [
            "name"  => $requestBody->name,
            "type"  => $requestBody->type,
            "email" => strtolower($requestBody->email),
            "pass"  => md5($requestBody->password)
        ];

        $user_created = $this->insert($user);

        return json_encode([
                    "code"    => self::OK_SUCCESS,
                    "message" => "El usuario fue creado exitosamente",
                    "data"    => $user_created
                ]);
    }
    
    // Service CRUD
    public function update($row_user){
        $users = new UserModel();
        $users->set($row_user);
        $users->where('id_user', $row_user['id_user']);
        $users->update();
        return $row_user;
    }

    public function insert($row_user){
        $users = new UserModel();
        $users->insert($row_user);
    }

    public function delete($row_user){
        $users = new UserModel();
        $users->where('id_user', $row_user['id_user']);
        $users->delete();
    }

}