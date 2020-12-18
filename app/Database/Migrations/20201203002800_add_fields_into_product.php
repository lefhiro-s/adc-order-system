<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsIntoProduct extends Migration
{

        public function up()
        {
                $fields = array(
                    'description' => array(
                        'type' => 'VARCHAR',
                        'constraint'     => 200,
                        'null'           => true,
                        'comment'        => 'Description Product'
                    )
                );
                $this->forge->addColumn('t_order_product', $fields);

                $fields = array(
                    'price' => array(
                        'type' => 'DECIMAL',
                        'constraint'     => 18,0,
                        'null'           => true,
                        'comment'        => 'Price'
                    )
                );
                $this->forge->addColumn('t_order_product', $fields);

                $fields = array(
                    'warehouse' => array(
                        'type' => 'VARCHAR',
                        'constraint'     => '10',
                        'null'           => true,
                        'comment'        => 'Wharehouse'
                    )
                );
                $this->forge->addColumn('t_order_product', $fields);
        }

        public function down()
        {
            $this->forge->dropColumn('t_order_product', 'description');
            $this->forge->dropColumn('t_order_product', 'price');
            $this->forge->dropColumn('t_order_product', 'warehouse');
        }
}
