<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemMaster Controller
 *
 * @property \App\Model\Table\ItemMasterTable $ItemMaster
 */
class ItemMasterController extends AppController {

    public function getList() {
        $this->apiInitialize();
        $itemListRequest = \App\Dto\Requests\ItemListRequestDto::Deserialize($this->postedData);
        $itemList = $this->ItemMaster->getItemList($this->languageCode, $itemListRequest->categoryId);
        if ($itemList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(202, $itemList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(102));
        }
    }

    public function getVendorItemList() {
        $this->apiInitialize();
        $isVendorValidated = $this->validateProducer();
        if (!$isVendorValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(105));
            return;
        }
        //Gets the list of items for a vendor id
        $itemList = $this->ItemMaster->getVendorItemList($this->languageCode, $this->postedProducerData->producerId);
        if ($itemList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(205, $itemList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(106));
        }
    }

    public function addProduct() {
        $this->apiInitialize();
        //Is valid producer
        $isVendorValidated = $this->validateProducer();
        if (!$isVendorValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(105));
            return;
        }

        $productAddRequest = \App\Dto\Requests\ProductAddRequestDto::Deserialize($this->postedData);
        //Add a product and get product id
        $resultProductId = $this->ItemMaster->addProduct($productAddRequest, $this->postedProducerData->producerId);

        if ($resultProductId) {
            $productAddResponse = new \App\Dto\Responses\ProductAddResponseDto();
            $productAddResponse->productId = $resultProductId;
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(208, $productAddResponse));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(110));
        }
    }

    public function updateProduct() {
        $this->apiInitialize();
        //Is valid producer
        $isVendorValidated = $this->validateProducer();
        if (!$isVendorValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(105));
            return;
        }

        $productAddRequest = \App\Dto\Requests\UpdateProductRequestDto::Deserialize($this->postedData);
        //Add a product and get product id
        $updateSuccess = $this->ItemMaster->updateProduct($productAddRequest, $this->postedProducerData->producerId);

        if ($updateSuccess) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(219));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(124));
        }
    }

    public function addUpdateProductImage() {
        $this->apiInitialize();
        $webrootDir = $this->getWebrootDir();
        $uploadedData = $this->request->data;
        $imageUrl = null;

        $json = $this->request->data['json'];
        $productImageRequest = \App\Dto\Requests\ProductImageRequestDto::Deserialize($json);

        $producerCredentials = new \App\Dto\ProducerCredentialDetailsDto();
        $producerCredentials->producerId = $productImageRequest->producerId;
        $producerCredentials->password = $productImageRequest->password;

        $isVendorValidated = $this->validateProducerData($producerCredentials);
        if (!$isVendorValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(105));
            return;
        }

        foreach ($uploadedData as $requestedData) {
            if (!is_array($requestedData)) {
                continue;
            }

            $file = $requestedData;
            $imageUrl = \App\Utils\ImageFileUploader::uploadMultipartImage($webrootDir, $file);
        }

        $imageUpdated = $this->ItemMaster->addOrUpdateProductImage($productImageRequest->productId, $imageUrl);
        if ($imageUpdated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(209));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(111));
        }
    }

    private function getWebrootDir() {
        return "http://" . $this->request->host() . $this->request->webroot;
    }

    public function customerFavorites() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        $favoriteItemList = $this->ItemMaster->getCustomerFavoriteList($this->languageCode, $this->postedCustomerData->customerId);

        if ($favoriteItemList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(222, $favoriteItemList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(127));
        }
    }

}
