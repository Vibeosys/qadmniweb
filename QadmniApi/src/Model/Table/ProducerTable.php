<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Producer Model
 *
 * @method \App\Model\Entity\Producer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Producer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Producer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Producer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Producer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Producer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Producer findOrCreate($search, callable $callback = null, $options = [])
 */
class ProducerTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('producer');
        $this->displayField('ProducerId');
        $this->primaryKey('ProducerId');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('ProducerId')
                ->allowEmpty('ProducerId', 'create');

        $validator
                ->requirePresence('Name', 'create')
                ->notEmpty('Name');

        $validator
                ->requirePresence('EmailId', 'create')
                ->notEmpty('EmailId');

        $validator
                ->requirePresence('Password', 'create')
                ->notEmpty('Password');

        $validator
                ->requirePresence('BusinessName_En', 'create')
                ->notEmpty('BusinessName_En');

        $validator
                ->requirePresence('BusinessName_Ar', 'create')
                ->notEmpty('BusinessName_Ar');

        $validator
                ->allowEmpty('Address');

        $validator
                ->numeric('Latitude')
                ->allowEmpty('Latitude');

        $validator
                ->numeric('Longitude')
                ->allowEmpty('Longitude');

        $validator
                ->dateTime('CreatedOn')
                ->allowEmpty('CreatedOn');

        $validator
                ->integer('IsActive')
                ->requirePresence('IsActive', 'create')
                ->notEmpty('IsActive');

        $validator
                ->allowEmpty('ProducerPushId');

        $validator
                ->allowEmpty('ProducerOsVersionType');

        return $validator;
    }

    /**
     * Registers producer and shop details
     * @param \App\Dto\Requests\ProducerSignupRequestDto $producerSignupRequest
     * @return boolean Is registered successfully
     */
    public function addNewProducer($producerSignupRequest) {
        $dbNewProducer = $this->newEntity();
        $dbNewProducer->Name = $producerSignupRequest->producerName;
        $dbNewProducer->EmailId = $producerSignupRequest->emailId;
        $dbNewProducer->Password = $producerSignupRequest->password;
        $dbNewProducer->Address = $producerSignupRequest->businessAddress;
        $dbNewProducer->BusinessName_En = $producerSignupRequest->businessNameEn;
        $dbNewProducer->BusinessName_Ar = $producerSignupRequest->businessNameAr;
        $dbNewProducer->Latitude = $producerSignupRequest->businessLat;
        $dbNewProducer->Longitude = $producerSignupRequest->businessLong;
        $dbNewProducer->ProducerPushId = $producerSignupRequest->pushNotificationId;
        $dbNewProducer->ProducerOsVersionType = $producerSignupRequest->osVersionType;
        $dbNewProducer->CreatedOn = new \Cake\I18n\Time();

        if ($this->save($dbNewProducer)) {
            return true;
        }

        return false;
    }

}
