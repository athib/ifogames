<h1><?php echo $translator->get('section_title.user.profile'); ?></h1>

<div id="profile-content">
    <div class="profile-infos col-xs-12 col-md-9">

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
            <button action="edit" class="btn btn-default my-btn-default pull-right" name="profile-edit-infos">
                <span class="edit"><?php echo $translator->get('user.profile.edit_infos'); ?></span>
                <span class="validate" style="display: none;"><?php echo $translator->get('user.profile.validate'); ?></span>
            </button>
        </div>
        <br>

        <!-- PROFILE ADDRESS -->
        <div class="profile-address">
            <h2><?php echo $translator->get('user.profile.address'); ?></h2>

            <h4><?php echo $translator->get('user.profile.billing_address'); ?></h4>
            <div class="billing-address">
                <?php
                $address = $member->getBillingAddress();
                if ($address == null) {
                    echo '<p>'.$translator->get('user.profile.no_billing_address').'</p>';
                } else {
                    echo '<p>'.$address->getStreet().' '.$address->getPostalCode().' '.$address->getCity().'</p>';
                }
                ?>
            </div>
            <button action="edit" class="btn btn-default my-btn-default pull-right" name="profile-edit-billing-address">
                <span class="edit"><?php echo $translator->get('user.profile.edit'); ?></span>
                <span class="validate" style="display: none;"><?php echo $translator->get('user.profile.validate'); ?></span>
            </button>

            <br>
            <h4><?php echo $translator->get('user.profile.mailing_address'); ?></h4>
            <div class="mailing-address">
                <?php
                $address = $member->getMailingAddress();
                if ($address == null) {
                    echo '<p>'.$translator->get('user.profile.no_mailing_address').'</p>';
                } else {
                    echo '<p>'.$address->getStreet().' '.$address->getPostalCode().' '.$address->getCity().'</p>';
                }
                ?>
            </div>
            <button action="edit" class="btn btn-default my-btn-default pull-right" name="profile-edit-mailing-address">
                <span class="edit"><?php echo $translator->get('user.profile.edit'); ?></span>
                <span class="validate" style="display: none;"><?php echo $translator->get('user.profile.validate'); ?></span>
            </button>
        </div>
    </div>

    <!-- ORDERS SUMMARY -->
    <div class="profile-orders col-xs-12 col-md-3">
        <div class="list-orders">
            <p>blabla</p>
            <ul>
                <?php
                foreach ($member->getOrders() as $order) {
                    echo '<li>';
                    echo 'id : '.$order->getId().' - total :'.$order->getTotal();
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>