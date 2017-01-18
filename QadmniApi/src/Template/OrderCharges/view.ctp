<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Order Charge'), ['action' => 'edit', $orderCharge->ChargeAutoId]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Order Charge'), ['action' => 'delete', $orderCharge->ChargeAutoId], ['confirm' => __('Are you sure you want to delete # {0}?', $orderCharge->ChargeAutoId)]) ?> </li>
        <li><?= $this->Html->link(__('List Order Charges'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Charge'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="orderCharges view large-9 medium-8 columns content">
    <h3><?= h($orderCharge->ChargeAutoId) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('ChargeAutoId') ?></th>
            <td><?= $this->Number->format($orderCharge->ChargeAutoId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('OrderId') ?></th>
            <td><?= $this->Number->format($orderCharge->OrderId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ChargeId') ?></th>
            <td><?= $this->Number->format($orderCharge->ChargeId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ChargePercent') ?></th>
            <td><?= $this->Number->format($orderCharge->ChargePercent) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ChargeAmount') ?></th>
            <td><?= $this->Number->format($orderCharge->ChargeAmount) ?></td>
        </tr>
    </table>
</div>
