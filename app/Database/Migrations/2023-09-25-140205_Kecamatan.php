<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kecamatan extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'dis_id' => [
          'type' => 'INT',
          'constraint' => 10,
          'unsigned' => true,
          'auto_increment' => true,
        ],
        'dis_name' => [
          'type' => 'VARCHAR',
          'constraint' => 200,
          'null' => true,
        ],

        'city_id' => [
          'type' => 'INT',
          'constraint' => 10,
          'null' => true,
        ]
        
      ]);
      $this->forge->addPrimaryKey('dis_id');
      $this->forge->createTable('districts');
    }
    
    public function down()
    {
      $this->forge->dropTable('districts');
    }
}
