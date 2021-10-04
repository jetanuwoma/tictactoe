<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWinnerToGame extends Migration
{
    public function up()
    {
      $fields = [
        'winner_id' => array('type' => 'INT', 'null' => true)
      ];
      $this->forge->addColumn('games', $fields);
    }

    public function down()
    {
      $this->forge->dropColumn('games', 'winner_id');
    }
}
