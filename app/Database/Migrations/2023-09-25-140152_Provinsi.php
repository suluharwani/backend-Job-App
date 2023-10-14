<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Provinsi extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'prov_id' => [
          'type' => 'INT',
          'constraint' => 10,
          'unsigned' => true,
          'auto_increment' => true,
        ],
        'prov_name' => [
          'type' => 'VARCHAR',
          'constraint' => 200,
          'null' => true,
        ],

        'locationid' => [
          'type' => 'INT',
          'constraint' => 10,
          'null' => true,
        ],
        'status' => [
          'type' => 'INT',
          'constraint' => 10,
          'null' => true,
        ]
        
      ]);
      $this->forge->addPrimaryKey('prov_id');
      $this->forge->createTable('provinces');
    }
    
    public function down()
    {
      $this->forge->dropTable('provinces');
    }
}
