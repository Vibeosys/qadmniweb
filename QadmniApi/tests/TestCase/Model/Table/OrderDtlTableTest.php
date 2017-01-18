<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderDtlTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderDtlTable Test Case
 */
class OrderDtlTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderDtlTable
     */
    public $OrderDtl;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.order_dtl'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OrderDtl') ? [] : ['className' => 'App\Model\Table\OrderDtlTable'];
        $this->OrderDtl = TableRegistry::get('OrderDtl', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderDtl);

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
