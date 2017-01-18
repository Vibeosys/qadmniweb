<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderHeaderTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderHeaderTable Test Case
 */
class OrderHeaderTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderHeaderTable
     */
    public $OrderHeader;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.order_header'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OrderHeader') ? [] : ['className' => 'App\Model\Table\OrderHeaderTable'];
        $this->OrderHeader = TableRegistry::get('OrderHeader', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderHeader);

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
