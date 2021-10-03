<?php

namespace App\Controllers;

class Home extends BaseController
{
  public function index()
  {
    $data = [
        'title' => 'Home | Play Tic-tac-toe online',
    ];
    return view('home/index', $data);
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

    
  }
}
