<section class="page-section row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $translator->get('section_title.user.register'); ?></h2>
        <form id="form_register" action="" method="post">
            <?php echo $formRegister; ?>
            <button class="btn btn-primary my-btn-primary pull-right" type="submit">
                <span class="glyphicon glyphicon-lock"></span> <?php echo $translator->get('user.register_form.submit_btn'); ?>
            </button>
        </form>
    </div>
</section>