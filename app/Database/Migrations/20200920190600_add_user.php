<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUser extends Migration
{

        public function up()
        {
                $this->forge->addField([
                        'id_user'          => [
                                'type'           => 'INT',
                                'constraint'     => 5,
                                'unsigned'       => true,
                                'auto_increment' => true,
                                'comment'        => 'User ID',

                        ],
                        'name'       => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '50',
                                'null'           => false,
                                'comment'        => 'User name',

                        ],
                        'pass' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '50',
                                'null'           => false,
                                'comment'        => 'User password',

                        ],
                        'type' => [
                                'type'           => 'TINYINT',
                                'default'     	 => '1',
                                'null'           => false,
                                'comment'        => '1 : Normal; 2 : Admin; 0 : Deactivate',
                        ],
                        'email' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '50',
                                'null'           => false,
                                'comment'        => 'User Email',
                        ],
                        'last_login' => [
                                'type'           => 'DATETIME',
                                'null'           => true,
                                'comment'        => 'Last login user',
                        ],
                ]);
                $this->forge->addKey('id_user', true);
                $this->forge->createTable('t_user');
        }

        public function down()
        {
                $this->forge->dropTable('t_user');
        }
}
