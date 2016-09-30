<h1><?php echo $translator->get('core.page_title.payment') ?></h1>

<div id="checkout-content">

    <!-- RECAP INFOS -->

    <div class="infos col-xs-12 col-md-9">

        <!-- INFOS MEMBER -->
        <div class="profile-member">
            <h2><?php echo $translator->get('user.profile.infos'); ?></h2>
            <div class="infos-editable">
                <p><?php echo $translator->get('user.profile.username'); ?> : <?php echo $member->getUsername(); ?></p>
                <p><?php echo $translator->get('user.profile.firstname'); ?> : <?php echo $member->getFirstname(); ?></p>
                <p><?php echo $translator->get('user.profile.lastname'); ?> : <?php echo $member->getLastname(); ?></p>
                <p><?php echo $translator->get('user.profile.email'); ?> : <?php echo $member->getEmail(); ?></p>
                <p><?php echo $translator->get('user.profile.phone'); ?> : <?php echo $member->getPhone(); ?></p>
            </div>
        </div>
        <br>

        <!-- PROFILE ADDRESS -->
        <div class="profile-address">
            <h2><?php echo $translator->get('user.profile.address'); ?></h2>

            <h4><?php echo $translator->get('user.profile.billing_address'); ?></h4>
            <div class="billing-address">
                <?php
                echo '<p>'.$checkout->getBillingStreet().' '.$checkout->getBillingPostalCode().' '.$checkout->getBillingCity().'</p>';
                ?>
            </div>

            <br>
            <h4><?php echo $translator->get('user.profile.mailing_address'); ?></h4>
            <div class="mailing-address">
                <?php
                echo '<p>'.$checkout->getMailingStreet().' '.$checkout->getMailingPostalCode().' '.$checkout->getMailingCity().'</p>';
                ?>
            </div>
        </div>

        <form action="/ifogames/<?php echo $translator->getLocale(); ?>/shop/checkout/complete" method="post">
            <button class="btn btn-lg btn-primary my-btn-primary center-block">
                <span class="glyphicon glyphicon-piggy-bank"></span> <?php echo $translator->get('shop.payment.submit') ?>
            </button>
        </form>
    </div>


    <!-- RECAP PANIER -->

    <div class="total col-xs-12 col-md-3">
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
    </div>
</div>