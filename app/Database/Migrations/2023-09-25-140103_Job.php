<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Job extends Migration
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
      'company_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'cat_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'subcat_id' => [
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
      'address' => [
        'type' => 'VARCHAR',
        'constraint' => 600,
        'null' => true,
      ],
      'postal_code' => [
        'type' => 'VARCHAR',
        'constraint' => 10,
        'null' => true,
      ],
      'job' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'job_desc' => [
        'type' => 'VARCHAR',
        'constraint' => 4000,
        'null' => true,
      ],
      'benefits' => [
        'type' => 'VARCHAR',
        'constraint' => 4000,
        'null' => true,
      ],
      'minimum_qualification' => [
        'type' => 'VARCHAR',
        'constraint' => 4000,
        'null' => true,
      ],
      'facility' => [
        'type' => 'VARCHAR',
        'constraint' => 4000,
        'null' => true,
      ],
      'open_for' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'salary_start' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'salary_end' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'status' => [
        'type' => 'INT',
        'constraint' => 4,
        'null' => true,
      ],
      
      'start' => [
        'type' => 'datetime',
        'null' => true,
      ],
      'due' => [
        'type' => 'datetime',
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
    $this->forge->createTable('job');
  }

  public function down()
  {
    $this->forge->dropTable('job');
  }
}
