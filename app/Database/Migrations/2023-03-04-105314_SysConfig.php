<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SysConfig extends Migration
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
                'name' => [
                    'type'              => 'VARCHAR',
                    'constraint'        => 255,
                    'null'              => false,
                    'unique'            => true
                ],
                'sys_desc' => [
                    'type'              => 'VARCHAR',
                    'constraint'        => 255,
                ],
                'sys_value' => [
                    'type'              => 'TEXT',
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
        $this->forge->createTable('sysconfig');
    }

    public function down()
    {
        //
        $this->forge->dropTable('sysconfig');
    }
}
