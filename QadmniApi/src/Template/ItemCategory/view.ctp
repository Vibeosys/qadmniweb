<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item Category'), ['action' => 'edit', $itemCategory->CategoryId]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item Category'), ['action' => 'delete', $itemCategory->CategoryId], ['confirm' => __('Are you sure you want to delete # {0}?', $itemCategory->CategoryId)]) ?> </li>
        <li><?= $this->Html->link(__('List Item Category'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Category'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="itemCategory view large-9 medium-8 columns content">
    <h3><?= h($itemCategory->CategoryId) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('CategoryName En') ?></th>
            <td><?= h($itemCategory->CategoryName_En) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CategoryName Ar') ?></th>
            <td><?= h($itemCategory->CategoryName_Ar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CategoryId') ?></th>
            <td><?= $this->Number->format($itemCategory->CategoryId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsActive') ?></th>
            <td><?= $this->Number->format($itemCategory->IsActive) ?></td>
        </tr>
    </table>
</div>
