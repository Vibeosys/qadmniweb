<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemMaster Model
 *
 * @method \App\Model\Entity\ItemMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemMaster newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemMaster|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemMaster[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemMaster findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemMasterTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('item_master');
        $this->displayField('ItemId');
        $this->primaryKey('ItemId');
    }

    private function getTable() {
        return \Cake\ORM\TableRegistry::get('item_master');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->allowEmpty('ItemId', 'create');

        $validator
                ->requirePresence('ItemName_En', 'create')
                ->notEmpty('ItemName_En');

        $validator
                ->requirePresence('ItemName_Ar', 'create')
                ->notEmpty('ItemName_Ar');

        $validator
                ->requirePresence('ItemDesc_En', 'create')
                ->notEmpty('ItemDesc_En');

        $validator
                ->requirePresence('ItemDesc_Ar', 'create')
                ->notEmpty('ItemDesc_Ar');

        $validator
                ->integer('CategoryId')
                ->requirePresence('CategoryId', 'create')
                ->notEmpty('CategoryId');

        $validator
                ->numeric('UnitPrice')
                ->requirePresence('UnitPrice', 'create')
                ->notEmpty('UnitPrice');

        $validator
                ->allowEmpty('OfferText');

        $validator
                ->numeric('Rating')
                ->allowEmpty('Rating');

        $validator
                ->integer('Reviews')
                ->allowEmpty('Reviews');

        $validator
                ->integer('VendorId')
                ->requirePresence('VendorId', 'create')
                ->notEmpty('VendorId');

        $validator
                ->allowEmpty('ImageUrl');

        $validator
                ->integer('IsActive')
                ->requirePresence('IsActive', 'create')
                ->notEmpty('IsActive');

        $validator
                ->dateTime('CreatedDate')
                ->allowEmpty('CreatedDate');

        return $validator;
    }

    /**
     * Adds product into the items table
     * @param \App\Dto\Requests\ProductAddRequestDto $productAddRequest
     * @param int $producerId 
     * @return int
     */
    public function addProduct($productAddRequest, $producerId) {
        $generatedProductId = 0;

        $dbProduct = $this->newEntity();
        $dbProduct->CategoryId = $productAddRequest->categoryId;
        $dbProduct->ItemName_En = $productAddRequest->itemNameEn;
        $dbProduct->ItemName_Ar = $productAddRequest->itemNameAr;
        $dbProduct->ItemDesc_En = $productAddRequest->itemDescEn;
        $dbProduct->ItemDesc_Ar = $productAddRequest->itemDescAr;
        $dbProduct->UnitPrice = $productAddRequest->price;
        $dbProduct->OfferText = $productAddRequest->offerText;
        $dbProduct->CreatedDate = new \Cake\I18n\Time();
        $dbProduct->IsActive = 1;
        $dbProduct->ProducerId = $producerId;

        if ($this->save($dbProduct)) {
            $generatedProductId = $dbProduct->ItemId;
        }
        return $generatedProductId;
    }

    /**
     * Gets list of items for a given language code
     * @param string $langCode
     * @param int $categoryId 
     */
    public function getItemList($langCode, $categoryId) {
        $itemListResponse = null;
        $itemList = null;

        //Create name of the dynamic variables based on language code
        $itemName = 'ItemName_' . $langCode;
        $itemDesc = 'ItemDesc_' . $langCode;
        $businessName = 'BusinessName_' . $langCode;
        $producerBusinessName = 'producer.BusinessName_' . $langCode;

        //Join with tables
        $this->belongsTo('producer', [
            'foreignKey' => 'ProducerId',
            'joinType' => 'INNER'
        ]);
        $result = $this->find()
                ->contain(['producer'])
                ->where(['ItemMaster.IsActive' => 1])
                ->select(['ItemId',
            $itemName,
            $itemDesc,
            'UnitPrice',
            'OfferText',
            'Rating',
            'Reviews',
            'ImageUrl',
            'CategoryId',
            'producer.ProducerId',
            $producerBusinessName,
            'producer.Latitude',
            'producer.Longitude']);

        if ($categoryId != 0) {
            $result = $result->where(['CategoryId' => $categoryId]);
        }
        //->all();

        $resultArray = $result->toArray();

        $recordCounter = 0;
        $producerLocations = null;
        $producerIdList = [];
        $producerCounter = 0;

        //Iterate through records
        foreach ($resultArray as $itemRecord) {
            $itemListRecord = new \App\Dto\ItemInfoDto();

            $itemListRecord->itemId = $itemRecord->ItemId;
            $itemListRecord->itemName = $itemRecord->$itemName;
            $itemListRecord->itemDesc = $itemRecord->$itemDesc;
            $itemListRecord->imageUrl = $itemRecord->ImageUrl;
            $itemListRecord->offerText = $itemRecord->OfferText;
            $itemListRecord->rating = $itemRecord->Rating;
            $itemListRecord->producerId = $itemRecord->producer->ProducerId;
            $itemListRecord->unitPrice = $itemRecord->UnitPrice;
            $itemListRecord->reviews = $itemRecord->Reviews;
            $itemListRecord->categoryId = $itemRecord->CategoryId;

            //Create a unique list of producer id with locations
            if (!in_array($itemListRecord->producerId, $producerIdList)) {
                $producerLocation = $this->buildProducerLocation($itemRecord, $businessName);
                $producerIdList[$producerCounter] = $itemListRecord->producerId;
                $producerLocations[$producerCounter] = $producerLocation;
                $producerCounter++;
            }

            $itemList[$recordCounter++] = $itemListRecord;
        }
        //If there are recors fetched by query then assign the lists
        if (count($resultArray) > 0) {
            $itemListResponse = new \App\Dto\Responses\ItemListResponseDto();
            $itemListResponse->itemInfoList = $itemList;
            $itemListResponse->producerLocations = $producerLocations;
        }

        return $itemListResponse;
    }

    private function buildProducerLocation($itemRecord, $producerBusinessName) {
        $producerLocation = new \App\Dto\ProducerLocationDto();
        $producerLocation->producerId = $itemRecord->producer->ProducerId;
        $producerLocation->businessName = $itemRecord->producer->$producerBusinessName;
        $producerLocation->businessLat = $itemRecord->producer->Latitude;
        $producerLocation->businessLong = $itemRecord->producer->Longitude;
        return$producerLocation;
    }

    /**
     * Produces list of items for requested producer it
     * @param string $languageCode
     * @param int $producerId
     * @return \App\Dto\Responses\ProducerItemListResponseDto[]
     */
    public function getVendorItemList($languageCode, $producerId) {
        $vendorItemList = NULL;

        $this->belongsTo('item_category', [
            'foreignKey' => 'CategoryId',
            'joinType' => 'INNER'
        ]);

        $itemName = 'ItemName_' . $languageCode;
        $itemDesc = 'ItemDesc_' . $languageCode;
        $categoryName = 'CategoryName_' . $languageCode;

        $result = $this->find()
                ->contain(['item_category'])
                ->where(['ProducerId' => $producerId])
                ->select(['ItemId',
                    $itemName,
                    $itemDesc,
                    'UnitPrice',
                    'ImageUrl',
                    'ItemMaster.IsActive',
                    'item_category.' . $categoryName])
                ->all();

        $resultArray = $result->toArray();
        $recordCounter = 0;

        foreach ($resultArray as $itemRecord) {
            $vendorItem = new \App\Dto\Responses\ProducerItemListResponseDto();
            $vendorItem->itemId = $itemRecord->ItemId;
            $vendorItem->itemName = $itemRecord->$itemName;
            $vendorItem->itemDesc = $itemRecord->$itemDesc;
            $vendorItem->price = $itemRecord->UnitPrice;
            $vendorItem->category = $itemRecord->item_category->$categoryName;
            $vendorItem->availableForSell = $itemRecord->IsActive;
            $vendorItem->imageUrl = $itemRecord->ImageUrl;
            $vendorItemList[$recordCounter++] = $vendorItem;
        }

        return $vendorItemList;
    }

    /**
     * Adds or updates product image
     * @param int $productId
     * @param string $imageUrl
     * @return boolean
     */
    public function addOrUpdateProductImage($productId, $imageUrl) {
        $productImageAddedOrUpdated = false;
        $dbProduct = $this->find()
                ->where(['ItemId' => $productId])
                ->select(['ItemId', 'ImageUrl'])
                ->first();

        if ($dbProduct) {
            $dbProduct->ImageUrl = $imageUrl;
            if ($this->save($dbProduct)) {
                $productImageAddedOrUpdated = true;
            }
        }

        return $productImageAddedOrUpdated;
    }

    /**
     * Gets the list of items with price
     * @param array $itemIdList
     * @param string $langCode
     * @return \App\Dto\OrderItemPriceDto
     */
    public function getItemDetails($itemIdList, $langCode) {
        $itemDetails = null;
        $itemName = 'ItemName_' . $langCode;
        $itemResult = $this->getTable()->find()
                ->where(['ItemId IN ' => $itemIdList, 'IsActive' => 1])
                ->select(['ItemId', $itemName, 'UnitPrice', 'ProducerId'])
                ->all();
        $itemResultList = $itemResult->toArray();
        $recordCounter = 0;
        foreach ($itemResultList as $itemRecord) {
            $orderItem = new \App\Dto\OrderItemPriceDto();
            $orderItem->itemId = $itemRecord->ItemId;
            $orderItem->itemName = $itemRecord->$itemName;
            $orderItem->unitPrice = $itemRecord->UnitPrice;
            $orderItem->producerId = $itemRecord->ProducerId;
            $itemDetails[$recordCounter++] = $orderItem;
        }
        return $itemDetails;
    }

    /**
     * Get product details of desired product id
     * @param int $productId
     * @return \App\Dto\Responses\ProductDetailsResponseDto
     */
    public function getProductDetails($productId) {
        $dbProduct = $this->find()
                ->where(['ItemId' => $productId])
                ->select([ 'ItemId',
                    'ItemName_En',
                    'ItemName_Ar',
                    'ItemDesc_En',
                    'ItemDesc_Ar',
                    'CategoryId',
                    'UnitPrice',
                    'OfferText',
                    'ImageUrl',
                    'IsActive'])
                ->first();

        if ($dbProduct) {
            $productDetailResponse = new \App\Dto\Responses\ProductDetailsResponseDto();
            $productDetailResponse->itemId = $dbProduct->ItemId;
            $productDetailResponse->itemNameEn = $dbProduct->ItemName_En;
            $productDetailResponse->itemNameAr = $dbProduct->ItemName_Ar;
            $productDetailResponse->itemDescAr = $dbProduct->ItemDesc_Ar;
            $productDetailResponse->itemDescEn = $dbProduct->ItemDesc_En;
            $productDetailResponse->categoryId = $dbProduct->CategoryId;
            $productDetailResponse->unitPrice = $dbProduct->UnitPrice;
            $productDetailResponse->offerText = $dbProduct->OfferText;
            $productDetailResponse->isActive = $dbProduct->IsActive;
            $productDetailResponse->imageUrl = $dbProduct->ImageUrl;
        }

        return $productDetailResponse;
    }

    /**
     * Updates product information
     * @param \App\Dto\Requests\UpdateProductRequestDto $productUpdateRequest
     * @param int $producerId
     * @return boolean 
     */
    public function updateProduct($productUpdateRequest, $producerId) {
        $updateSuccess = false;
        $dbProduct = $this->find()
                ->where(['ItemId' => $productUpdateRequest->productId, 'ProducerId' => $producerId])
                ->select([ 'ItemId',
                    'ItemName_En',
                    'ItemName_Ar',
                    'ItemDesc_En',
                    'ItemDesc_Ar',
                    'CategoryId',
                    'UnitPrice',
                    'OfferText',
                    'IsActive'])
                ->first();
        if ($dbProduct) {
            $dbProduct->CategoryId = $productUpdateRequest->categoryId;
            $dbProduct->ItemName_En = $productUpdateRequest->itemNameEn;
            $dbProduct->ItemName_Ar = $productUpdateRequest->itemNameAr;
            $dbProduct->ItemDesc_En = $productUpdateRequest->itemDescEn;
            $dbProduct->ItemDesc_Ar = $productUpdateRequest->itemDescAr;
            $dbProduct->UnitPrice = $productUpdateRequest->price;
            $dbProduct->OfferText = $productUpdateRequest->offerText;
            $dbProduct->IsActive = $productUpdateRequest->isActive;
            $dbProduct->ProducerId = $producerId;
        }

        if ($this->save($dbProduct)) {
            $updateSuccess = true;
        }
        return $updateSuccess;
    }

    /**
     * Gets customer favorite list of items
     * @param string $langCode
     * @param int $customerId
     * @return \App\Dto\Responses\ItemListResponseDto
     */
    public function getCustomerFavoriteList($langCode, $customerId) {
        $itemListResponse = null;
        $itemList = null;

        //Create name of the dynamic variables based on language code
        $itemName = 'ItemName_' . $langCode;
        $itemDesc = 'ItemDesc_' . $langCode;
        $businessName = 'BusinessName_' . $langCode;
        $producerBusinessName = 'producer.BusinessName_' . $langCode;

        //Join with tables
        $this->belongsTo('producer', [
            'foreignKey' => 'ProducerId',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('customer_favorites', [
            'foreignKey' => 'ItemId',
            'joinType' => 'INNER'
        ]);
        $result = $this->find()
                ->contain(['producer', 'customer_favorites'])
                ->where(['ItemMaster.IsActive' => 1, 'customer_favorites.CustomerId' => $customerId])
                ->select(['ItemId',
                    $itemName,
                    $itemDesc,
                    'UnitPrice',
                    'OfferText',
                    'Rating',
                    'Reviews',
                    'ImageUrl',
                    'producer.ProducerId',
                    $producerBusinessName,
                    'producer.Latitude',
                    'producer.Longitude'])
                ->all();

        $resultArray = $result->toArray();

        $recordCounter = 0;
        $producerLocations = null;
        $producerIdList = [];
        $producerCounter = 0;

        //Iterate through records
        foreach ($resultArray as $itemRecord) {
            $itemListRecord = new \App\Dto\ItemInfoDto();

            $itemListRecord->itemId = $itemRecord->ItemId;
            $itemListRecord->itemName = $itemRecord->$itemName;
            $itemListRecord->itemDesc = $itemRecord->$itemDesc;
            $itemListRecord->imageUrl = $itemRecord->ImageUrl;
            $itemListRecord->offerText = $itemRecord->OfferText;
            $itemListRecord->rating = $itemRecord->Rating;
            $itemListRecord->producerId = $itemRecord->producer->ProducerId;
            $itemListRecord->unitPrice = $itemRecord->UnitPrice;
            $itemListRecord->reviews = $itemRecord->Reviews;

            //Create a unique list of producer id with locations
            if (!in_array($itemListRecord->producerId, $producerIdList)) {
                $producerLocation = $this->buildProducerLocation($itemRecord, $businessName);
                $producerIdList[$producerCounter] = $itemListRecord->producerId;
                $producerLocations[$producerCounter] = $producerLocation;
                $producerCounter++;
            }

            $itemList[$recordCounter++] = $itemListRecord;
        }
        //If there are recors fetched by query then assign the lists
        if (count($resultArray) > 0) {
            $itemListResponse = new \App\Dto\Responses\ItemListResponseDto();
            $itemListResponse->itemInfoList = $itemList;
            $itemListResponse->producerLocations = $producerLocations;
        }

        return $itemListResponse;
    }

    /**
     * Updates item rating for individual item
     * @param \App\Dto\ItemRatingReviewDto $itemRatings
     * @return boolean 
     */
    public function updateItemRatings($itemRatings) {
        $itemsUpdated = true;
        //Find all items and update the reviews
        foreach ($itemRatings as $itemRating) {
            $dbItem = $this->getTable()->find()
                    ->where(['ItemId' => $itemRating->itemId])
                    ->select(['ItemId', 'Reviews', 'Rating'])
                    ->first();

            if ($dbItem) {
                $dbItem->Reviews = $itemRating->totalReviews;
                $dbItem->Rating = $itemRating->avgRating;

                if ($this->getTable()->save($dbItem)) {
                    $itemsUpdated &= true;
                } else {
                    $itemsUpdated &= false;
                }
            }
        }

        return $itemsUpdated;
    }

}
