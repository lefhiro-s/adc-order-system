<?php namespace App\Database\Seeds;

class ConfigurationSeeder extends \CodeIgniter\Database\Seeder
{
        public function run()
        {
                $data = [
                    [
                        'id_conf'     => '1',
                        'name'        => 'pedidos_requieren_autorizacion',
                        'value'       => 'NO',
                        'description' => ' Cuando este valor se encuentra en NO, los pedidos generados'
                                        .' por las tienda se enviaran automaticamente a Telares, en caso contrario,'
                                        .' debe asignarse el valor de SI, entonces, tendra que un administrador entrar'
                                        .' en pedidos y proceder a Aprobarlos' ,
                        'active'      =>  1
                    ]
                ];

                $this->db->table('t_configuration')->insertBatch($data);
        }
}
