<table id="data-table" class="tablesorter">
    <thead>
        <tr>
            <th>id</th>
            <th>date</th>
            <th>total</th>
            <th>actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($orders as $order) : ?>
        <tr>
            <td class="id-order" value="<?php echo $order->getId(); ?>"><?php echo $order->getId(); ?></td>
            <td><?php echo $order->getCreatedAt()->format('d/m/Y H:i'); ?></td>
            <td><?php echo $order->getTotal(); ?> €</td>
            <td class="text-center">
                <button class="action action-details btn btn-default my-btn-default" data-toggle="modal" data-target="#modal-infos" data-route="order-details" data-id="<?php echo $order->getId(); ?>">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>