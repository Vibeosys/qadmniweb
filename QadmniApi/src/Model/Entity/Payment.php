<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property string $TransId
 * @property string $PaypalId
 * @property string $PaymentMethod
 * @property string $PaymentCurrency
 * @property float $Amount
 * @property int $OrderId
 * @property \Cake\I18n\Time $CreatedDate
 * @property int $PaymentStatus
 * @property int $PaymentType
 */
class Payment extends Entity
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
        'TransId' => false
    ];
}
