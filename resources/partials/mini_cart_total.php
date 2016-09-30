<h4 class="subtotal"><span><?php echo $cart->getTotal(); ?></span> €</h4>

<?php $checkoutPage = $member->isAuthenticated() ? 'checkout' : 'before-checkout'; ?>

<a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/shop/cart" class="btn btn-default my-btn-default"><?php echo $translator->get('shop.minicart.see_cart'); ?></a>
<a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale().'/shop/'.$checkoutPage ?>" class="col-md-12 btn btn-danger my-btn-danger"><?php echo $translator->get('shop.minicart.checkout'); ?></a>