<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Item Category'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemCategory index large-9 medium-8 columns content">
    <h3><?= __('Item Category') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('CategoryId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('CategoryName_En') ?></th>
                <th scope="col"><?= $this->Paginator->sort('CategoryName_Ar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('IsActive') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itemCategory as $itemCategory): ?>
            <tr>
                <td><?= $this->Number->format($itemCategory->CategoryId) ?></td>
                <td><?= h($itemCategory->CategoryName_En) ?></td>
                <td><?= h($itemCategory->CategoryName_Ar) ?></td>
                <td><?= $this->Number->format($itemCategory->IsActive) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $itemCategory->CategoryId]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $itemCategory->CategoryId]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $itemCategory->CategoryId], ['confirm' => __('Are you sure you want to delete # {0}?', $itemCategory->CategoryId)]) ?>
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
