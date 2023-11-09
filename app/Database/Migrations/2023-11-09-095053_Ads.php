<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ads extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id' => [
                    'type'              => 'INT',
                    'constraint'        => 12,
                    'unsigned'          => true,
                    'auto_increment'    => true
                ],
                'link' => [
                    'type'              => 'VARCHAR',
                    'constraint'        => 50,
                    'null'              => false
                ],
                'description' => [
                    'type'              => 'VARCHAR',
                    'constraint'        => 50,
                    'null'              => false
                ],
                'images' => [
                    'type'              => 'VARCHAR',
                    'constraint'        => 50,
                    'null'              => false
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
        $this->forge->createTable('ads');
    }

    public function down()
    {
        $this->forge->dropTable('ads');
    }
}
