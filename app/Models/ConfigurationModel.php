<?php 

namespace App\Models;
use CodeIgniter\Model;

class ConfigurationModel extends Model
{

    protected $table = 't_configuration';
    protected $allowedFields = ['id_conf', 'name', 'value', 'description', 'active'];
}
?>