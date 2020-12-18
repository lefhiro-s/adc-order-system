<?php 

namespace App\Models;
use CodeIgniter\Model;

class OrderModel extends Model
{

    protected $table = 't_order';
    protected $allowedFields = ['id_order', 'id_user', 'creation_date', 'status', 'id_office', 'pre_approved', 
                                'approved_by', 'approved_time', 'return_id', 'error_description'];
}
?>