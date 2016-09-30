<h1><?php echo $translator->get('section_title.forum.home'); ?></h1>

<?php
if (empty($categories)) {
    echo '<p>Désolé, le forum est vide :(</p>';
}
?>

<?php foreach ($categories as $category) : ?>
    <div class="table-responsive">
        <table class="table table-stripped table-hover table-bordered">
            <thead>
                <tr class="info">
                    <th></th>
                    <th><span><?php echo $category->getName(); ?></span></th>
                    <th class="text-center">
                        <small>Messages</small>
                    </th>
                    <th class="text-center">
                        <small>Dernière discussion</small>
                    </th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($category->getSections() as $section) : ?>
                    <tr>
                        <td><?php echo $section->getId(); ?></td>
                        <td>
                            <p>
                                <a href="<?php echo ROOTADDRESS.'/'.$translator->getLocale(); ?>/forum/rubrique/<?php echo $section->getSlug(); ?>"><span><?php echo $section->getName(); ?></span></a>
                            </p>
                            <p><?php echo $section->getDescription(); ?></p>
                        </td>
                        <td><?php echo $section->getNbPosts(); ?></td>
                        <td>
                            <?php if ($section->getLastThreadId()) : ?>
                                <p><a href="#"><?php echo 'Dernière discussion : ' . $section->getLastThreadId(); ?></a>
                                </p>
                                <p><span>le XX/XX/XXXX</span></p>
                            <?php else : ?>
                                <p>Aucune discussion</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>