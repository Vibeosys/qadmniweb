<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemMasterTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemMasterTable Test Case
 */
class ItemMasterTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemMasterTable
     */
    public $ItemMaster;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.item_master'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ItemMaster') ? [] : ['className' => 'App\Model\Table\ItemMasterTable'];
        $this->ItemMaster = TableRegistry::get('ItemMaster', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemMaster);

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
