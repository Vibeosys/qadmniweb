<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderHeader Entity
 *
 * @property int $OrderId
 * @property \Cake\I18n\Time $OrderDate
 * @property int $CustomerId
 * @property float $OrderQty
 * @property float $AmountSubTotal
 * @property int $Status
 * @property int $ProducerId
 * @property float $TotalAmount
 * @property string $DeliveryAddress
 * @property float $DeliveryLat
 * @property float $DeliveryLong
 * @property string $DeliveryType
 */
class OrderHeader extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'OrderId' => false
    ];
}
