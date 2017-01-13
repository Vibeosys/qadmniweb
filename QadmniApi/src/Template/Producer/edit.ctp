<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $producer->ProducerId],
                ['confirm' => __('Are you sure you want to delete # {0}?', $producer->ProducerId)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Producer'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="producer form large-9 medium-8 columns content">
    <?= $this->Form->create($producer) ?>
    <fieldset>
        <legend><?= __('Edit Producer') ?></legend>
        <?php
            echo $this->Form->input('Name');
            echo $this->Form->input('EmailId');
            echo $this->Form->input('Password');
            echo $this->Form->input('BusinessName_En');
            echo $this->Form->input('BusinessName_Ar');
            echo $this->Form->input('Address');
            echo $this->Form->input('Latitude');
            echo $this->Form->input('Longitude');
            echo $this->Form->input('CreatedOn', ['empty' => true]);
            echo $this->Form->input('IsActive');
            echo $this->Form->input('ProducerPushId');
            echo $this->Form->input('ProducerOsVersionType');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
