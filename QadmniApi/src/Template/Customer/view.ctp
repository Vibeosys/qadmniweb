<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Customer'), ['action' => 'edit', $customer->CustomerId]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Customer'), ['action' => 'delete', $customer->CustomerId], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->CustomerId)]) ?> </li>
        <li><?= $this->Html->link(__('List Customer'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="customer view large-9 medium-8 columns content">
    <h3><?= h($customer->CustomerId) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($customer->Name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($customer->Password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('EmailId') ?></th>
            <td><?= h($customer->EmailId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('OsVersionType') ?></th>
            <td><?= h($customer->OsVersionType) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CustomerId') ?></th>
            <td><?= $this->Number->format($customer->CustomerId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= $this->Number->format($customer->Phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CreatedDate') ?></th>
            <td><?= h($customer->CreatedDate) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('PushId') ?></h4>
        <?= $this->Text->autoParagraph(h($customer->PushId)); ?>
    </div>
</div>
