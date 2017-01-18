<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderCharge Entity
 *
 * @property int $ChargeAutoId
 * @property int $OrderId
 * @property int $ChargeId
 * @property float $ChargePercent
 * @property float $ChargeAmount
 */
class OrderCharge extends Entity
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
        'ChargeAutoId' => false
    ];
}
