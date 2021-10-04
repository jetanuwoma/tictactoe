<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content game-menu">
    <div class="content-menu">
    <button class="game-button one">One Player</button>
    <button class="game-button two" data-bs-toggle="modal" data-bs-target="#startGameModal">Two Players</button>
    </div>
</div>
<?= $this->endSection(); ?>