<h1><?php echo $translator->get('section_title.shop.all_games'); ?></h1>

<div class="row">
    <div class="col-md-3">
        <div id="menu-filters">
            <?php require_once __DIR__.'/../../../../../resources/partials/menu_filters.php'; ?>
        </div>
    </div>
    <div class="col-md-9">
        <div id="games-list">
            <div class="row">
                <?php
                $loopIndex = 0;
                foreach ($allGames as $game) {
                    if ($loopIndex != 0 && $loopIndex % 3 == 0) {
                        echo '</div>';
                        echo '<div class="row">';
                    }
                    include __DIR__.'/../../../../../resources/partials/product_item.php';
                    $loopIndex++;
                }
                ?>
            </div>
        </div>
    </div>
</div>