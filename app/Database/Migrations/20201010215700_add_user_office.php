<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserOffice extends Migration
{

        public function up()
        {
                $this->forge->addField([
                        'id_user_office'    => [
                                'type'           => 'INT',
                                'constraint'     => 5,
                                'unsigned'       => true,
                                'auto_increment' => true,
                                'comment'        => 'User Office ID',
                        ],

                        'id_t_user'       => [
                            'type'           => 'INT',
                            'constraint'     => 5,
                            'unsigned'       => true,
                            'null'           => false,
                            'comment'        => 'User ID',
                        ],

                        'id_t_office'       => [
                            'type'           => 'INT',
                            'constraint'     => 5,
                            'unsigned'       => true,
                            'null'           => false,
                            'comment'        => 'Office ID',
                        ]
                ]);
                $this->forge->addKey('id_user_office', true);
                $this->forge->addForeignKey('id_t_user','t_user','id_user');
                $this->forge->addForeignKey('id_t_office','t_office','id_office');
                $this->forge->createTable('t_user_office');
        }

        public function down()
        {
                $this->forge->dropTable('t_user_office');
        }
}
