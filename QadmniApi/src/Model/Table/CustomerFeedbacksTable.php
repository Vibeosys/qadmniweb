<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerFeedbacks Model
 *
 * @method \App\Model\Entity\CustomerFeedback get($primaryKey, $options = [])
 * @method \App\Model\Entity\CustomerFeedback newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CustomerFeedback[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CustomerFeedback|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CustomerFeedback patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerFeedback[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerFeedback findOrCreate($search, callable $callback = null, $options = [])
 */
class CustomerFeedbacksTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('customer_feedbacks');
        $this->displayField('FeedbackId');
        $this->primaryKey('FeedbackId');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('FeedbackId')
                ->allowEmpty('FeedbackId', 'create');

        $validator
                ->integer('ItemId')
                ->requirePresence('ItemId', 'create')
                ->notEmpty('ItemId');

        $validator
                ->integer('CustomerId')
                ->requirePresence('CustomerId', 'create')
                ->notEmpty('CustomerId');

        $validator
                ->numeric('Rating')
                ->requirePresence('Rating', 'create')
                ->notEmpty('Rating');

        $validator
                ->integer('IsActive')
                ->requirePresence('IsActive', 'create')
                ->notEmpty('IsActive');

        return $validator;
    }

    /**
     * Get item rating for all items in array
     * @param array $itemIdList
     * @return \App\Dto\ItemRatingReviewDto
     */
    public function getItemRatings($itemIdList) {
        $itemRatingReviewList = [];
        $dbItemRatingList = $this->find()
                        ->where(['ItemId IN' => $itemIdList])
                        ->select(['ItemId', 'TotalRating' => 'SUM(Rating)', 'TotalReviews' => 'COUNT(ItemId)'])
                        ->group(['ItemId'])->all();

        foreach ($dbItemRatingList as $dbRatingItem) {
            $itemRatingReview = new \App\Dto\ItemRatingReviewDto();
            $itemRatingReview->itemId = $dbRatingItem->ItemId;
            $itemRatingReview->totalRating = $dbRatingItem->TotalRating;
            $itemRatingReview->totalReviews = $dbRatingItem->TotalReviews;

            array_push($itemRatingReviewList, $itemRatingReview);
        }

        return $itemRatingReviewList;
    }

    /**
     * Adds or updates reviews for items
     * @param \App\Dto\ReviewItemDto $reviewItems
     * @param int $customerId 
     * @param int $orderId
     */
    public function addOrUpdateReviews($reviewItems, $customerId, $orderId) {
        $reviewAddedOrUpdated = true;
        foreach ($reviewItems as $reviewItem) {
            $dbReview = $this->find()
                    ->where(['ItemId' => $reviewItem->itemId , 'CustomerId' => $customerId, 'OrderId' => $orderId])
                    ->select(['FeedbackId', 'ItemId', 'Rating'])
                    ->first();

            if ($dbReview) {
                $dbReview->rating = $reviewItem->rating;
            } else {
                $dbReview = $this->newEntity();
                $dbReview->CustomerId = $customerId;
                $dbReview->ItemId = $reviewItem->itemId;
                $dbReview->Rating = $reviewItem->rating;
                $dbReview->OrderId = $orderId;
            }

            if ($this->save($dbReview)) {
                $reviewAddedOrUpdated &=true;
            } else {
                $reviewAddedOrUpdated &=false;
            }
        }
        
        return $reviewAddedOrUpdated;
    }

}
