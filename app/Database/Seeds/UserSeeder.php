<?php namespace App\Database\Seeds;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
        public function run()
        {
                $data = [
                    [
                        'name'  => 'admin',
                        'email' => 'admin@example.com',
                        'type'  => 2,
                        'pass'  =>  md5('12345')],
                    [
                        'name'  => 'user',
                        'email' => 'user@example.com',
                        'type'  => 1,
                        'pass'  =>  md5('12345')],
                    [
                        'name'  => 'disabled',
                        'email' => 'disabled@example.com',
                        'type'  => 0,
                        'pass'  =>  md5('12345')
                    ]
                ];

                $this->db->table('t_user')->insertBatch($data);
        }
}
