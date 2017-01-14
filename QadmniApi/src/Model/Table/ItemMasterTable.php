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
     * Gets list of items for a given language code
     * @param string $langCode
     * @param int $categoryId 
     */
    public function getItemList($langCode, $categoryId) {
        $itemListResponse = null;
        $itemList = null;

        $itemName = 'ItemName_' . $langCode;
        $itemDesc = 'ItemDesc_' . $langCode;
        $businessName = 'BusinessName_' . $langCode;
        $producerBusinessName = 'producer.BusinessName_' . $langCode;

        $this->belongsTo('producer', [
            'foreignKey' => 'ProducerId',
            'joinType' => 'INNER'
        ]);
        $result = $this->find()
                ->contain(['producer'])
                ->where(['ItemMaster.IsActive' => 1, 'CategoryId' => $categoryId])
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

            if (!in_array($itemListRecord->producerId, $producerIdList)) {
                $producerLocation = $this->buildProducerLocation($itemRecord, $businessName);
                $producerLocations[$producerCounter++] = $producerLocation;
            }

            $itemList[$recordCounter++] = $itemListRecord;
        }
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

}
