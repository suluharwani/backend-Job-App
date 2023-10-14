<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ApplyJob extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
            ],
            'id_job' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',

        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('apply');
    }

    public function down()
    {
        $this->forge->dropTable('apply');
    }

}