<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * CustomerFavorites Controller
 *
 * @property \App\Model\Table\CustomerFavoritesTable $CustomerFavorites
 */
class CustomerFavoritesController extends AppController {

    public function addRemoveFavorites() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        $dataAddedRemvoved = false;
        $addRemoveFavRequest = \App\Dto\Requests\AddRemoveFavoriteRequestDto::Deserialize($this->postedData);

        //Depending on the favorite flag, take an action
        if ($addRemoveFavRequest->favFlag == \App\Utils\QadmniConstants::FAVORITE_FLAG_ADD) {
            $dataAddedRemvoved = $this->CustomerFavorites->addToFavorite
                    ($this->postedCustomerData->customerId, $addRemoveFavRequest->productId);
        } else if ($addRemoveFavRequest->favFlag == \App\Utils\QadmniConstants::FAVORITE_FLAG_REMOVE) {
            $dataAddedRemvoved = $this->CustomerFavorites->removeFavorite
                    ($this->postedCustomerData->customerId, $addRemoveFavRequest->productId);
        }

        if ($dataAddedRemvoved) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(220));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(125));
        }
    }

}
