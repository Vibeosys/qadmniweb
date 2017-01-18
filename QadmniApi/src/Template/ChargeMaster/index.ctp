<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Charge Master'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="chargeMaster index large-9 medium-8 columns content">
    <h3><?= __('Charge Master') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('ChargeId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ChargeDetails') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Percentage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('IsActive') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ChargeType') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chargeMaster as $chargeMaster): ?>
            <tr>
                <td><?= $this->Number->format($chargeMaster->ChargeId) ?></td>
                <td><?= h($chargeMaster->ChargeDetails) ?></td>
                <td><?= $this->Number->format($chargeMaster->Percentage) ?></td>
                <td><?= $this->Number->format($chargeMaster->Amount) ?></td>
                <td><?= $this->Number->format($chargeMaster->IsActive) ?></td>
                <td><?= h($chargeMaster->ChargeType) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $chargeMaster->ChargeId]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $chargeMaster->ChargeId]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $chargeMaster->ChargeId], ['confirm' => __('Are you sure you want to delete # {0}?', $chargeMaster->ChargeId)]) ?>
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
