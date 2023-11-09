<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataPendidikanPelamar extends Migration
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
      'jenjang' => [
        'type' => 'VARCHAR',
        'constraint' => 3000,
        'null' => true,
      ],
      'lembaga' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'tahun_lulus' => [
        'type' => 'INT',
        'constraint' => 4,
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
    $this->forge->createTable('pendidikanpelamar');
  }

  public function down()
  {
    $this->forge->dropTable('pendidikanpelamar');
  }
}
