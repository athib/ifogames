<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title><?php echo isset($pageTitle) ? $pageTitle : 'My Shop' ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo ROOTADDRESS; ?>/resources/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo ROOTADDRESS; ?>/resources/css/bootstrap-theme.css">
        <link rel="stylesheet" type="text/css" href="<?php echo ROOTADDRESS; ?>/resources/css/core.css">
        <link rel="stylesheet" type="text/css" href="<?php echo ROOTADDRESS; ?>/resources/css/popup.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo ROOTADDRESS; ?>/resources/css/select2.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo ROOTADDRESS; ?>/resources/css/mini_cart.css" />

        <?php
        if (isset($loadCss) && is_array($loadCss)) {
            foreach ($loadCss as $css) {
                echo '<link rel="stylesheet" type="text/css" href="'.ROOTADDRESS.'/resources/css/'.$css.'" />';
            }
        }
        ?>
    </head>
    <body>
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="row my_menu">
                            <?php require_once __DIR__ . '/../../resources/partials/app_menu.php'; ?>
                        </div>
                        <div class="row my_search" style="display: none;">
                            <div>
                                <form action="<?php echo ROOTADDRESS.'/'.$translator->getLocale().'/search'; ?>" method="post">
                                    <input type="text" name="search" placeholder="<?php echo $translator->get('core.main_menu.search'); ?>">
                                </form>
                            </div>
                        </div>
                        <div class="row my_banner">
                            <img id="banniere" src="<?php echo ROOTADDRESS; ?>/resources/img/games_banner.jpg" alt="Bannière"/>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="separator"></div>
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <?php
                        if ($this->app->getHTTPResponse()->hasFlashes()) {
                            echo '<div class="row my_flashbag">';

                            $flashes = $this->app->getHTTPResponse()->getFlashes();

                            foreach ($flashes as $type => $messages) {
                                echo '<div class="alert alert-' . $type . ' fade in">';
                                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                                foreach ($messages as $message) {
                                    echo $message, '<br>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        ?>
                        <div class="row my_main_content">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <div class="separator"></div>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="row">
                            <?php require_once __DIR__ . '/../../resources/partials/foot_menu.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        

        <script type="text/javascript" src="<?php echo ROOTADDRESS; ?>/resources/js/jquery-3.1.0.min.js"></script>
        <script type="text/javascript" src="<?php echo ROOTADDRESS; ?>/resources/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo ROOTADDRESS; ?>/resources/js/popup.js"></script>
        <script type="text/javascript" src="<?php echo ROOTADDRESS; ?>/resources/js/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo ROOTADDRESS; ?>/resources/js/core.js"></script>

        <?php
        if (isset($loadJs) && is_array($loadJs)) {
            foreach ($loadJs as $js) {
                echo '<script type="text/javascript" src="'.ROOTADDRESS.'/resources/js/'.$js.'"></script>';
            }
        }
        ?>
        
    </body>
</html>
