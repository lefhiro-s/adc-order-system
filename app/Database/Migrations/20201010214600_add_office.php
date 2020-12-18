<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOffice extends Migration
{

        public function up()
        {
                $this->forge->addField([
                        'id_office' => [
                                'type'           => 'INT',
                                'constraint'     => 5,
                                'unsigned'       => true,
                                'auto_increment' => true,
                                'comment'        => 'User ID',

                        ],
                        'rif'  => [
                                'type'           => 'VARCHAR',
                                'constraint'     => 11,
                                'null'           => true,
                                'comment'        => 'Regime of Tax Incorporation',

                        ],
                        'nomb' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => 50,
                                'null'           => true,
                                'comment'        => 'office name',

                        ],
                        'ubic' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => 50,
                                'null'           => true,
                                'comment'        => 'office location',

                        ],
                        'esta' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => 50,
                                'null'           => true,
                                'comment'        => 'office state',

                        ],
                        'SALSTERR' => [
                                'type'           => 'VARCHAR',
                                'constraint'        => 15,
                                'null'           => true,
                        ],
                        'SLPRSNID' => [
                                'type'           => 'VARCHAR',
                                'constraint'     	 => 15,
                                'null'           => true,
                        ],
                        'PRSTADCD' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => 25,
                                'null'           => true,
                        ],
                        'CUSTNAME' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => 70,
                                'null'           => true,
                        ],
                        'nume_tien' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => 5,
                                'null'           => true,
                        ],
                        'INI_FACT_GP' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => 6,
                                'null'           => true,
                        ],
                        'DOCID' => [
                                'type'           => 'VARCHAR',
                                'constraint'     => 50,
                                'null'           => true, 
                        ],
                        'PRCLEVEL' => [
                                'type'           => 'VARCHAR',
                                'constraint'  	 => 50,
                                'null'           => true,
                        ],
                        'UOFM' => [
                                'type'           => 'VARCHAR',
                                'constraint'  	 => 50,
                                'null'           => true,
                        ],
                        'CURNCYID' => [
                                'type'           => 'VARCHAR',
                                'constraint'  	 => 50,
                                'null'           => true,
                        ],
                        'CREATETAXES' => [
                                'type'           => 'VARCHAR',
                                'constraint'  	 => 5,
                                'null'           => true, 
                        ],
                        'DEFTAXSCHDS' => [
                                'type'           => 'VARCHAR',
                                'constraint'  	 => 5,
                                'null'           => true, 
                        ],
                        'DEFPRICING' => [
                                'type'           => 'VARCHAR',
                                'constraint'  	 => 5,
                                'null'           => true, 
                        ]
                ]);
                $this->forge->addKey('id_office', true);
                $this->forge->createTable('t_office');
        }

        public function down()
        {
                $this->forge->dropTable('t_office');
        }
}
