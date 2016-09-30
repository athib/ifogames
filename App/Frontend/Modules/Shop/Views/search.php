<div class="col-md-12">
    <h2><?php echo $translator->get('section_title.shop.search'); ?></h2>
    <p>
        <?php
        if (empty($games)) {
            echo $translator->get('home.search.no_results');
        } else {
            $loopIndex = 0;
            foreach ($games as $game) {
                if ($loopIndex != 0 && $loopIndex % 3 == 0) {
                    echo '</div>';
                    echo '<div class="row">';
                }
                include __DIR__.'/../../../../../resources/partials/product_item.php';
                $loopIndex++;
            }
        }
        ?>
    </p>
</div>