<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChargeMaster Model
 *
 * @method \App\Model\Entity\ChargeMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChargeMaster newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ChargeMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChargeMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster findOrCreate($search, callable $callback = null, $options = [])
 */
class ChargeMasterTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('charge_master');
        $this->displayField('ChargeId');
        $this->primaryKey('ChargeId');
    }

    public function getTable() {
        return \Cake\ORM\TableRegistry::get('charge_master');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('ChargeId')
                ->allowEmpty('ChargeId', 'create');

        $validator
                ->requirePresence('ChargeDetails', 'create')
                ->notEmpty('ChargeDetails');

        $validator
                ->numeric('Percentage')
                ->requirePresence('Percentage', 'create')
                ->notEmpty('Percentage');

        $validator
                ->numeric('Amount')
                ->requirePresence('Amount', 'create')
                ->notEmpty('Amount');

        $validator
                ->integer('IsActive')
                ->requirePresence('IsActive', 'create')
                ->notEmpty('IsActive');

        $validator
                ->requirePresence('ChargeType', 'create')
                ->notEmpty('ChargeType');

        return $validator;
    }

    public function getAllCharges() {
        $orderCharges = [];
        $result = $this->getTable()->find()
                ->where(['IsActive' => 1])
                ->select(['ChargeId', 'ChargeDetails', 'Percentage', 'Amount', 'ChargeType'])
                ->all();

        $resultArray = $result->toArray();
        foreach ($resultArray as $chargeRecord) {
            $orderChargeRecord = new \App\Dto\OrderChargeDto();
            $orderChargeRecord->chargeId = $chargeRecord->ChargeId;
            $orderChargeRecord->chargeDetails = $chargeRecord->ChargeDetails;
            $orderChargeRecord->chargeType = $chargeRecord->ChargeType;
            $orderChargeRecord->percentage = $chargeRecord->Percentage;
            $orderChargeRecord->amount = $chargeRecord->Amount;
            array_push($orderCharges, $orderChargeRecord);
        }

        return $orderCharges;
    }

}
