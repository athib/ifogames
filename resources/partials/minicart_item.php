<li class="row cart-item">
    <div class="product-thumb col-md-4">
        <img src="<?php echo ROOTADDRESS; ?>/resources/img/games/<?php echo $product->getJacket(); ?>" alt="<?php echo $product->getTitle(); ?>" />
    </div>
    <div class="product-infos col-md-8">
        <input type="hidden" class="id-game" value="<?php echo $product->getId(); ?>">
        <input type="hidden" class="id-platform" value="<?php echo $product->getOrderedPlatform()->getId(); ?>">
        <h6 class="product-title"><?php echo $product->getTitle(); ?><br><small><?php echo $product->getOrderedPlatform()->getShortName(); ?></small></h6>
        <div class="price"><?php echo $product->getPrice(); ?> €</div>
        <span class="minicart-remove-item glyphicon glyphicon-remove"></span>
    </div>
</li>