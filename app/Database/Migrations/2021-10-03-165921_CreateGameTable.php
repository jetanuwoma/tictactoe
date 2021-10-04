<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGameTable extends Migration
{
  public function up()
  {
    $this->forge->addField([
        'id' => [
          'type' => 'INT',
          'constraint' => 5,
          'unsigned' => true,
          'auto_increment' => true,
        ],
        'slug' => [
          'type' => 'VARCHAR',
          'constraint' => 100,
          'null' => false,
        ],
        'player_one' => [
          'type' => 'INT',
          'constraint' => 5,
          'null' => false,
        ],
        'player_two' => [
          'type' => 'INT',
          'constraint' => 5,
          'null' => false,
        ],
        'game_data' => [
          'type' => 'TEXT',
          'constraint' => 100,
          'null' => true,
        ],
        'updated_at' => [
          'type' => 'datetime',
          'null' => true,
        ],
        'created_at datetime default current_timestamp'
    ]);

    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('games');
  }

  public function down()
  {
      $this->forge->dropTable('games');
  }
}
