<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataPelamar extends Migration
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
      'alamat' => [
        'type' => 'VARCHAR',
        'constraint' => 3000,
        'null' => true,
      ],
      'tanggal_lahir' => [
        'type' => 'date',
        'null' => true,
      ],
      'telepon' => [
        'type' => 'VARCHAR',
        'constraint' => 20,
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
    $this->forge->createTable('datapelamar');
  }

  public function down()
  {
    $this->forge->dropTable('datapelamar');
  }
}
