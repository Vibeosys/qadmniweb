<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderHeader Model
 *
 * @method \App\Model\Entity\OrderHeader get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderHeader newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderHeader[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderHeader|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderHeader patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderHeader[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderHeader findOrCreate($search, callable $callback = null, $options = [])
 */
class OrderHeaderTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('order_header');
        $this->displayField('OrderId');
        $this->primaryKey('OrderId');
    }

    private function getTable() {
        return \Cake\ORM\TableRegistry::get('order_header');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('OrderId')
                ->allowEmpty('OrderId', 'create');

        $validator
                ->dateTime('OrderDate')
                ->requirePresence('OrderDate', 'create')
                ->notEmpty('OrderDate');

        $validator
                ->integer('CustomerId')
                ->requirePresence('CustomerId', 'create')
                ->notEmpty('CustomerId');

        $validator
                ->numeric('OrderQty')
                ->allowEmpty('OrderQty');

        $validator
                ->numeric('AmountSubTotal')
                ->allowEmpty('AmountSubTotal');

        $validator
                ->integer('Status')
                ->requirePresence('Status', 'create')
                ->notEmpty('Status');

        $validator
                ->integer('ProducerId')
                ->allowEmpty('ProducerId');

        $validator
                ->numeric('TotalAmount')
                ->allowEmpty('TotalAmount');

        $validator
                ->allowEmpty('DeliveryAddress');

        $validator
                ->numeric('DeliveryLat')
                ->allowEmpty('DeliveryLat');

        $validator
                ->numeric('DeliveryLong')
                ->allowEmpty('DeliveryLong');

        $validator
                ->allowEmpty('DeliveryType');

        return $validator;
    }

    /**
     * Adds order in Order header
     * @param \App\Dto\OrderHdrParamsDto $orderHdrParams
     */
    public function addNewOrder($orderHdrParams) {
        $orderId = 0;

        $dbTable = $this->getTable();
        $dbNewOrder = $dbTable->newEntity();

        $dbNewOrder->OrderDate = new \Cake\I18n\Time();
        $dbNewOrder->CustomerId = $orderHdrParams->customerId;
        $dbNewOrder->ProducerId = $orderHdrParams->producerId;
        $dbNewOrder->DeliveryAddress = $orderHdrParams->orderInitiationRequest->deliveryAddress;
        $dbNewOrder->DeliveryLat = $orderHdrParams->orderInitiationRequest->deliveryLat;
        $dbNewOrder->DeliveryLong = $orderHdrParams->orderInitiationRequest->deliveryLong;
        $dbNewOrder->DeliveryMode = $orderHdrParams->orderInitiationRequest->deliveryMethod;
        $dbNewOrder->AmountSubTotal = $orderHdrParams->orderSubTotal;
        $dbNewOrder->Status = $orderHdrParams->orderStatus;
        $dbNewOrder->TransactionRequired = $orderHdrParams->transRequired;
        $dbNewOrder->TransactionStatus = $orderHdrParams->transStatus;
        if (!is_null($orderHdrParams->deliveryDateTime)) {
            $dbNewOrder->DeliveryDateTime = $orderHdrParams->deliveryDateTime;
        }
        $dbNewOrder->PaymentMode = $orderHdrParams->orderInitiationRequest->paymentMethod;
        $dbNewOrder->OrderQty = $orderHdrParams->orderQty;
        $dbNewOrder->TotalAmount = $orderHdrParams->totalAmountInSAR;
        $dbNewOrder->DeliveryStatusId = $orderHdrParams->deliveryStatus;
        $dbNewOrder->TotalAmountInUSD = $orderHdrParams->totalAmountInUSD;

        if ($dbTable->save($dbNewOrder)) {
            $orderId = $dbNewOrder->OrderId;
        }
        return $orderId;
    }

    /**
     * Gets order details of the order to be processed
     * @param int $orderId
     * @param int $customerId
     * @return \App\Dto\OrderValidationDto 
     */
    public function getOrderDetails($orderId, $customerId) {
        $orderDetails = null;
        $dbOrder = $this->getTable()->find()
                ->where(['OrderId' => $orderId, 'CustomerId' => $customerId])
                ->select(['TotalAmount', 'TotalAmountInUSD', 'OrderId', 'TransactionRequired', 'Status'])
                ->first();
        if ($dbOrder) {
            $orderDetails = new \App\Dto\OrderValidationDto();
            $orderDetails->orderAmountInSAR = $dbOrder->TotalAmount;
            $orderDetails->orderAmountInUSD = $dbOrder->TotalAmountInUSD;
            $orderDetails->orderId = $dbOrder->OrderId;
            $orderDetails->orderStatus = $dbOrder->Status;
            $orderDetails->transactionRequired = $dbOrder->TransactionRequired == 1? true : false;
        }   
        return $orderDetails;
    }
    
    /**
     * Updates given status for the order
     * @param int $orderId
     * @param int $orderStatus
     * @return boolean
     */
    public function updateOrderStatus($orderId, $orderStatus){
        $statusUpdated = false;
        $dbOrder = $this->getTable()->find()
                ->where(['OrderId' => $orderId])
                ->select(['OrderId', 'Status'])
                ->first();
        
        if($dbOrder){
            $dbOrder->Status = $orderStatus;
            if($this->getTable()->save($dbOrder)){
                $statusUpdated = true;
            }
        }
        return $statusUpdated;
    }
    
    public function updateOrderTransactionStatus($orderId, $transactionStatus){
        $statusUpdated = false;
        $dbOrder = $this->getTable()->find()
                ->where(['OrderId' => $orderId])
                ->select(['OrderId', 'TransactionStatus'])
                ->first();
        
        if($dbOrder){
            $dbOrder->TransactionStatus = $transactionStatus;
            if($this->getTable()->save($dbOrder)){
                $statusUpdated = true;
            }
        }
        return $statusUpdated;
    }
    
    public function updateOrderAndTransactionStatus($orderId, $orderStatus, $transStatus){
        $statusUpdated = false;
        $dbOrder = $this->getTable()->find()
                ->where(['OrderId' => $orderId])
                ->select(['OrderId', 'Status', 'TransactionStatus'])
                ->first();
        
        if($dbOrder){
            $dbOrder->Status = $orderStatus;
            $dbOrder->TransactionStatus = $transStatus;
            if($this->getTable()->save($dbOrder)){
                $statusUpdated = true;
            }
        }
        return $statusUpdated;
    }
            
    /**
     * Gets information about order related to notifications
     * @param int $orderId
     * @return \App\Dto\OrderNotificationDto
     */
    public function getProducerCustomerInfo($orderId){
        $orderNotification = null;
        $thisTable = $this->getTable();
        $thisTable->belongsTo('customer', [
            'foreignKey' => 'customerId',
            'joinType' => 'INNER'
        ]);
        
        $thisTable->belongsTo('producer', [
            'foreignKey' => 'producerId',
            'joinType' => 'INNER'
        ]);
        
        $dbRecord = $thisTable->find()
                ->contain(['customer', 'producer'])
                ->where(['OrderId' => $orderId])
                ->select(['OrderId', 'producer.ProducerPushId', 'producer.ProducerOsVersionType', 'customer.PushId', 'customer.OsVersionType'])
                ->first();
        
        if($dbRecord){
            $orderNotification = new \App\Dto\OrderNotificationDto();
            $orderNotification->customerOsType = $dbRecord->customer->OsVersionType;
            $orderNotification->customerPushId = $dbRecord->customer->PushId;
            $orderNotification->producerOsType = $dbRecord->producer->ProducerOsVersionType;
            $orderNotification->producerPushId = $dbRecord->producer->ProducerPushId;
        }
        
        return $orderNotification;
    }
}
