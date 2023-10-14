<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kota extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'city_id' => [
          'type' => 'INT',
          'constraint' => 10,
          'unsigned' => true,
          'auto_increment' => true,
        ],
        'city_name' => [
          'type' => 'VARCHAR',
          'constraint' => 200,
          'null' => true,
        ],

        'prov_id' => [
          'type' => 'INT',
          'constraint' => 10,
          'null' => true,
        ]
        
      ]);
      $this->forge->addPrimaryKey('city_id');
      $this->forge->createTable('cities');
    }
    
    public function down()
    {
      $this->forge->dropTable('cities');
    }
}
