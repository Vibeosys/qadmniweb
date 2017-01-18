<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Order Dtl'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="orderDtl index large-9 medium-8 columns content">
    <h3><?= __('Order Dtl') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('OrderDtlId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('OrderId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ItemId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ItemQty') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ItemUnitPrice') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ItemTotalPrice') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderDtl as $orderDtl): ?>
            <tr>
                <td><?= $this->Number->format($orderDtl->OrderDtlId) ?></td>
                <td><?= $this->Number->format($orderDtl->OrderId) ?></td>
                <td><?= $this->Number->format($orderDtl->ItemId) ?></td>
                <td><?= $this->Number->format($orderDtl->ItemQty) ?></td>
                <td><?= $this->Number->format($orderDtl->ItemUnitPrice) ?></td>
                <td><?= $this->Number->format($orderDtl->ItemTotalPrice) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $orderDtl->OrderDtlId]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderDtl->OrderDtlId]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderDtl->OrderDtlId], ['confirm' => __('Are you sure you want to delete # {0}?', $orderDtl->OrderDtlId)]) ?>
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
