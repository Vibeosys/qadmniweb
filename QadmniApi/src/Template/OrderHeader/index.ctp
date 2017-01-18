<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Order Header'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="orderHeader index large-9 medium-8 columns content">
    <h3><?= __('Order Header') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('OrderId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('OrderDate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('CustomerId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('OrderQty') ?></th>
                <th scope="col"><?= $this->Paginator->sort('AmountSubTotal') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ProducerId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('TotalAmount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('DeliveryLat') ?></th>
                <th scope="col"><?= $this->Paginator->sort('DeliveryLong') ?></th>
                <th scope="col"><?= $this->Paginator->sort('DeliveryType') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderHeader as $orderHeader): ?>
            <tr>
                <td><?= $this->Number->format($orderHeader->OrderId) ?></td>
                <td><?= h($orderHeader->OrderDate) ?></td>
                <td><?= $this->Number->format($orderHeader->CustomerId) ?></td>
                <td><?= $this->Number->format($orderHeader->OrderQty) ?></td>
                <td><?= $this->Number->format($orderHeader->AmountSubTotal) ?></td>
                <td><?= $this->Number->format($orderHeader->Status) ?></td>
                <td><?= $this->Number->format($orderHeader->ProducerId) ?></td>
                <td><?= $this->Number->format($orderHeader->TotalAmount) ?></td>
                <td><?= $this->Number->format($orderHeader->DeliveryLat) ?></td>
                <td><?= $this->Number->format($orderHeader->DeliveryLong) ?></td>
                <td><?= h($orderHeader->DeliveryType) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $orderHeader->OrderId]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderHeader->OrderId]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderHeader->OrderId], ['confirm' => __('Are you sure you want to delete # {0}?', $orderHeader->OrderId)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
