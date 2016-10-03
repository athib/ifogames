<section class="page-section row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $translator->get('section_title.user.login'); ?></h2>
        <form id="form_login" action="" method="post">
            <?php echo $formLogin; ?>
            <!--<a class="forget-link pull-left" href="#"><?php //echo $translator->get('user.login_form.forgot'); ?></a>-->
            <button class="btn btn-primary my-btn-primary pull-right" type="submit">
                <span class="glyphicon glyphicon-lock"></span> <?php echo $translator->get('user.login_form.submit_btn'); ?>
            </button>
        </form>
    </div>
</section>
