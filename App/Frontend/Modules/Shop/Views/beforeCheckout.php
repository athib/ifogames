<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
    <h1><?php echo $translator->get('shop.checkout_start.title'); ?></h1>
    <br>
    <p><?php echo $translator->get('shop.checkout_start.explain'); ?></p>
    <br>
    <div>
        <a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/login" class="btn btn-default my-btn-default">
            <span class="glyphicon glyphicon-log-in"></span> <?php echo $translator->get('user.login_form.title'); ?>
        </a>
        <a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/register" class="btn btn-default my-btn-default pull-right">
            <span class="glyphicon glyphicon-plus"></span> <?php echo $translator->get('user.register_form.title'); ?>
        </a>
    </div>
</div>