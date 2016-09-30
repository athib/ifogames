<?php
// TODO : traductions + charger JS depuis les controlleurs

if (!$member->isAuthenticated()) {
    $this->app->getHTTPResponse()->redirect(ROOTADDRESS.'/'.$translator->getLocale().'forum');
}
?>

<h2>Edition d'un message</h2>

<div>
    <?php if ($this->app->isGranted($member, 'ROLE_MODERATOR') || $member == $post->getAuthor()) : ?>
        <form action="" method="post">
            <?php echo $formPost; ?>
            <input type="submit" value="Modifier" />
        </form>
    <?php else : ?>
        <p>
            Vous devez être authentifié en tant que modérateur ou être l'auteur du message pour le modifier. <br>
            Connectez-vous si vous avez déjà un compte : <a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/login">J'y vais !</a><br>
            Vous n'avez pas encore de compte ? <a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/login">Je m'inscris !</a>
        </p>
    <?php endif; ?>
</div>

<a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/forum">Retour à l'accueil du Forum</a><br>

<script src="<?php echo ROOTADDRESS; ?>/resources/js/tinymce/tinymce.js"></script>
<script src="<?php echo ROOTADDRESS; ?>/resources/js/my_tinymce.js"></script>