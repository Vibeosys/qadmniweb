<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * CustomerFeedbacks Controller
 *
 * @property \App\Model\Table\CustomerFeedbacksTable $CustomerFeedbacks
 */
class CustomerFeedbacksController extends AppController {

    public function submitFeedback() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }
        
        $submitFeedbackRequest = \App\Dto\Requests\SubmitFeedbackRequestDto::Deserialize($this->postedData);

        $operateReviews = $this->CustomerFeedbacks->addOrUpdateReviews($submitFeedbackRequest->items, 
                $this->postedCustomerData->customerId, $submitFeedbackRequest->orderId);
        $itemArray = $this->_getItemArray($submitFeedbackRequest->items);
        $itemRatings = $this->CustomerFeedbacks->getItemRatings($itemArray);
        $this->_updateAvgRating($itemRatings);
        
        $itemMasterTable = new \App\Model\Table\ItemMasterTable();
        $itemRatingsUpdated = $itemMasterTable->updateItemRatings($itemRatings);
        if($itemRatingsUpdated){
            $this->response->body(\App\Utils\ResponseMessages::prepareSuccessMessage(225));   
        }
        else{
            $this->response->body(\App\Utils\ResponseMessages::prepareError(130));
        }
    }

    /**
     * Get item id array from the request
     * @param \App\Dto\ReviewItemDto $submittedReviews
     * @return array
     */
    private function _getItemArray($submittedReviews) {
        $itemArray = [];
        foreach ($submittedReviews as $review) {
            array_push($itemArray, $review->itemId);
        }
        return $itemArray;
    }

    /**
     * Updates the avg rating 
     * @param \App\Dto\ItemRatingReviewDto $itemRatings
     */
    private function _updateAvgRating($itemRatings) {
        foreach ($itemRatings as $itemRating) {
            $mean = $itemRating->totalRating / $itemRating->totalReviews;
            $floorValue = floor($mean);
            $roundedValue = round($mean, 1, PHP_ROUND_HALF_DOWN);
            if ($floorValue != 5 && $floorValue != $roundedValue) {
                $itemRating->avgRating = $floorValue + 0.5;
            } else {
                $itemRating->avgRating = $floorValue;
            }            
        }
    }

}
