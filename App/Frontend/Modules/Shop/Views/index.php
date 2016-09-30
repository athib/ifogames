<h1><?php echo $translator->get('section_title.shop.home'); ?></h1>


<!-- SECTION DERNIERS JEUX -->

<h2 class="section-title"><span><?php echo $translator->get('shop.home.last_games'); ?></span></h2>

<div class="row">
<?php
$loopIndex = 0;
$columnWidth = 4; // nécessaire pour inclure product_item.php
foreach ($allGames as $game) {
    if ($loopIndex % 3 == 0) {
        echo '</div>';
        echo '<div class="row">';
    }
    include __DIR__.'/../../../../../resources/partials/product_item.php';
    $loopIndex++;
}
?>
</div>

<div class="separator"></div>

<!-- SECTION LES PLUS VENDUS -->

<h2 class="section-title"><span><?php echo $translator->get('shop.home.most_sold'); ?></span></h2>

<div class="row">
    <?php
    $loopIndex = 0;
    $columnWidth = 4; // nécessaire pour inclure product_item.php
    foreach ($mostSoldGames as $game) {
        if ($loopIndex % 3 == 0) {
            echo '</div>';
            echo '<div class="row">';
        }
        include __DIR__.'/../../../../../resources/partials/product_item.php';
        $loopIndex++;
    }
    ?>
</div>

<div class="separator"></div>

<div class="row-centered">
    <a class="btn btn-primary my-btn-primary" href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/shop/all"><?php echo $translator->get('shop.home.view_all'); ?></a>
</div>