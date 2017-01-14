<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Customer'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="customer form large-9 medium-8 columns content">
    <?= $this->Form->create($customer) ?>
    <fieldset>
        <legend><?= __('Add Customer') ?></legend>
        <?php
            echo $this->Form->input('Name');
            echo $this->Form->input('Phone');
            echo $this->Form->input('Password');
            echo $this->Form->input('EmailId');
            echo $this->Form->input('CreatedDate', ['empty' => true]);
            echo $this->Form->input('PushId');
            echo $this->Form->input('OsVersionType');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
