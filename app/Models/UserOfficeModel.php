<?php 

namespace App\Models;
use CodeIgniter\Model;

class UserOfficeModel extends Model
{

    protected $table = 't_user_office';
    protected $primaryKey = 'id_user_office';
    
    protected $allowedFields = ['id_user_office', 'id_t_office', 'id_t_user'];
}
?>