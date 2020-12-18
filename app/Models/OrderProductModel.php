<?php 

namespace App\Models;
use CodeIgniter\Model;

class OrderProductModel extends Model
{

    protected $table = 't_order_product';
    protected $allowedFields = ['id_order_product', 'id_order', 'quantity', 'product_code', 'description', 'price', 'warehouse'];
}
?>