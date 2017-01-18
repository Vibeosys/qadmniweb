<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderDtl Entity
 *
 * @property int $OrderDtlId
 * @property int $OrderId
 * @property int $ItemId
 * @property int $ItemQty
 * @property float $ItemUnitPrice
 * @property float $ItemTotalPrice
 */
class OrderDtl extends Entity
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
        'OrderDtlId' => false
    ];
}
