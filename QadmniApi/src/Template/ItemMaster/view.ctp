<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item Master'), ['action' => 'edit', $itemMaster->ItemId]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item Master'), ['action' => 'delete', $itemMaster->ItemId], ['confirm' => __('Are you sure you want to delete # {0}?', $itemMaster->ItemId)]) ?> </li>
        <li><?= $this->Html->link(__('List Item Master'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Master'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="itemMaster view large-9 medium-8 columns content">
    <h3><?= h($itemMaster->ItemId) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('ItemName En') ?></th>
            <td><?= h($itemMaster->ItemName_En) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ItemName Ar') ?></th>
            <td><?= h($itemMaster->ItemName_Ar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ItemDesc En') ?></th>
            <td><?= h($itemMaster->ItemDesc_En) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ItemDesc Ar') ?></th>
            <td><?= h($itemMaster->ItemDesc_Ar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('OfferText') ?></th>
            <td><?= h($itemMaster->OfferText) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ItemId') ?></th>
            <td><?= $this->Number->format($itemMaster->ItemId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CategoryId') ?></th>
            <td><?= $this->Number->format($itemMaster->CategoryId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('UnitPrice') ?></th>
            <td><?= $this->Number->format($itemMaster->UnitPrice) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rating') ?></th>
            <td><?= $this->Number->format($itemMaster->Rating) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reviews') ?></th>
            <td><?= $this->Number->format($itemMaster->Reviews) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('VendorId') ?></th>
            <td><?= $this->Number->format($itemMaster->VendorId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsActive') ?></th>
            <td><?= $this->Number->format($itemMaster->IsActive) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CreatedDate') ?></th>
            <td><?= h($itemMaster->CreatedDate) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('ImageUrl') ?></h4>
        <?= $this->Text->autoParagraph(h($itemMaster->ImageUrl)); ?>
    </div>
</div>
