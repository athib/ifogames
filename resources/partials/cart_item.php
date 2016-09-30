<div class="cart-item row">
    <div class="product-infos">
        <input type="hidden" class="id-game" value="<?php echo $product->getId(); ?>">
        <input type="hidden" class="id-platform" value="<?php echo $product->getOrderedPlatform()->getId(); ?>">
    </div>
    <div class="col-xs-12 col-sm-2">
        <div class="product-thumb">
            <img src="<?php echo ROOTADDRESS; ?>/resources/img/games/<?php echo $product->getJacket(); ?>" alt="<?php echo $product->getTitle(); ?>" />
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-lg-5">
        <h4><?php echo $product->getTitle(); ?></h4>
        <p class="legend"><small><em><?php echo $translator->get('shop.cart.quantity'); ?>1</em></small></p>
    </div>
    <div class="col-xs-12 col-sm-3 col-lg-2">
        <div><?php echo $product->getOrderedPlatform()->getFullName(); ?></div>
    </div>
    <div class="col-xs-12 col-sm-3 col-lg-3">
        <div><?php echo $product->getPrice(); ?> €</div>
        <span class="minicart-remove-item glyphicon glyphicon-remove"></span>
    </div>
</div>