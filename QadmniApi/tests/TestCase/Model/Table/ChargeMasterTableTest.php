<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChargeMasterTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChargeMasterTable Test Case
 */
class ChargeMasterTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ChargeMasterTable
     */
    public $ChargeMaster;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.charge_master'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ChargeMaster') ? [] : ['className' => 'App\Model\Table\ChargeMasterTable'];
        $this->ChargeMaster = TableRegistry::get('ChargeMaster', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ChargeMaster);

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
