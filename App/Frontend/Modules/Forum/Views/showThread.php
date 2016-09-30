<h2>Discussion "<?php echo $thread->getTopic(); ?>"</h2>

<div class="table-responsive">
    <table class="table table-stripped table-hover table-bordered">
        <thead>
            <tr class="info">
                <td>Liste des message</td>
            </tr>
        </thead>

        <tfoot>
            <tr class="info">
                <td>
                    <?php
                    if ($threadNbPages == 0 || $threadNbPages == 1) {
                        echo 'Page : [ 1 ]';
                    } else {
                        echo 'Pages : ';
                        for ($i = 1; $i <= $threadNbPages; $i++) {
                            if ($i == $threadCurrentPage) {
                                echo ' [ ';
                            }
                    
                            echo '<a href="'.ROOTADDRESS.'/'.$translator->getLocale().'/forum/discussion/'.$thread->getSlug().'/page-'.$i.'"> '.$i.' </a>';
                    
                            if ($i == $threadCurrentPage) {
                                echo ' ] ';
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
        </tfoot>

        <tbody>
        <?php if ($thread->getNbPosts() === 0) : ?>
            <tr>
                <td>Aucun message dans cette discussion.</td>
            </tr>
        <?php else : ?>
            <?php foreach ($thread->getPosts() as $post) : ?>
                <tr>
                    <td>
                        <div><?php echo $post->getAuthor() ? $post->getAuthor()->getUsername() : 'traduire : user deleted'; ?></div>
                        <div>
                            <div>
                                <span>Posté le <?php echo $post->getCreatedAt(); ?></span>
                                <?php if ($post->getUpdatedAt()) : ?>
                                    <br><span>Modifié le <?php echo $post->getUpdatedAt(); ?>, par <?php echo $post->getModerator() ? $post->getModerator()->getUsername() : 'trad: user deleted'; ?></span>
                                <?php endif; ?>

                                <!-- Ajout des lien d'édition du post -->
                                <?php if ($this->app->isGranted($member, 'ROLE_MODERATOR')) : ?>
                                    - <span><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/forum/discussion/<?php echo $thread->getSlug(); ?>/edit-<?php echo $post->getId(); ?>">Modifier le message</a>
                                <?php elseif ($member == $post->getAuthor()) : ?>
                                    - <span><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/forum/discussion/<?php echo $thread->getSlug(); ?>/edit-<?php echo $post->getId(); ?>">Modifier mon message</a></span>
                                <?php endif; ?>
                            </div>
                            <br>
                            <div><?php echo nl2br($post->getContent()); ?></div>
                            <br>
                            <hr>
                            <!-- TODO : gestion signature -->
                            Signature...
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>


<!-- FORMULAIRE pour poster un message -->

<div>
    <?php if ($member->isAuthenticated()) : ?>
        <form action="" method="post">
            <?php echo $formPost; ?>
            <input type="submit" value="Poster" />
        </form>
    <?php else : ?>
        <p>
            Vous devez être authentifié pour poster un message. <br>
            Connectez-vous si vous avez déjà un compte : <a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/login">J'y vais !</a><br>
            Vous n'avez pas encore de compte ? <a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/login">Je m'inscris !</a>
        </p>
    <?php endif; ?>
</div>

<a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/forum">Retour à l'accueil du Forum</a><br>

<script src="<?php echo ROOTADDRESS; ?>/resources/js/tinymce/tinymce.js"></script>
<script src="<?php echo ROOTADDRESS; ?>/resources/js/my_tinymce.js"></script>