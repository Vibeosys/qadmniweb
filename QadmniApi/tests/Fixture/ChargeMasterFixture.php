<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChargeMasterFixture
 *
 */
class ChargeMasterFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'charge_master';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'ChargeId' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'ChargeDetails' => ['type' => 'string', 'length' => 80, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'Percentage' => ['type' => 'float', 'length' => 4, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'Amount' => ['type' => 'float', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'IsActive' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ChargeType' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['ChargeId'], 'length' => []],
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
            'ChargeId' => 1,
            'ChargeDetails' => 'Lorem ipsum dolor sit amet',
            'Percentage' => 1,
            'Amount' => 1,
            'IsActive' => 1,
            'ChargeType' => ''
        ],
    ];
}
