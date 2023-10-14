<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Desa extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'subdis_id' => [
          'type' => 'INT',
          'constraint' => 10,
          'unsigned' => true,
          'auto_increment' => true,
        ],
        'subdis_name' => [
          'type' => 'VARCHAR',
          'constraint' => 200,
          'null' => true,
        ],

        'dis_id' => [
          'type' => 'INT',
          'constraint' => 10,
          'null' => true,
        ]
        
      ]);
      $this->forge->addPrimaryKey('subdis_id');
      $this->forge->createTable('subdistricts');
    }
    
    public function down()
    {
      $this->forge->dropTable('subdistricts');
    }
}