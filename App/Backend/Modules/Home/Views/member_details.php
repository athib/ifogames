<p>
    <?php echo $this->app->getTranslator()->get('modal.members_details.phone', $member->getPhone()) ?>
    <br /><?php echo $this->app->getTranslator()->get('modal.members_details.billing_address') ?> : <?php echo $member->getBillingAddress(); ?>
    <br /><?php echo $this->app->getTranslator()->get('modal.members_details.mailing_address') ?> : <?php echo $member->getMailingAddress(); ?>
</p>