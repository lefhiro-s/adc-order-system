<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrder extends Migration
{

        public function up()
        {
                $this->forge->addField([
                        'id_order'          => [
                                'type'           => 'INT',
                                'constraint'     => '5',
                                'unsigned'       => true,
                                'auto_increment' => true,
                                'comment'        => 'Order ID',
                        ],

                        'id_user'       => [
                                'type'           => 'INT',
                                'constraint'     => '5',
                                'null'           => false,
                                'unsigned'       => true,
                                'comment'        => 'User ID',
                        ],

                        'status' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '50',
                                'null'           => false,
                                'comment'        => 'Order Status',
                        ],

                        'id_office' => [
                                'type'           => 'INT',
                                'constraint'     => '5',
                                'null'           => false,
                                'unsigned'       => true,
                                'comment'        => 'Office ID',
                        ],

                        'creation_date' => [
                            'type'              => 'timestamp',
                            'comment'           => 'Creation Order',
                        ],

                        'pre_approved' => [
                                'type'           => 'BIT',
                                'null'           => false,
                                'comment'        => 'It will be 1 if the value (pedidos_requieren_autorizacion) is = NO',
                        ],

                        'approved_by' => [
                                'type'           => 'INT',
                                'constraint'     => '5',
                                'null'           => true,
                                'unsigned'       => true,
                                'comment'        => 'User ID, if approval is required',
                        ],

                        'approved_time' => [
                            'type'              => 'DATETIME',
                            'null'              => true,
                            'comment'           => 'Approval date, If approval is required'
                        ],

                        'return_id' => [
                            'type'              => 'VARCHAR',
                            'constraint'        => '350',
                            'null'              => true,
                            'comment'           => 'Return when sending and order'
                        ],

                        'error_description' => [
                            'type'              => 'VARCHAR',
                            'constraint'        => '350',
                            'null'              => true,
                            'comment'           => 'Error information when submitting the order'
                        ],

                ]);

                $this->forge->addKey('id_order', true);
                $this->forge->addForeignKey('id_user','t_user','id_user');
                $this->forge->addForeignKey('approved_by','t_user','id_user');
                $this->forge->addForeignKey('id_office','t_office','id_office');
                $this->forge->createTable('t_order');
        }

        public function down()
        {
                $this->forge->dropTable('t_order');
        }
}
