<?php

namespace App\Models;
use App\Models\Player;

use CodeIgniter\Model;

class Game extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'games';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'player_one',
        'player_two',
        'game_data',
        'winner_id',
        'slug',
    ];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    public function getGameBySlug($slug) {
      $game = $this->where(['games.slug' => $slug])
      ->join('players AS player_one', 'player_one.id = games.player_one')
      ->join('players AS player_two', 'player_two.id = games.player_two')
      ->select('player_one.name AS player_one_name, player_two.name as player_two_name, games.slug, games.winner_id, games.game_data, games.id')
      ->select('player_one.id as player_one_id, player_two.id as player_two_id')
      ->join('games AS games_played_together', 'player_one.id = games_played_together.player_one AND player_two.id = games_played_together.player_two')
      ->select('sum((case when games_played_together.winner_id = player_one.id then 1 else 0 end )) as player_one_score')
      ->select('sum((case when games_played_together.winner_id = player_two.id then 1 else 0 end )) as player_two_score')
      ->get();
      return $game->getRow();
    }

    public function createGame(array $data) {
      $this->db->transStart();
      $player_one = new Player();
      $player_two = new Player();
      $slug = $this->generate_slug();

      if (!is_numeric($data['player_one'])) {
        $player_one->insert(['name' => $data['player_one']]);
        $player_two->insert(['name' => $data['player_two']]); 
        $this->insert([
          'player_one' => $player_one->insertID,
          'player_two' => $player_two->insertID,
          'slug' => $slug,
          'game_data' => '["", "", "", "", "", "", "", "", ""]'
        ]);
      } else {
        $this->insert([
          'player_one' => $data['player_one'],
          'player_two' => $data['player_two'],
          'slug' => $slug,
          'game_data' => '["", "", "", "", "", "", "", "", ""]'
        ]);
      }
     
      
      $this->db->transComplete();
      if ($this->db->transStatus()) {
        return $slug;
      } else {
        return false;
      }
    }

    public function updateGameBySlug($slug, $data) {
      $game = $this->getGameBySlug($slug);
      $winner_id = null;
      if ($data['winner'] == 'x') {
        $winner_id = $game->player_one_id;
      } else if ($data['winner'] == 'o') {
        $winner_id = $game->player_two_id;
      }
      $this->update($game->id, ['winner_id' => $winner_id, 'game_data' => $data['game_data']]);
    }

    private function generate_slug($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }
}
