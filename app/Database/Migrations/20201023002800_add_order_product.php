<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrderProduct extends Migration
{

        public function up()
        {
                $this->forge->addField([
                        'id_order_product' => [
                            'type'           => 'INT',
                            'constraint'     => 5,
                            'unsigned'       => true,
                            'auto_increment' => true,
                            'comment'        => 'Order Product ID',
                        ],

                        'id_order' => [
                            'type'           => 'INT',
                            'constraint'     => 5,
                            'unsigned'       => true,
                            'null'           => false,
                            'comment'        => 'Order ID',
                        ],

                        'quantity' => [
                            'type'           => 'INT',
                            'constraint'     => 15,
                            'null'           => false,
                            'comment'        => 'Quantity Product',
                        ],

                        'product_code' => [
                            'type'           => 'VARCHAR',
                            'constraint'     => 50,
                            'null'           => false,
                            'comment'        => 'Code Product',
                        ]

                ]);

                $this->forge->addKey('id_order_product', true);
                $this->forge->addForeignKey('id_order','t_order','id_order');
                $this->forge->createTable('t_order_product');
        }

        public function down()
        {
                $this->forge->dropTable('t_order_product');
        }
}
