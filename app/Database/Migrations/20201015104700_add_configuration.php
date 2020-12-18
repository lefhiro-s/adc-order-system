<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddConfiguration extends Migration
{

        public function up()
        {
                $this->forge->addField([
                        'id_conf'    => [
                                'type'           => 'INT',
                                'constraint'     => 5,
                                'unsigned'       => true,
                                'auto_increment' => true,
                                'comment'        => 'Configuration ID',
                        ],

                        'name'       => [
                            'type'           => 'VARCHAR',
                            'constraint'     => '50',
                            'null'           => false,
                            'comment'        => 'Configuration Name',
                        ],

                        'value'       => [
                            'type'           => 'VARCHAR',
                            'constraint'     => '50',
                            'null'           => false,
                            'comment'        => 'Configuration value',

                        ],

                        'description'  => [
                            'type'           => 'VARCHAR',
                            'constraint'     => '300',
                            'null'           => true,
                            'comment'        => 'Configuration description',
                        ],

                        'active'       => [
                                'type'           => 'BIT',
                                'null'           => false,
                                'comment'        => 'Configuration active',
                        ]
                ]);
                $this->forge->addKey('id_conf', true);
                $this->forge->createTable('t_configuration');
        }

        

        public function down()
        {
                $this->forge->dropTable('t_configuration');
        }
}
