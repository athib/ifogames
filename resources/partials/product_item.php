<div class="col-xs-12 col-sm-6 col-md-4 product-holder" genre="<?php echo implode(' ', $game->getGenres()->toArray()); ?>" platform="<?php echo implode(' ', $game->getPlatforms()->toArray()); ?>">
    <form class="custom" onsubmit="return false" method="post" action="">
        <div class="product-item text-center">
            <input type="hidden" class="id-game" value="<?php echo $game->getId(); ?>">
            <a class="product-img" href="#">
                <?php $jacket = $game->getJacket() ? '/ifogames/resources/img/games/'.$game->getJacket() : 'http://placehold.it/100x120'; ?>
                <img class="img-responsive" src="<?php echo $jacket; ?>" alt="<?php echo $game->getTitle(); ?>">
            </a>
            <h3 class="product-title">
                <a href="#"><?php echo $game->getTitle(); ?></a>
            </h3>
            <div class="product-price">
                <span><?php echo $game->getPrice(); ?> €</span>
            </div>
            <div class="product-platform">
                <select class="platform-select">
                    <option selected disabled><?php echo $translator->get('shop.product.chose_platform'); ?></option>
                    <?php
                    foreach ($game->getPlatforms() as $platform) {
                        echo '<option value="'.$platform->getId().'" stock="'.$platform->stock.'">'.$platform->getFullName().'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="product-stock" style="display: none;">
                <span></span> <?php echo $translator->get('shop.product.available'); ?>
            </div>
            <div class="buttons-holder">
                <button class="action action-details btn btn-default my-btn-default btn-quick-view" data-toggle="modal" data-target="#modal-infos" data-route="game-details" data-id="<?php echo $game->getId(); ?>">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </button>
                <input type="hidden" name="productId" value="<?php echo $game->getId(); ?>">
                <a class="btn btn-danger my-btn-danger btn-add-cart" href="#"><span class="glyphicon glyphicon-shopping-cart"></span></a>
            </div>
        </div>
    </form>
</div>



<div class="modal fade" id="modal-infos" tabindex="-1" role="dialog" aria-labelledby="modalinfos">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Détails d'un élément</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="modal-infos-submit btn btn-default my-btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>