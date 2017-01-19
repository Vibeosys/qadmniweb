<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RateOfExchangeFixture
 *
 */
class RateOfExchangeFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'rate_of_exchange';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'ROEDate' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'Rate' => ['type' => 'float', 'length' => 6, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'UpdatedOn' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['ROEDate'], 'length' => []],
            'ROEDate_UNIQUE' => ['type' => 'unique', 'columns' => ['ROEDate'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'ROEDate' => 'd338ca31-ab67-4509-a24d-a24b43db82ad',
            'Rate' => 1,
            'UpdatedOn' => '2017-01-19 12:11:08'
        ],
    ];
}
