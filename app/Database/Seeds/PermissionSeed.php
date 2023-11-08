<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PermissionSeed extends Seeder
{
    public function run()
    {
        // initial seed file for permission table
        $data = [
            [
                'controller_method' => 'UserManagement/index',
                'perm_desc' => 'Main user management page',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'UserManagement/save_data',
                'perm_desc' => 'User Management create/edit data',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'UserManagement/delete_data',
                'perm_desc' => 'User Management delete data',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'PermissionManagement/index',
                'perm_desc' => 'Main Permission Management page',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'PermissionManagement/save_data',
                'perm_desc' => 'Permission Management create edit data',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'PermissionManagement/delete_data',
                'perm_desc' => 'Permission Management delete data',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'RoleManagement/index',
                'perm_desc' => 'Main Role Management page',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'RoleManagement/save_data',
                'perm_desc' => 'RoleManagement create/edit data',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'RoleManagement/delete_data',
                'perm_desc' => 'Role Management delete data',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'SysConfig/index',
                'perm_desc' => 'Main sysconfig Management Page',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'SysConfig/save_data',
                'perm_desc' => 'Sysconfig create/edit data',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'SysConfig/delete_data',
                'perm_desc' => 'Sysconfig delete data',
                'created_at' => Time::now()
            ],
            [
                'controller_method' => 'Message/index',
                'perm_desc' => 'Main Permission Management page',
                'created_at' => Time::now()
            ],
        ];

        // foreach loop to insert seed data
        foreach($data as $row)
        {
            // insert data to table
            $this->db->table('permission')->insert($row);
        }
    }
}
