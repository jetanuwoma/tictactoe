<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content">
  <div class="gameframe">
    <div class="greybg">
      <div class="gamepanel" data-game='<?=$game->game_data?>' data-slug="<?=$game->slug?>">
        <div id="box0" class="panelbox"></div>
        <div id="box1" class="panelbox"></div>
        <div id="box2" class="panelbox"></div>
        <div id="box3" class="panelbox"></div>
        <div id="box4" class="panelbox"></div>
        <div id="box5" class="panelbox"></div>
        <div id="box6" class="panelbox"></div>
        <div id="box7" class="panelbox"></div>
        <div id="box8" class="panelbox"></div>
      </div>
    </div>
    <div class="bottom">
      <div class="detail">
        <div class="count"><?=$game->player_one_score?></div>
        <div class="playernames active player_one" data-name='<?=$game->player_one_name?>'><?=$game->player_one_name?></div>
      </div>
      <div class="detail">
        <a href="<?=base_url()."/home/play_again/".$game->slug?>" class="play-again hide">Play again</a>
      </div>
      <div class="detail">
        <div class="count"><?=$game->player_two_score?></div>
        <div class="playernames player_two" data-name='<?=$game->player_one_name?>'><?=$game->player_two_name?></div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>