<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Producer'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="producer index large-9 medium-8 columns content">
    <h3><?= __('Producer') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('ProducerId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('EmailId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Password') ?></th>
                <th scope="col"><?= $this->Paginator->sort('BusinessName_En') ?></th>
                <th scope="col"><?= $this->Paginator->sort('BusinessName_Ar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Latitude') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Longitude') ?></th>
                <th scope="col"><?= $this->Paginator->sort('CreatedOn') ?></th>
                <th scope="col"><?= $this->Paginator->sort('IsActive') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ProducerOsVersionType') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($producer as $producer): ?>
            <tr>
                <td><?= $this->Number->format($producer->ProducerId) ?></td>
                <td><?= h($producer->Name) ?></td>
                <td><?= h($producer->EmailId) ?></td>
                <td><?= h($producer->Password) ?></td>
                <td><?= h($producer->BusinessName_En) ?></td>
                <td><?= h($producer->BusinessName_Ar) ?></td>
                <td><?= $this->Number->format($producer->Latitude) ?></td>
                <td><?= $this->Number->format($producer->Longitude) ?></td>
                <td><?= h($producer->CreatedOn) ?></td>
                <td><?= $this->Number->format($producer->IsActive) ?></td>
                <td><?= h($producer->ProducerOsVersionType) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $producer->ProducerId]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $producer->ProducerId]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $producer->ProducerId], ['confirm' => __('Are you sure you want to delete # {0}?', $producer->ProducerId)]) ?>
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
