<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeliveryLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeliveryLogsTable Test Case
 */
class DeliveryLogsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DeliveryLogsTable
     */
    public $DeliveryLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.delivery_logs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DeliveryLogs') ? [] : ['className' => 'App\Model\Table\DeliveryLogsTable'];
        $this->DeliveryLogs = TableRegistry::get('DeliveryLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DeliveryLogs);

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
