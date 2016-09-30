<h3><?php echo $translator->get('shop.cart.order_summary') ?></h3>
<div class="summary">
    <ul class="list-games list-unstyled">
    <?php foreach ($cart->getProducts() as $product) : ?>
        <li><?php echo $product->getTitle(); ?> <small>(<?php echo $product->getOrderedPlatform()->getShortName(); ?></small>)</li>
    <?php endforeach; ?>
    </ul>
</div>
<div class="summary">
    <strong><?php echo $translator->get('shop.cart.total'); ?></strong>
    <span class="pull-right"><?php echo $cart->getTotal(); ?> €</span>
</div>
<br>
<?php $checkoutPage = $member->isAuthenticated() ? 'checkout' : 'before-checkout'; ?>
<a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale().'/shop/'.$checkoutPage ?>" class="btn btn-danger my-btn-danger col-xs-12 validate-cart"><?php echo $translator->get('shop.cart.checkout') ?></a>