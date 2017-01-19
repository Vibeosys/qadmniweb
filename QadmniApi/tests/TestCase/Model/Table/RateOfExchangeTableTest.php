<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RateOfExchangeTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RateOfExchangeTable Test Case
 */
class RateOfExchangeTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RateOfExchangeTable
     */
    public $RateOfExchange;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rate_of_exchange'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RateOfExchange') ? [] : ['className' => 'App\Model\Table\RateOfExchangeTable'];
        $this->RateOfExchange = TableRegistry::get('RateOfExchange', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RateOfExchange);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
