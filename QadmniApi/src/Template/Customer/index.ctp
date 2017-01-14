<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="customer index large-9 medium-8 columns content">
    <h3><?= __('Customer') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('CustomerId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Password') ?></th>
                <th scope="col"><?= $this->Paginator->sort('EmailId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('CreatedDate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('OsVersionType') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customer as $customer): ?>
            <tr>
                <td><?= $this->Number->format($customer->CustomerId) ?></td>
                <td><?= h($customer->Name) ?></td>
                <td><?= $this->Number->format($customer->Phone) ?></td>
                <td><?= h($customer->Password) ?></td>
                <td><?= h($customer->EmailId) ?></td>
                <td><?= h($customer->CreatedDate) ?></td>
                <td><?= h($customer->OsVersionType) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $customer->CustomerId]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $customer->CustomerId]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $customer->CustomerId], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->CustomerId)]) ?>
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
