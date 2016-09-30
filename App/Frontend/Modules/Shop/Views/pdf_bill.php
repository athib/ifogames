<h1>facture</h1>

<h2>infos membres</h2>
<?php echo $member->getFirstname().' '.$member->getLastname(); ?>

<h2>articles commandés</h2>
<?php
foreach ($cart->getProducts() as $product) {
    echo '<p>'.$product->getTitle().', '.$product->getPrice().'</p>';
}
?>

<h2>adresse de livraison</h2>
<?php echo $member->getMailingAddress()->getStreet(); ?>