<h1><?php echo $translator->get('section_title.shop.checkout'); ?></h1>

<div id="checkout-content">
    <div class="infos col-xs-12 col-md-9">
        <form id="checkout-form" action="" method="post">
            <?php echo $checkoutForm; ?>
            <br>
            <button class="btn btn-primary my-btn-primary pull-right" type="submit">
                <span class="glyphicon glyphicon-shopping-cart"></span> <?php echo $translator->get('form.checkout.submit'); ?>
            </button>
        </form>
    </div>
    <div class="total col-xs-12 col-md-3">
        <?php include __DIR__.'/../../../../../resources/partials/cart_total.php'; ?>
    </div>
</div>