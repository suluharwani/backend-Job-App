<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Company extends Migration
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
        'company_name' => [
          'type' => 'VARCHAR',
          'constraint' => 200,
          'null' => true,
        ],
        'company_desc' => [
            'type' => 'VARCHAR',
            'constraint' => 5000,
            'null' => true,
          ],
        'company_logo' => [
            'type' => 'VARCHAR',
            'constraint' => 500,
            'null' => true,
          ],
        'user_id' => [
          'type' => 'INT',
          'constraint' => 10,
          'null' => true,
        ],
        'prov_id' => [
          'type' => 'INT',
          'constraint' => 10,
          'null' => true,
        ],
        'city_id' => [
            'type' => 'INT',
            'constraint' => 10,
            'null' => true,
          ],
          'dis_id' => [
            'type' => 'INT',
            'constraint' => 10,
            'null' => true,
          ],
          'subdis_id' => [
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
      $this->forge->createTable('company');
    }
    
    public function down()
    {
      $this->forge->dropTable('company');
    }
}
