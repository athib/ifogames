<table id="data-table" class="tablesorter">
    <thead>
        <tr>
            <th>id</th>
            <th>username</th>
            <th>firstname</th>
            <th>lastname</th>
            <th>email</th>
            <th>actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($members as $member) : ?>
        <tr class="accordion">
            <td class="id-member" value="<?php echo $member->getId() ?>"><?php echo $member->getId() ?></td>
            <td><?php echo $member->getUsername() ?></td>
            <td><?php echo $member->getFirstname() ?></td>
            <td><?php echo $member->getLastname() ?></td>
            <td><?php echo $member->getEmail() ?></td>
            <td class="text-center">
                <button class="action action-details btn btn-default my-btn-default" data-toggle="modal" data-target="#modal-infos" data-route="member-details" data-id="<?php echo $member->getId() ?>">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </button>
                <?php if ($member->getUsername() != 'admin') : ?>
                <button class="action action-delete btn btn-danger my-btn-danger">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>