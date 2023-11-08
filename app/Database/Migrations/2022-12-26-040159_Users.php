<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * To create a migration, make sure you are in the correct folder (root folder of the 'project') then run on the command line
 * creating migration => php spark make:migration [filename]
 * ex: php spark make:migration User
 */

class Users extends Migration
{
    public function up()
    {
        // note: [] is shorthand for array. '[]' is equavalent to 'array()'
		// adding fields
        $this->forge->addField(
            [
                'id' => [
                    'type'              => 'INT',
                    'constraint'        => 12,
                    'unsigned'          => true,
                    'auto_increment'    => true
                ],
                'username' => [
                    'type'              => 'VARCHAR',
                    'constraint'        => 50,
                    'null'              => false,
                    'unique'            => true
                ],
                'password' => [
                    'type'              => 'VARCHAR',
                    'constraint'        => 255,
                    'null'              => false
                ],
                'email' => [
                    'type'              => 'VARCHAR',
					'constraint'		=> 100,
					'unique'			=> true
				],
                'role_id' => [
                    'type'              => 'INT',
					'constraint'		=> 20,
					'unique'			=> false
                ],
                'gsecret' => [
                    'type'              => 'VARCHAR',
					'constraint'		=> 100,
					'unique'			=> false
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
        $this->forge->createTable('users');
    }

    public function down()
    {
        // drop/delete table
		$this->forge->dropTable('users');
    }
}
