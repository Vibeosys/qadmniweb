<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $itemCategory->CategoryId],
                ['confirm' => __('Are you sure you want to delete # {0}?', $itemCategory->CategoryId)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Item Category'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="itemCategory form large-9 medium-8 columns content">
    <?= $this->Form->create($itemCategory) ?>
    <fieldset>
        <legend><?= __('Edit Item Category') ?></legend>
        <?php
            echo $this->Form->input('CategoryName_En');
            echo $this->Form->input('CategoryName_Ar');
            echo $this->Form->input('IsActive');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
