<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Item Master'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemMaster index large-9 medium-8 columns content">
    <h3><?= __('Item Master') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('ItemId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ItemName_En') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ItemName_Ar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ItemDesc_En') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ItemDesc_Ar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('CategoryId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('UnitPrice') ?></th>
                <th scope="col"><?= $this->Paginator->sort('OfferText') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Rating') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Reviews') ?></th>
                <th scope="col"><?= $this->Paginator->sort('VendorId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('IsActive') ?></th>
                <th scope="col"><?= $this->Paginator->sort('CreatedDate') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itemMaster as $itemMaster): ?>
            <tr>
                <td><?= $this->Number->format($itemMaster->ItemId) ?></td>
                <td><?= h($itemMaster->ItemName_En) ?></td>
                <td><?= h($itemMaster->ItemName_Ar) ?></td>
                <td><?= h($itemMaster->ItemDesc_En) ?></td>
                <td><?= h($itemMaster->ItemDesc_Ar) ?></td>
                <td><?= $this->Number->format($itemMaster->CategoryId) ?></td>
                <td><?= $this->Number->format($itemMaster->UnitPrice) ?></td>
                <td><?= h($itemMaster->OfferText) ?></td>
                <td><?= $this->Number->format($itemMaster->Rating) ?></td>
                <td><?= $this->Number->format($itemMaster->Reviews) ?></td>
                <td><?= $this->Number->format($itemMaster->VendorId) ?></td>
                <td><?= $this->Number->format($itemMaster->IsActive) ?></td>
                <td><?= h($itemMaster->CreatedDate) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $itemMaster->ItemId]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $itemMaster->ItemId]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $itemMaster->ItemId], ['confirm' => __('Are you sure you want to delete # {0}?', $itemMaster->ItemId)]) ?>
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
