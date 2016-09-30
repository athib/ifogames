<h1><?php echo $translator->get('shop.cart.title'); ?></h1>

<div id="cart-content">
    <div class="col-xs-12 col-md-9">
        <div class="items-holder">
            <?php
            echo '<h6 class="no-products'.($cart->getNbProducts() > 0 ? ' no-display' : '').'">'.$translator->get('shop.minicart.no_items').'</h6>';
            if ($cart->getNbProducts() > 0) {
                include __DIR__.'/../../../../../resources/partials/cart_labels.php';
                foreach ($cart->getProducts() as $product) {
                    include __DIR__.'/../../../../../resources/partials/cart_item.php';
                }
            }
            ?>
        </div>
        <div class="separator"></div>
        <div class="cart-action">
            <a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/shop/all" class="btn btn-default my-btn-default">
                <span class="glyphicon glyphicon-chevron-left"></span> <?php echo $translator->get('shop.cart.back_shopping'); ?>
            </a>
            <?php if ($cart->getNbProducts() > 0) : ?>
            <a href="#" class="btn btn-default my-btn-default pull-right empty-cart">
                <span class="glyphicon glyphicon-trash"></span> <?php echo $translator->get('shop.minicart.empty_cart'); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-xs-12 col-md-3">
        <?php include __DIR__.'/../../../../../resources/partials/cart_total.php'; ?>
    </div>
</div>