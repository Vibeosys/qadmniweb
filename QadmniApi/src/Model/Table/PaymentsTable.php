<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payments Model
 *
 * @method \App\Model\Entity\Payment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Payment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Payment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Payment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Payment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Payment findOrCreate($search, callable $callback = null, $options = [])
 */
class PaymentsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('payments');
        $this->displayField('TransId');
        $this->primaryKey('TransId');
    }

    public function getTable() {
        return \Cake\ORM\TableRegistry::get('payments');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->allowEmpty('TransId', 'create');

        $validator
                ->allowEmpty('PaypalId');

        $validator
                ->allowEmpty('PaymentMethod');

        $validator
                ->allowEmpty('PaymentCurrency');

        $validator
                ->numeric('Amount')
                ->allowEmpty('Amount');

        $validator
                ->integer('OrderId')
                ->allowEmpty('OrderId');

        $validator
                ->dateTime('CreatedDate')
                ->allowEmpty('CreatedDate');

        $validator
                ->integer('PaymentStatus')
                ->allowEmpty('PaymentStatus');

        $validator
                ->integer('PaymentType')
                ->allowEmpty('PaymentType');

        return $validator;
    }

    /**
     * Adds new transaction with system transaction id
     * @param string $transactionId
     * @param int $orderId
     * @param float $amountInUSD
     * @return boolean
     */
    public function addNewTransaction($transactionId, $orderId, $amountInUSD) {
        $saved = false;

        $dbPayment = $this->getTable()->newEntity();
        $dbPayment->Amount = $amountInUSD;
        $dbPayment->PaymentCurrency = \App\Utils\QadmniConstants::PAYMENT_CURRENCY;
        $dbPayment->CreatedDate = new \Cake\I18n\Time();
        $dbPayment->PaymentStatus = \App\Utils\QadmniConstants::PAYMENT_STATUS_PENDING;
        $dbPayment->OrderId = $orderId;
        $dbPayment->TransId = $transactionId;

        if ($this->getTable()->save($dbPayment)) {
            $saved = true;
        }

        return $saved;
    }

    /**
     * Get transaction details for the provided order and trans id
     * @param int $orderId
     * @param string $transId
     * @return \App\Dto\OrderTransactionDetailDto
     */
    public function getTransactionDetails($orderId, $transId) {
        $orderTransactionDetails = null;
        $thisTable = $this->getTable();
        $thisTable->belongsTo('order_header', [
            'foreignKey' => 'OrderId',
            'joinType' => 'INNER'
        ]);

        $dbOrderTransaction = $thisTable->find()
                ->contain(['order_header'])
                ->where(['TransId' => $transId, 'payments.OrderId' => $orderId])
                ->select(['PaymentCurrency',
                    'Amount',
                    'PaymentStatus',
                    'order_header.Status',
                    'order_header.TransactionRequired',
                    'order_header.TotalAmount',
                    'order_header.CustomerId'])
                ->first();

        if ($dbOrderTransaction) {
            $orderTransactionDetails = new \App\Dto\OrderTransactionDetailDto();
            $orderTransactionDetails->amountInSAR = $dbOrderTransaction->order_header->TotalAmount;
            $orderTransactionDetails->amountInUSD = $dbOrderTransaction->Amount;
            $orderTransactionDetails->customerId = $dbOrderTransaction->order_header->CustomerId;
            $orderTransactionDetails->transactionStatus = $dbOrderTransaction->PaymentStatus;
            $orderTransactionDetails->orderStatus = $dbOrderTransaction->order_header->Status;
            $orderTransactionDetails->transactionRequired = $dbOrderTransaction->order_header->TransactionRequired == 1 ? true : false;
        }

        return $orderTransactionDetails;
    }

    /**
     * Updates paypal transaction status
     * @param string $transId
     * @param string $payPalId
     * @param int $status
     * @return boolean
     */
    public function updatePaypalTransaction($transId, $payPalId, $status) {
        $transactionUpdated = false;
        $thisTable = $this->getTable();
        $dbTransaction = $thisTable->find()
                ->where(['TransId' => $transId])
                ->select(['PaypalId', 'PaymentStatus', 'TransId'])
                ->first();

        if ($dbTransaction) {
            $dbTransaction->PaypalId = $payPalId;
            $dbTransaction->PaymentStatus = $status;
            if ($thisTable->save($dbTransaction)) {
                $transactionUpdated = true;
            }
        }
        return $transactionUpdated;
    }

    /**
     * Updates paypal status and other information for a given transaction
     * @param string $transId
     * @param string $payPalId
     * @param int $status
     * @param string $paymentMethod
     * @param string $paymentType
     * @return boolean
     */
    public function updatePaypalStatus($transId, $payPalId, $status, $paymentMethod, $paymentType) {
        $transactionUpdated = false;
        $thisTable = $this->getTable();
        $dbTransaction = $thisTable->find()
                ->where(['TransId' => $transId])
                ->select(['PaypalId', 'PaymentStatus', 'TransId', 'PaymentMethod', 'PaymentType'])
                ->first();

        if ($dbTransaction) {
            $dbTransaction->PaymentMethod = $paymentMethod;
            $dbTransaction->PaymentType = $paymentType;
            $dbTransaction->PaypalId = $payPalId;
            $dbTransaction->PaymentStatus = $status;
            if ($thisTable->save($dbTransaction)) {
                $transactionUpdated = true;
            }
        }
        return $transactionUpdated;
    }
    
    /**
     * Updates transaction
     * @param string $transId
     * @param int $status
     * @param string $paymentMethod
     * @param string $paymentType
     * @return boolean
     */
    public function updateTransactionStatus($transId, $status, $paymentMethod, $paymentType){
        $transactionUpdated = false;
        $thisTable = $this->getTable();
        $dbTransaction = $thisTable->find()
                ->where(['TransId' => $transId])
                ->select(['PaymentStatus', 'TransId', 'PaymentMethod', 'PaymentType'])
                ->first();

        if ($dbTransaction) {
            $dbTransaction->PaymentMethod = $paymentMethod;
            $dbTransaction->PaymentType = $paymentType;
            $dbTransaction->PaymentStatus = $status;
            if ($thisTable->save($dbTransaction)) {
                $transactionUpdated = true;
            }
        }
        return $transactionUpdated;
    }

}
