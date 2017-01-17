<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemMaster Entity
 *
 * @property int $ItemId
 * @property string $ItemName_En
 * @property string $ItemName_Ar
 * @property string $ItemDesc_En
 * @property string $ItemDesc_Ar
 * @property int $CategoryId
 * @property float $UnitPrice
 * @property string $OfferText
 * @property float $Rating
 * @property int $Reviews
 * @property int $VendorId
 * @property string $ImageUrl
 * @property int $IsActive
 * @property int $ProducerId 
 * @property \Cake\I18n\Time $CreatedDate
 */
class ItemMaster extends Entity
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
        'ItemId' => false
    ];
}
