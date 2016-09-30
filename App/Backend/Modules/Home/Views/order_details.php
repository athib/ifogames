<p>
    <?php echo $this->app->getTranslator()->get('modal.order_details.ordered_by') ?> : <?php echo $customer->getUsername(); ?>
    <br />date : <?php echo $order->getCreatedAt()->format('d/m/Y H:i'); ?>
    <ul>
    <?php
    foreach ($order->getGames() as $game) {
        echo '<li>'.$game->getTitle().' ('.$game->getOrderedPlatform()->getShortName().'), '.$game->getPrice().' €</li>';
    }
    ?>
    </ul>
</p>