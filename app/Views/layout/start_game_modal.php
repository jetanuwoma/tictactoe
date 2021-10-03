<div class="modal fade" id="startGameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <?=form_open('home/create_game')?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Enter Player Names</h5>
          </button>
        </div>
        <div class="modal-body">
          <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
            <input type="text" name="player_one" value="player1" class="form-control" aria-label="Player One Name">
          </div>
          <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
            <input type="text" name="player_two" value="player2" class="form-control" aria-label="Player Two Name">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Start Game</button>
        </div>
      </div>
    <?=form_close()?>
  </div>

</div>