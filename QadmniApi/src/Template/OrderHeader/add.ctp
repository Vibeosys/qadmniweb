<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Order Header'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="orderHeader form large-9 medium-8 columns content">
    <?= $this->Form->create($orderHeader) ?>
    <fieldset>
        <legend><?= __('Add Order Header') ?></legend>
        <?php
            echo $this->Form->input('OrderDate');
            echo $this->Form->input('CustomerId');
            echo $this->Form->input('OrderQty');
            echo $this->Form->input('AmountSubTotal');
            echo $this->Form->input('Status');
            echo $this->Form->input('ProducerId');
            echo $this->Form->input('TotalAmount');
            echo $this->Form->input('DeliveryAddress');
            echo $this->Form->input('DeliveryLat');
            echo $this->Form->input('DeliveryLong');
            echo $this->Form->input('DeliveryType');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
