<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Order Header'), ['action' => 'edit', $orderHeader->OrderId]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Order Header'), ['action' => 'delete', $orderHeader->OrderId], ['confirm' => __('Are you sure you want to delete # {0}?', $orderHeader->OrderId)]) ?> </li>
        <li><?= $this->Html->link(__('List Order Header'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Header'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="orderHeader view large-9 medium-8 columns content">
    <h3><?= h($orderHeader->OrderId) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('DeliveryType') ?></th>
            <td><?= h($orderHeader->DeliveryType) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('OrderId') ?></th>
            <td><?= $this->Number->format($orderHeader->OrderId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CustomerId') ?></th>
            <td><?= $this->Number->format($orderHeader->CustomerId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('OrderQty') ?></th>
            <td><?= $this->Number->format($orderHeader->OrderQty) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('AmountSubTotal') ?></th>
            <td><?= $this->Number->format($orderHeader->AmountSubTotal) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($orderHeader->Status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ProducerId') ?></th>
            <td><?= $this->Number->format($orderHeader->ProducerId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('TotalAmount') ?></th>
            <td><?= $this->Number->format($orderHeader->TotalAmount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('DeliveryLat') ?></th>
            <td><?= $this->Number->format($orderHeader->DeliveryLat) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('DeliveryLong') ?></th>
            <td><?= $this->Number->format($orderHeader->DeliveryLong) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('OrderDate') ?></th>
            <td><?= h($orderHeader->OrderDate) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('DeliveryAddress') ?></h4>
        <?= $this->Text->autoParagraph(h($orderHeader->DeliveryAddress)); ?>
    </div>
</div>
