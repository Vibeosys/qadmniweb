<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerFeedback Entity
 *
 * @property int $FeedbackId
 * @property int $ItemId
 * @property int $CustomerId
 * @property float $Rating
 * @property int $IsActive
 * @property int $OrderId 
 */
class CustomerFeedback extends Entity
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
        'FeedbackId' => false
    ];
}
