<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Producer Entity
 *
 * @property int $ProducerId
 * @property string $Name
 * @property string $EmailId
 * @property string $Password
 * @property string $BusinessName_En
 * @property string $BusinessName_Ar
 * @property string $Address
 * @property float $Latitude
 * @property float $Longitude
 * @property \Cake\I18n\Time $CreatedOn
 * @property int $IsActive
 * @property string $ProducerPushId
 * @property string $ProducerOsVersionType
 */
class Producer extends Entity
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
        'ProducerId' => false
    ];
}
