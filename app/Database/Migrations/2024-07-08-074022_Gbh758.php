<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Gbh758 extends Migration
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
                'item' => [
                    'type'              => 'VARCHAR', 
                    'constraint'        => 255,
                ],
                'value' => [
                    'type'              => 'TEXT', 
                    'null'           => true,
                ],
                'title' => [
                    'type'              => 'VARCHAR', 
                    'constraint'        => 255,
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
        $this->forge->createTable('gbh758');
    }

    public function down()
    {
        //
        $this->forge->dropTable('gbh758');
    }
}
