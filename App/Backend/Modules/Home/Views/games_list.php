<button id="add-game-btn" class="btn btn-primary my-btn-primary pull-right" data-toggle="modal" data-target="#modal-edit" data-route="game-add">ajouter jeu</button>

<table id="data-table" class="tablesorter">
    <thead>
        <tr>
            <th>titre</th>
            <th>editeur</th>
            <th>date de sortie</th>
            <th>prix</th>
            <th>actions</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($games as $game) : ?>
        <tr>
            <td><?php echo $game->getTitle(); ?></td>
            <td><?php echo $game->getEditor()->getName(); ?></td>
            <td><?php echo $game->getReleaseDate(); ?></td>
            <td><?php echo $game->getPrice(); ?> €</td>
            <td class="text-center">
                <button class="action action-details btn btn-default my-btn-default" data-toggle="modal" data-target="#modal-infos" data-route="game-details" data-id="<?php echo $game->getId(); ?>">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </button>
                <button class="action action-edit btn btn-primary my-btn-primary" data-toggle="modal" data-target="#modal-edit" data-route="game-add" data-id="<?php echo $game->getId(); ?>">
                    <span class="glyphicon glyphicon-edit"></span>
                </button>
                <button class="action action-delete btn btn-danger my-btn-danger" data-id="<?php echo $game->getId(); ?>">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>