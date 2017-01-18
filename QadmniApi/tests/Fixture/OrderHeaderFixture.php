<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderHeaderFixture
 *
 */
class OrderHeaderFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'order_header';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'OrderId' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'OrderDate' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'CustomerId' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'OrderQty' => ['type' => 'float', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'AmountSubTotal' => ['type' => 'float', 'length' => 7, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'Status' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ProducerId' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'TotalAmount' => ['type' => 'float', 'length' => 9, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'DeliveryAddress' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'DeliveryLat' => ['type' => 'float', 'length' => 9, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'DeliveryLong' => ['type' => 'float', 'length' => 9, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'DeliveryType' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['OrderId'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
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
            'OrderId' => 1,
            'OrderDate' => '2017-01-18 06:27:47',
            'CustomerId' => 1,
            'OrderQty' => 1,
            'AmountSubTotal' => 1,
            'Status' => 1,
            'ProducerId' => 1,
            'TotalAmount' => 1,
            'DeliveryAddress' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'DeliveryLat' => 1,
            'DeliveryLong' => 1,
            'DeliveryType' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
