<?php 

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{

    protected $table = 't_user';
    protected $allowedFields = ['id_user','name','pass','type', 'email', 'last_login'];
}
?>