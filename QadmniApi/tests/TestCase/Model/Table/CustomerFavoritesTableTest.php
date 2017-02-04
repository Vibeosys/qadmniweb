<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomerFavoritesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomerFavoritesTable Test Case
 */
class CustomerFavoritesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomerFavoritesTable
     */
    public $CustomerFavorites;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.customer_favorites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CustomerFavorites') ? [] : ['className' => 'App\Model\Table\CustomerFavoritesTable'];
        $this->CustomerFavorites = TableRegistry::get('CustomerFavorites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerFavorites);

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
