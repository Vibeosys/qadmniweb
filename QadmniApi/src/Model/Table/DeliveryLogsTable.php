<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DeliveryLogs Model
 *
 * @method \App\Model\Entity\DeliveryLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\DeliveryLog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DeliveryLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryLog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DeliveryLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryLog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryLog findOrCreate($search, callable $callback = null, $options = [])
 */
class DeliveryLogsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('delivery_logs');
        $this->displayField('AutoId');
        $this->primaryKey('AutoId');
    }

    private function getTable(){
        return \Cake\ORM\TableRegistry::get('delivery_logs');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('AutoId')
                ->allowEmpty('AutoId', 'create');

        $validator
                ->requirePresence('Api', 'create')
                ->notEmpty('Api');

        $validator
                ->integer('OrderId')
                ->requirePresence('OrderId', 'create')
                ->notEmpty('OrderId');

        $validator
                ->allowEmpty('RequestJson');

        $validator
                ->allowEmpty('ResponseJson');

        $validator
                ->allowEmpty('ErrorCode');

        $validator
                ->allowEmpty('ErrorMessage');

        $validator
                ->integer('ProviderId')
                ->allowEmpty('ProviderId');

        $validator
                ->dateTime('LogDateTime')
                ->allowEmpty('LogDateTime');

        return $validator;
    }

    /**
     * Logs req, response and other data about provider
     * @param string $api
     * @param int $providerId
     * @param int $orderId
     * @param string $reqJson
     * @param string $resJson
     * @param string $errCode
     * @param string $errMsg
     * @return boolean
     */
    public function addLog($api, $providerId, $orderId, $reqJson, $resJson, $errCode, $errMsg) {
        $dbEntity = $this->getTable()->newEntity();
        $dbEntity->Api = $api;
        $dbEntity->ProviderId = $providerId;
        $dbEntity->OrderId = $orderId;
        $dbEntity->RequestJson = $reqJson;
        $dbEntity->ResponseJson = $resJson;
        $dbEntity->ErrorCode = $errCode;
        $dbEntity->ErrorMessage = $errMsg;
        $dbEntity->LogDateTime = new \Cake\I18n\Time();
        
        if($this->getTable()->save($dbEntity)){
            return true;
        }
        return false;
    }

}
