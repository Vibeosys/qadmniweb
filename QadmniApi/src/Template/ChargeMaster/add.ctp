<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Charge Master'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="chargeMaster form large-9 medium-8 columns content">
    <?= $this->Form->create($chargeMaster) ?>
    <fieldset>
        <legend><?= __('Add Charge Master') ?></legend>
        <?php
            echo $this->Form->input('ChargeDetails');
            echo $this->Form->input('Percentage');
            echo $this->Form->input('Amount');
            echo $this->Form->input('IsActive');
            echo $this->Form->input('ChargeType');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
