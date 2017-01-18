<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $orderDtl->OrderDtlId],
                ['confirm' => __('Are you sure you want to delete # {0}?', $orderDtl->OrderDtlId)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Order Dtl'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="orderDtl form large-9 medium-8 columns content">
    <?= $this->Form->create($orderDtl) ?>
    <fieldset>
        <legend><?= __('Edit Order Dtl') ?></legend>
        <?php
            echo $this->Form->input('OrderId');
            echo $this->Form->input('ItemId');
            echo $this->Form->input('ItemQty');
            echo $this->Form->input('ItemUnitPrice');
            echo $this->Form->input('ItemTotalPrice');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
