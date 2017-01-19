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
class PaymentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('payments');
        $this->displayField('TransId');
        $this->primaryKey('TransId');
    }
    
    public function getTable(){
        return \Cake\ORM\TableRegistry::get('payments');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
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
    public function addNewTransaction($transactionId, $orderId, $amountInUSD){
        $saved = false;
        
        $dbPayment = $this->getTable()->newEntity();
        $dbPayment->Amount = $amountInUSD;
        $dbPayment->PaymentCurrency = \App\Utils\QadmniConstants::PAYMENT_CURRENCY;
        $dbPayment->CreatedDate = new \Cake\I18n\Time();
        $dbPayment->PaymentStatus = \App\Utils\QadmniConstants::PAYMENT_STATUS_PENDING;
        $dbPayment->OrderId = $orderId;
        $dbPayment->TransId = $transactionId;
        
        if($this->getTable()->save($dbPayment)){
            $saved = true;
        }
        
        return $saved;
    }
}
