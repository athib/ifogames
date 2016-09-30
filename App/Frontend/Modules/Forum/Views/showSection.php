<h2>Rubrique "<?php echo $section->getName(); ?>"</h2>

<h3>Liste des discussions</h3>

<div class="table-responsive">
    <table class="table table-stripped table-hover table-bordered">
        <thead>
            <tr class="info">
                <th colspan="2"></th>
                <th>Sujet</th>
                <th class="text-center">
                    <small>Réponses</small>
                </th>
                <th class="text-center">
                    <small>Vues</small>
                </th>
                <th class="text-center">
                    <small>Dernier message</small>
                </th>
            </tr>
        </thead>
        
        <tfoot>
            <tr class="info">
                <td colspan="6">
                    <?php
                    if($sectionNbPages == 0 || $sectionNbPages == 1)
                        echo 'Page : [ 1 ]';
                    else
                    {
                        echo 'Pages : ';
                        for($i = 1; $i <= $sectionNbPages; $i++)
                        {
                            if($i == $sectionCurrentPage)
                                echo ' [ ';
                            
                            echo '<a href="'.ROOTADDRESS.'/'.$translator->getLocale().'/forum/rubrique/' . $section->getSlug() . '/page-' . $i . '"> ' . $i . ' </a>';
                            
                            if($i == $sectionCurrentPage)
                                echo ' ] ';
                        }
                    }
                    ?>
                </td>
            </tr>
        </tfoot>
        
        <tbody>
            <?php
            $threads = $section->getThreads();
            if(empty($threads))
                echo '<tr><td colspan="6">Aucune discussion dans cette rubrique</td></tr>';
            else
            {
                $loop_index = 0;
                foreach($threads as $thread)
                {
                    ?>
                    <tr>
                        <td><?php echo $thread->getId(); ?></td>
                        <td>icon</td>
                        <td>
                            <p><a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/forum/discussion/<?php echo $thread->getSlug(); ?>"><span><?php echo $thread->getTopic(); ?></span></a></p>
                            <p>
                                <small>auteur : <span><?php echo $thread->getAuthor()->getUsername(); ?></span></small>
                            </p>
                        </td>
                        <td class="text-center"><?php echo $thread->getNbPosts() - 1; ?></td>
                        <td class="text-center">XXX vues</td>
                        <td>
                            <p>par <span>xxxxxxxxx</span></p>
                            <p><span>le xx/xx/xxxx</span></p>
                        </td>
                    </tr>
                    <?php
                    $loop_index++;
                }
            }
            ?>
        </tbody>
    </table>
</div>

<a href="<?php echo ROOTADDRESS; ?>/forum">Retour à l'accueil du Forum</a>
