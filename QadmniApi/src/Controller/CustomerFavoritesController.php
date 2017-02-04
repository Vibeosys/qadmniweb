<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * CustomerFavorites Controller
 *
 * @property \App\Model\Table\CustomerFavoritesTable $CustomerFavorites
 */
class CustomerFavoritesController extends AppController {

    public function addToFavorites() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        $addFavRequest = \App\Dto\Requests\AddRemoveFavoriteRequestDto::Deserialize($this->postedData);
        $isAdded = $this->CustomerFavorites->addToFavorite
                ($this->postedCustomerData->customerId, $addFavRequest->productId);
        if ($isAdded) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(220));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(125));
        }
    }

    public function removeFromFavorites() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        $removeFavRequest = \App\Dto\Requests\AddRemoveFavoriteRequestDto::Deserialize($this->postedData);
        $isRemoved = $this->CustomerFavorites->removeFavorite
                ($this->postedCustomerData->customerId, $removeFavRequest->productId);

        if ($isRemoved) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(221));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(126));
        }
    }



}
