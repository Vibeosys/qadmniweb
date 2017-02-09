<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliveryLog Entity
 *
 * @property int $AutoId
 * @property string $Api
 * @property int $OrderId
 * @property string $RequestJson
 * @property string $ResponseJson
 * @property string $ErrorCode
 * @property string $ErrorMessage
 * @property int $ProviderId
 * @property \Cake\I18n\Time $LogDateTime
 */
class DeliveryLog extends Entity
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
        'AutoId' => false
    ];
}
