<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-unstyled">
                    <li>&copy; 2016</li>
                    <li><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/mentions"><?php echo $translator->get('core.foot_menu.legals'); ?></a></li>
                    <li><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/cgv"><?php echo $translator->get('core.foot_menu.cgv'); ?></a></li>
                    <li><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/contact"><?php echo $translator->get('core.foot_menu.contact'); ?></a></li>
                    <li><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/sitemap"><?php echo $translator->get('core.foot_menu.sitemap'); ?></a></li>
                    <li>
                        <?php
                        $target_uri_fr = str_replace('/'.$translator->getLocale().'/', '/fr/', $this->app->getHttpRequest()->getRequestURI());
                        $target_uri_en = str_replace('/'.$translator->getLocale().'/', '/en/', $this->app->getHttpRequest()->getRequestURI());
                        ?>
                        <a href="<?php echo $target_uri_fr; ?>"><img class="locale_flag" src="<?php echo ROOTADDRESS; ?>/resources/img/flags/fr.png" alt="<?php echo $translator->get('core.foot_menu.switch_french'); ?>"></a>
                        <a href="<?php echo $target_uri_en; ?>"><img class="locale_flag" src="<?php echo ROOTADDRESS; ?>/resources/img/flags/en.png" alt="<?php echo $translator->get('core.foot_menu.switch_english'); ?>"></a>
                    </li>
                </ul>
            </div>
            <div class="author col-md-4">
                <ul class="list-unstyled">
                    <li><?php echo $translator->get('core.foot_menu.site_title'); ?></li>
                    <li><?php echo $translator->get('core.foot_menu.made_by'); ?></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
