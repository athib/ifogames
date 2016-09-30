<nav class="navbar navbar-default">
    <div class="container-fluid navbar-inner">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/"><?php echo $translator->get('core.main_menu.site_title'); ?></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li <?php if (isset($pageActive) && $pageActive === 'home') echo 'class="active"'; ?>><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/"><?php echo $translator->get('core.main_menu.home'); ?></a></li>
                <li <?php if (isset($pageActive) && $pageActive === 'shop') echo 'class="active"'; ?>><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/shop"><?php echo $translator->get('core.main_menu.shop'); ?></a></li>
                <li <?php if (isset($pageActive) && $pageActive === 'forum') echo 'class="active"'; ?>><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/forum"><?php echo $translator->get('core.main_menu.forum'); ?></a></li>
                <?php if ($this->app->isGranted($member, 'ROLE_ADMIN')) : ?>
                    <li role="separator" class="divider"></li>
                    <li <?php if (isset($pageActive) && $pageActive === 'admin') echo 'class="active"'; ?>><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/admin">
                            <span class="glyphicon glyphicon-wrench"></span> <?php echo $translator->get('core.main_menu.admin'); ?>
                        </a></li>
                <?php endif; ?>
            </ul>

            <ul id="cart-menu" class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="btn btn-default my-btn-default">
                        <?php $cart = new \Entity\Shop\Cart(); ?>
                        <span class="glyphicon glyphicon-shopping-cart"></span> (<span id="nb-cart-products"><?php echo $cart->getNbProducts(); ?></span>)
                    </a>
                    <div id="mini-cart" class="dropdown-menu">
                        <?php
                        echo '<h6 class="no-products'.($cart->getNbProducts() > 0 ? ' no-display' : '').'">'.$translator->get('shop.minicart.no_items').'</h6>';
                        echo '<div class="empty-cart'.($cart->getNbProducts() < 1 ? ' no-display' : '').'">'.$translator->get('shop.minicart.empty_cart').'<hr></div>';
                        echo '<ul id="cart-items">';
                        foreach ($cart->getProducts() as $product) {
                            include __DIR__.'/minicart_item.php';
                        }
                        echo '</ul>';
                        echo '<div class="mini-cart-total'.($cart->getNbProducts() < 1 ? ' no-display' : '').'"><hr>';
                        include __DIR__.'/mini_cart_total.php';
                        echo '</div>';
                        ?>
                    </div>
                </li>
                <li>
                    <a href="#" class="btn btn-default my-btn-default my-btn-search"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                </li>
            </ul>

            <ul id="user-menu" class="nav navbar-nav navbar-right">
                <?php if ($member && $member->isAuthenticated()) : ?>
                    <li class="dropdown">
                        <a href="#" class="welcome dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><span class="username"><?php echo $translator->get('core.main_menu.welcome', $member->getUsername()); ?></span> <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/profile"><span class="glyphicon glyphicon-user"></span> <?php echo $translator->get('core.main_menu.my_account'); ?></a></li>
                            <li role="separator" class="divider"></li>
                            <li><a id="form_logout" href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/logout">
                                    <span class="glyphicon glyphicon-log-out"></span> <?php echo $translator->get('core.main_menu.logout'); ?>
                                </a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/login"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> <?php echo $translator->get('core.main_menu.login'); ?></a></li>
                    <li><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/register"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo $translator->get('core.main_menu.register'); ?></a></li>
                <?php endif; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>