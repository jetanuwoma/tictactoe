<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePlayersTable extends Migration
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
          'is_computer' => [
            'type' => 'INT',
            'null' => false,
            'default' => 0
          ],
          'name' => [
              'type' => 'VARCHAR',
              'constraint' => 100,
              'null' => false,
            ],
          'updated_at' => [
            'type' => 'datetime',
            'null' => true,
          ],
          'created_at datetime default current_timestamp'
      ]);
  
      $this->forge->addPrimaryKey('id');
      $this->forge->createTable('players');
    }

    public function down()
    {
      $this->forge->dropTable('games');
    }
}
