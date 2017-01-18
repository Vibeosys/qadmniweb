<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Order Charge'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="orderCharges index large-9 medium-8 columns content">
    <h3><?= __('Order Charges') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('ChargeAutoId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('OrderId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ChargeId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ChargePercent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ChargeAmount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderCharges as $orderCharge): ?>
            <tr>
                <td><?= $this->Number->format($orderCharge->ChargeAutoId) ?></td>
                <td><?= $this->Number->format($orderCharge->OrderId) ?></td>
                <td><?= $this->Number->format($orderCharge->ChargeId) ?></td>
                <td><?= $this->Number->format($orderCharge->ChargePercent) ?></td>
                <td><?= $this->Number->format($orderCharge->ChargeAmount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $orderCharge->ChargeAutoId]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderCharge->ChargeAutoId]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderCharge->ChargeAutoId], ['confirm' => __('Are you sure you want to delete # {0}?', $orderCharge->ChargeAutoId)]) ?>
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
