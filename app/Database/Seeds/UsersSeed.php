<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

/**
 * To create a new seed, make sure you are in the correct folder (root folder of the 'project') then run on the command line
 * creating seed file => php spark make:seeder [filename]
 * ex: php spark make:seeder TestUserSeed
 */

class UsersSeed extends Seeder
{
    public function run()
    {
        // initial seed file for users table
         $data = [
            [
                'username' => 'ConsolidatedAdmin',
                'password' => password_hash('Admin0ImdC5HLnpwd', PASSWORD_DEFAULT),
                'email' => 'abc01@abc.com',
                'role_id' => 1,
                'gsecret' => 'EMKQ6YAMXFESMQOL', // google auth secret
                'created_at' => Time::now()
            ],
            [
                'username' => 'agenttest01',
                'password' => password_hash('testing123456', PASSWORD_DEFAULT),
                'email' => 'abc02@abc.com',
                'role_id' => 2,
                'gsecret' => 'EMKQ6YAMXFESMQOL',
                'created_at' => Time::now()
            ],
            
        ];
        
        // foreach loop to insert seed data
        foreach($data as $row)
        {
            // insert data to table
            $this->db->table('users')->insert($row);
        }
    }
}
