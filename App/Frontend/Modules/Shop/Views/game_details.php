<div class="row">
    <div class="col-md-3">
        <img class="img-responsive" src="<?php echo ROOTADDRESS.'/resources/img/games/'.$game->getJacket(); ?>" alt="">
    </div>
    <div class="col-md-9">
        <p>
            <p>VUE shopController</p>
            <?php echo $this->app->getTranslator()->get('modal.games_details.title : '); ?> : <?php echo $game->getTitle(); ?>
            <br />description : <?php echo $game->getDescription(); ?>
            <br />PEGI : <?php echo $game->getPegi(); ?>
            <br />plateformes : <?php echo implode(', ', $game->getPlatforms()->toArray()); ?>
        </p>
    </div>
</div>