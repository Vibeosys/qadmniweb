<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Producer'), ['action' => 'edit', $producer->ProducerId]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Producer'), ['action' => 'delete', $producer->ProducerId], ['confirm' => __('Are you sure you want to delete # {0}?', $producer->ProducerId)]) ?> </li>
        <li><?= $this->Html->link(__('List Producer'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Producer'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="producer view large-9 medium-8 columns content">
    <h3><?= h($producer->ProducerId) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($producer->Name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('EmailId') ?></th>
            <td><?= h($producer->EmailId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($producer->Password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('BusinessName En') ?></th>
            <td><?= h($producer->BusinessName_En) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('BusinessName Ar') ?></th>
            <td><?= h($producer->BusinessName_Ar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ProducerOsVersionType') ?></th>
            <td><?= h($producer->ProducerOsVersionType) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ProducerId') ?></th>
            <td><?= $this->Number->format($producer->ProducerId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= $this->Number->format($producer->Latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= $this->Number->format($producer->Longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsActive') ?></th>
            <td><?= $this->Number->format($producer->IsActive) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CreatedOn') ?></th>
            <td><?= h($producer->CreatedOn) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($producer->Address)); ?>
    </div>
    <div class="row">
        <h4><?= __('ProducerPushId') ?></h4>
        <?= $this->Text->autoParagraph(h($producer->ProducerPushId)); ?>
    </div>
</div>
