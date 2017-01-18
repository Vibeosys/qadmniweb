<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Charge Master'), ['action' => 'edit', $chargeMaster->ChargeId]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Charge Master'), ['action' => 'delete', $chargeMaster->ChargeId], ['confirm' => __('Are you sure you want to delete # {0}?', $chargeMaster->ChargeId)]) ?> </li>
        <li><?= $this->Html->link(__('List Charge Master'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Charge Master'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="chargeMaster view large-9 medium-8 columns content">
    <h3><?= h($chargeMaster->ChargeId) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('ChargeDetails') ?></th>
            <td><?= h($chargeMaster->ChargeDetails) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ChargeType') ?></th>
            <td><?= h($chargeMaster->ChargeType) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ChargeId') ?></th>
            <td><?= $this->Number->format($chargeMaster->ChargeId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Percentage') ?></th>
            <td><?= $this->Number->format($chargeMaster->Percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($chargeMaster->Amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsActive') ?></th>
            <td><?= $this->Number->format($chargeMaster->IsActive) ?></td>
        </tr>
    </table>
</div>
