<h3><?php echo $translator->get('shop.menu_filters.sort_results') ?></h3>

<h5><?php echo $translator->get('shop.menu_filters.applied_filters') ?></h5>
<div id="remove-filters"><span><?php echo $translator->get('shop.menu_filters.remove_filters') ?></span></div>
<div id="applied-filters"></div>

<h4><?php echo $translator->get('shop.menu_filters.sort_platforms') ?></h4>
<ul>
    <?php
    foreach ($platforms as $platform) {
        echo '<li class="filter-item" filter-type="platform" value="'.$platform->getFullName().'">'.$platform->getFullName().'</li>';
    }
    ?>
</ul>

<h4><?php echo $translator->get('shop.menu_filters.sort_genres') ?></h4>
<ul>
    <?php
    foreach ($genres as $genre) {
        echo '<li class="filter-item" filter-type="genre" value="'.$genre->getName().'">'.$genre->getName().'</li>';
    }
    ?>
</ul>