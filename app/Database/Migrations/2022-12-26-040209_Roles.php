<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Roles extends Migration
{
    public function up()
    {
        //
        $this->forge->addField(
            [
                'id' => [
                    'type'              => 'INT',
                    'constraint'        => 12,
                    'unsigned'          => true,
                    'auto_increment'    => true
                ],
                'role_name' => [
                    'type'              => 'VARCHAR',
                    'constraint'        => 100,
                    'null'              => false,
                    'unique'            => true
                ],
                'permission_id' => [ // comma delimited string of permissions.
                    'type'              => 'TEXT',
                    'null'              => true
                ],
                'role_desc' => [
                    'type'              => 'VARCHAR',
                    'constraint'        => 255,
                    'null'              => true
                ],
				'created_at' => [
					'type' => 'DATETIME',
					'null' => true
				],
				'updated_at' => [
					'type' => 'DATETIME',
					'null' => true
				],
				'deleted_at' => [
					'type' => 'DATETIME',
					'null' => true
				],
            ]
        );

        // adding key
		$this->forge->addKey('id', true);

		// create table
        $this->forge->createTable('roles');
    }

    public function down()
    {
        // drop/delete table
        $this->forge->dropTable('roles');
    }
}
