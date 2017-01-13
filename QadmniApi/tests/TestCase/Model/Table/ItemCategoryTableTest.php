<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemCategoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemCategoryTable Test Case
 */
class ItemCategoryTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemCategoryTable
     */
    public $ItemCategory;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.item_category'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ItemCategory') ? [] : ['className' => 'App\Model\Table\ItemCategoryTable'];
        $this->ItemCategory = TableRegistry::get('ItemCategory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemCategory);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
