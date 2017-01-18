<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Order Charges'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="orderCharges form large-9 medium-8 columns content">
    <?= $this->Form->create($orderCharge) ?>
    <fieldset>
        <legend><?= __('Add Order Charge') ?></legend>
        <?php
            echo $this->Form->input('OrderId');
            echo $this->Form->input('ChargeId');
            echo $this->Form->input('ChargePercent');
            echo $this->Form->input('ChargeAmount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
