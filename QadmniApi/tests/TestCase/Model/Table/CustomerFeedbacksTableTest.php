<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomerFeedbacksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomerFeedbacksTable Test Case
 */
class CustomerFeedbacksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomerFeedbacksTable
     */
    public $CustomerFeedbacks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.customer_feedbacks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CustomerFeedbacks') ? [] : ['className' => 'App\Model\Table\CustomerFeedbacksTable'];
        $this->CustomerFeedbacks = TableRegistry::get('CustomerFeedbacks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerFeedbacks);

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
