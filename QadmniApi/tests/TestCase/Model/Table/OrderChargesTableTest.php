<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderChargesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderChargesTable Test Case
 */
class OrderChargesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderChargesTable
     */
    public $OrderCharges;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.order_charges'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OrderCharges') ? [] : ['className' => 'App\Model\Table\OrderChargesTable'];
        $this->OrderCharges = TableRegistry::get('OrderCharges', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderCharges);

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
