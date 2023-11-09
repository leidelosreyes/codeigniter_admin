<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UrlSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'base_url' => 'https://www.feisuzyapi.com',
                'created_at' => Time::now()
            ]
        ];

        foreach($data as $row)
        {
            // insert data to table
            $this->db->table('url')->insert($row);
        }
    }
}
