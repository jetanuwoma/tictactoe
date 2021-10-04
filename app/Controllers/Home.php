<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
  use ResponseTrait;
  public function index()
  {
    $data = [
        'title' => 'Home | Play Tic-tac-toe online',
    ];
    return view('home/index', $data);
  }

  public function play_game($game_slug) {
    $game = $this->game->getGameBySlug($game_slug);
    $data = [
      'title' => 'Game | '.$game->player_one_name.' VS '.$game->player_two_name,
      'game' => $game
    ];
    return view('home/game_arena', $data);
  }


  public function submit_game() {
    if (!$this->validate([
      'slug' => "required",
      'board'  => 'required',
    ])) {
      $response = [
        'status'   => 400,
        'error'    => 'invalid data',
      ];
    return $this->respond($response);
    }

    $slug = $this->request->getVar('slug');
    $data = [
      'winner' => $this->request->getVar('winner'),
      'game_data' => $this->request->getVar('board')
    ];
    $update_game = $this->game->updateGameBySlug($slug, $data);

    $response = [
      'status'   => 200,
      'data' => $this->game->getGameBySlug($slug),
    ];

    return $this->respond($response);

  }

  public function play_again($slug) {
    $game = $this->game->getGameBySlug($slug);
    $data = [
      'player_one' => $game->player_one_id,
      'player_two' => $game->player_two_id,
    ];

    $game_slug = $this->game->createGame($data);

    if ($game_slug) {
      echo 'home/play_game/'.$game_slug;
      return redirect()->to('home/play_game/'.$game_slug);
    } else {
      return view('home/index', [
        'title' => 'Home | Play Tic-tac-toe online',
          'errors' => 'Error creating games'
      ]);
    }
  }

  public function create_game(){
    if (! $this->validate([
      'player_one' => "required",
      'player_two'  => 'required'
    ])) {
      return view('home/index', [
        'title' => 'Home | Play Tic-tac-toe online',
          'errors' => $this->validator->getErrors()
      ]);
    }

   $data = [
     'player_one' => $this->request->getVar('player_one'),
     'player_two' => $this->request->getVar('player_two'),
   ];

   $game_slug = $this->game->createGame($data);
    echo $game_slug;
   if ($game_slug) {
      echo 'home/play_game/'.$game_slug;
      return redirect()->to('home/play_game/'.$game_slug);
    } else {
      return view('home/index', [
        'title' => 'Home | Play Tic-tac-toe online',
          'errors' => 'Error creating games'
      ]);
    }
  }
}
