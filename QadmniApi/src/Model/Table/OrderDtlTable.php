<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderDtl Model
 *
 * @method \App\Model\Entity\OrderDtl get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderDtl newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderDtl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderDtl|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderDtl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderDtl[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderDtl findOrCreate($search, callable $callback = null, $options = [])
 */
class OrderDtlTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('order_dtl');
        $this->displayField('OrderDtlId');
        $this->primaryKey('OrderDtlId');
        $this->belongsTo('item_master', [
            'foreignKey' => 'ItemId',
            'joinType' => 'INNER'
        ]);
    }

    public function getTable() {
        return \Cake\ORM\TableRegistry::get('order_dtl');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->allowEmpty('OrderDtlId', 'create');

        $validator
                ->integer('OrderId')
                ->requirePresence('OrderId', 'create')
                ->notEmpty('OrderId');

        $validator
                ->integer('ItemId')
                ->allowEmpty('ItemId');

        $validator
                ->integer('ItemQty')
                ->allowEmpty('ItemQty');

        $validator
                ->numeric('ItemUnitPrice')
                ->allowEmpty('ItemUnitPrice');

        $validator
                ->numeric('ItemTotalPrice')
                ->allowEmpty('ItemTotalPrice');

        return $validator;
    }

    /**
     * Adds items to the db
     * @param int $orderId
     * @param \App\Dto\OrderItemPriceDto $itemPriceList
     * @return boolean 
     */
    public function addNewOrders($orderId, $itemPriceList) {
        $orderDtlEntities = [];
        $ordersSaved = null;
        $saved = false;

        foreach ($itemPriceList as $orderItem) {
            $orderDtlEntity = $this->getTable()->newEntity();
            $orderDtlEntity->OrderId = $orderId;
            $orderDtlEntity->ItemId = $orderItem->itemId;
            $orderDtlEntity->ItemQty = $orderItem->itemQty;
            $orderDtlEntity->ItemUnitPrice = $orderItem->unitPrice;
            $orderDtlEntity->ItemTotalPrice = $orderItem->itemTotalPrice;
            array_push($orderDtlEntities, $orderDtlEntity);
        }

        if (count($orderDtlEntity) > 0) {
            $ordersSaved = $this->getTable()->saveMany($orderDtlEntities);
            if ($ordersSaved) {
                $saved = true;
            }
        }
        return $saved;
    }

    /**
     * Lists order items for the requested orderid
     * @param int $orderId
     * @param string $langCode
     * @return array
     */
    public function getOrderItemDetails($orderId, $langCode) {
        $itemList = [];
        $itemName = 'ItemName_' . $langCode;

        $dbDetails = $this->find()
                ->contain(['item_master'])
                ->where(['OrderId' => $orderId])
                ->select(['OrderDtlId', 'item_master.ItemId', 'item_master.' . $itemName])
                ->all();

        foreach ($dbDetails as $orderItem) {
            $orderItemDetails = new \App\Dto\Responses\OrderItemDetailResponseDto();
            $orderItemDetails->itemId = $orderItem->item_master->ItemId;
            $orderItemDetails->itemName = $orderItem->item_master->$itemName;
            array_push($itemList, $orderItemDetails);
        }

        return $itemList;
    }

    /**
     * Gets the items for the order, endpoint for orderdetails
     * @param int $orderId
     * @param string $langCode
     * @return \App\Dto\OrderItemDetailDto
     */
    public function getOrderItems($orderId, $langCode) {
        $itemList = [];
        $itemName = 'ItemName_' . $langCode;

        $dbDetails = $this->getTable()->find()
                ->contain(['item_master'])
                ->where(['OrderId' => $orderId])
                ->select(['OrderDtlId',
                    'item_master.' . $itemName,
                    'ItemQty',
                    'ItemTotalPrice'])
                ->all();

        foreach ($dbDetails as $orderItem) {
            $orderItemDetails = new \App\Dto\OrderItemDetailDto();
            $orderItemDetails->name = $orderItem->item_master->$itemName;
            $orderItemDetails->qty = $orderItem->ItemQty;
            $orderItemDetails->price = $orderItem->ItemTotalPrice;
            array_push($itemList, $orderItemDetails);
        }

        return $itemList;
    }

}
