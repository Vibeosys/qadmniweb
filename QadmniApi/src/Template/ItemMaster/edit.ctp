<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $itemMaster->ItemId],
                ['confirm' => __('Are you sure you want to delete # {0}?', $itemMaster->ItemId)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Item Master'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="itemMaster form large-9 medium-8 columns content">
    <?= $this->Form->create($itemMaster) ?>
    <fieldset>
        <legend><?= __('Edit Item Master') ?></legend>
        <?php
            echo $this->Form->input('ItemName_En');
            echo $this->Form->input('ItemName_Ar');
            echo $this->Form->input('ItemDesc_En');
            echo $this->Form->input('ItemDesc_Ar');
            echo $this->Form->input('CategoryId');
            echo $this->Form->input('UnitPrice');
            echo $this->Form->input('OfferText');
            echo $this->Form->input('Rating');
            echo $this->Form->input('Reviews');
            echo $this->Form->input('VendorId');
            echo $this->Form->input('ImageUrl');
            echo $this->Form->input('IsActive');
            echo $this->Form->input('CreatedDate', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
