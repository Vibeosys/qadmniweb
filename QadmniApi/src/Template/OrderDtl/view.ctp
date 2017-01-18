<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Order Dtl'), ['action' => 'edit', $orderDtl->OrderDtlId]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Order Dtl'), ['action' => 'delete', $orderDtl->OrderDtlId], ['confirm' => __('Are you sure you want to delete # {0}?', $orderDtl->OrderDtlId)]) ?> </li>
        <li><?= $this->Html->link(__('List Order Dtl'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Dtl'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="orderDtl view large-9 medium-8 columns content">
    <h3><?= h($orderDtl->OrderDtlId) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('OrderDtlId') ?></th>
            <td><?= $this->Number->format($orderDtl->OrderDtlId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('OrderId') ?></th>
            <td><?= $this->Number->format($orderDtl->OrderId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ItemId') ?></th>
            <td><?= $this->Number->format($orderDtl->ItemId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ItemQty') ?></th>
            <td><?= $this->Number->format($orderDtl->ItemQty) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ItemUnitPrice') ?></th>
            <td><?= $this->Number->format($orderDtl->ItemUnitPrice) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ItemTotalPrice') ?></th>
            <td><?= $this->Number->format($orderDtl->ItemTotalPrice) ?></td>
        </tr>
    </table>
</div>
