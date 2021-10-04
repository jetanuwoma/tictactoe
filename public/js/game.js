generateX = `<div class="timesX"></div>`;
generateO = `<div class="circleO">
                <div class="inner"></div>
              </div>`;
var Board = function(boardSpaceSelector, playerOne, playerTwo, gameData) {
  boardSpaces = $(boardSpaceSelector);
  this.playerOne = playerOne;
  this.playerTwo = playerTwo;
  this.gameData = gameData;
  this.slug = $('.gamepanel').data('slug');
};

Board.prototype.checkLine = function(a,b,c, gameData) {
  let status =
  gameData[a] == gameData[b] &&
  gameData[b] == gameData[c] &&
      (gameData[a] == this.playerOne.piece || gameData[a] == this.playerTwo.piece);
  if (status) {
    $(`#box${a}`).addClass("won");
    $(`#box${b}`).addClass("won");
    $(`#box${c}`).addClass("won");
  }
  return status;
};

Board.prototype.checkWinner = function(gameData, player) {
  let res = this.checkMatch(gameData);
  return res
};

Board.prototype.checkMatch = function(gameData) {
  for (let i=0; i<9; i+=3) {
      if(this.checkLine(i,i+1,i+2, gameData)) {
          return gameData[i];
      }
  }
  for (let i=0; i<3; i++) {
      if(this.checkLine(i, i+3, i+6, gameData)) {
          return gameData[i];
      }
  }
  if(this.checkLine(0,4,8, gameData)) {
      return gameData[0];
  }
  if(this.checkLine(2,4,6, gameData)) {
      return gameData[2];
  }
  return "";
}

Board.prototype.checkBoardComplete = function(gameData) {
  let completed = true;
  gameData.forEach(element => {
      if(element == "") {
        completed = false;
      }
  });
  return completed;
};

Board.prototype.renderBoard = function() {
  boardSpaces.each((index, space) => {
    if(this.gameData[index] == 'x') {
      $(space).html(generateX)
    } else if(this.gameData[index] == 'o') {
      $(space).html(generateO);
    }
  })
};

Board.prototype.runBoard = function() {
  this.renderBoard();
}


var Player = function(piece, iconClass, name) {
  this.piece = piece;
  this.iconClass = iconClass;
  this.name = name;
};

var Game = function(playerOne, playerTwo) {
  this.gameData = eval($('.gamepanel').data('game'));
  this.playerOne = playerOne;
  this.playerTwo = playerTwo;
  this.winner = null;
  
  this.board = new Board('.gamepanel .panelbox', this.playerOne, this.playerTwo, this.gameData);
  this.board.checkBoardComplete(this.gameData);
}

Game.prototype.startGame = function() {
  this.board.runBoard();
  if (this.gameWon() || this.board.checkBoardComplete(this.gameData)) {
    $('.play-again').removeClass('hide');
  }
}

Game.prototype.gameWon = function() {
  return this.board.checkWinner(this.gameData) === 'x'
  || this.board.checkWinner(this.gameData) === 'o'
}

Game.prototype.getLastPlayer = function() {
  let countX = 0;
  let countO = 0;
  this.gameData.forEach((item) => {
    if (item == 'x') {
      countX +=1;
    } else if(item == 'o') {
      countO +=1
    }
  })

  if (countO >= countX) {
    $('.player_two').addClass('active');
    $('.player_one').removeClass('active');
    return 'x';
  } else {
    $('.player_one').addClass('active');
    $('.player_two').removeClass('active');
    return 'o';
  }
}

Game.prototype.submitGame = function () {
  const data = {
    board: JSON.stringify(this.gameData),
    slug: this.board.slug,
    winner: this.board.checkWinner(this.gameData),
  };
  $.ajax({
    type: 'POST',
    url: '/home/submit_game',
    data: data,
    success: function(data, status, jqxhr) {
      $('.play-again').removeClass('hide');  
    }
  });
}

Game.prototype.move = function(id) {
  if (this.gameData[id] === '' && !this.gameWon()){
    if (this.getLastPlayer() == 'x') {
      let newData = [...this.gameData];
      newData[id] = 'x'
      this.gameData = newData;
      $('#box'+id).html(generateX);
      const won = this.board.checkWinner(this.gameData, this.playerOne);
      if (won == 'x') {
        setTimeout(() => {
          alert(`${this.playerOne.name} Won`)
          this.submitGame();
        }, 500)
      }
    } else {
      let newData = [...this.gameData];
      newData[id] = 'o'
      this.gameData = newData;
      $('#box'+id).html(generateO)
      const won = this.board.checkWinner(this.gameData, this.playerTwo);
      if (won == 'o') {
        setTimeout(() => {
          alert(`${this.playerTwo.name} Won`)
          this.submitGame();
        }, 500)
      }
    }
    if(this.board.checkBoardComplete(this.gameData) && !this.gameWon()) {
      setTimeout(() => {
        alert(`Draw`)
        this.submitGame();
      }, 500);
      this.submitGame();
    }
  } 
}


$(document).ready(() => {
  const one = $('.player_two');
  const two = $('.player_one');
  const playerOne = new Player('x', 'timesX', one.data('name'));
  const playerTwo = new Player('o', 'circleO', two.data('name'));

  const game = new Game(playerOne, playerTwo);
  game.startGame();

  $('.panelbox').on('click', function(){
    const id = parseInt($(this).attr('id').split('x')[1]);
    console.log(id)
    game.move(id);
  })
})


