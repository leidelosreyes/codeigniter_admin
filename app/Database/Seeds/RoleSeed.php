<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeed extends Seeder
{
    public function run()
    {
        //initial seed file for role table
        $data = [
            [
                "role_name" => "Administrator",
                "permission_id" => "1,2,3,4,5,6,7,8,9,10,11,12,13",
                "role_desc" => "Admin Account. can do all."
            ],
            [
                "role_name" => "Agent",
                "permission_id" => "10,11,12",
                "role_desc" => "Agent Account."
            ]
        ];
        // foreach loop to insert seed data
        foreach($data as $row)
        {
            // insert data to table
            $this->db->table('roles')->insert($row);
        }
    }
}
