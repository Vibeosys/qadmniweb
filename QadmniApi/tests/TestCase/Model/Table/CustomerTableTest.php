<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomerTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomerTable Test Case
 */
class CustomerTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomerTable
     */
    public $Customer;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.customer'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Customer') ? [] : ['className' => 'App\Model\Table\CustomerTable'];
        $this->Customer = TableRegistry::get('Customer', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Customer);

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
