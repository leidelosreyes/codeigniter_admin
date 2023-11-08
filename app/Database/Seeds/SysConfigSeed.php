<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class SysConfigSeed extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                "name" => "bonus_amount",
                "sys_desc" => "amount to give to customer",
                "sys_value" => "1",
                'created_at' => Time::now()

            ],
            [
                "name" => "bonus_amount_notes",
                "sys_desc" => "bonus amount description or notes",
                "sys_value" => "given via api",
                'created_at' => Time::now()
            ]
        ];
        // foreach loop to insert seed data
        foreach($data as $row)
        {
            // insert data to table
            $this->db->table('sysconfig')->insert($row);
        }
    }
}
