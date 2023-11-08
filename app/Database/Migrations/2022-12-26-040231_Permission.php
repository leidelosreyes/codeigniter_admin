<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Permission extends Migration
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
                'controller_method' => [
                    'type'              => 'VARCHAR',
                    'constraint'        => 255,
                    'null'              => false,
                    'unique'            => true
                ],
                'perm_desc' => [
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
        $this->forge->createTable('permission');
    }

    public function down()
    {
        //
        $this->forge->dropTable('permission');
    }
}
