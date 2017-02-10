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

    public function getTable() {
        return \Cake\ORM\TableRegistry::get('producer');
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

    /**
     * Validates producer data against database
     * @param \App\Dto\ProducerCredentialDetailsDto $producerData
     */
    public function validateProducer($producerData) {
        $thisTable = $this->getTable();
        $producerExists = $thisTable->exists(['ProducerId' => $producerData->producerId,
            'Password' => $producerData->password]);

        return $producerExists;
    }

    /**
     * Gets producer login details, check details, if exists then updates push details in database
     * @param int $producerId 
     * @param string $pushId 
     * @param string $pushDeviceOsType 
     * @return boolean Update success
     */
    public function updateNotificationDetails($producerId, $pushId, $pushDeviceOsType) {
        $dbProducer = $this->find()
                ->where(['ProducerId' => $producerId])
                ->select('ProducerId', 'ProducerPushId', 'ProducerOsVersionType')
                ->first();

        if ($dbProducer) {
            $dbProducer->ProducerPushId = $pushId;
            $dbProducer->ProducerOsVersionType = $pushDeviceOsType;
            if ($this->save($dbProducer)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check login and get required details of Producer
     * @param \App\Dto\Requests\ProducerLoginRequestDto $producerLoginRequest
     */
    public function getDetails($producerLoginRequest) {
        $producerDetails = NULL;
        $dbProducer = $this->find()
                ->where(['EmailId' => $producerLoginRequest->emailId,
                    'Password' => $producerLoginRequest->password])
                ->select(['ProducerId',
                    'BusinessName_En',
                    'BusinessName_Ar',
                    'Address',
                    'Latitude',
                    'Longitude',
                    'Name'])
                ->first();

        if ($dbProducer) {
            $producerDetails = new \App\Dto\Responses\ProducerLoginResponseDto();
            $producerDetails->producerId = $dbProducer->ProducerId;
            $producerDetails->producerName = $dbProducer->Name;
            $producerDetails->businessNameEn = $dbProducer->BusinessName_En;
            $producerDetails->businessNameAr = $dbProducer->BusinessName_Ar;
            $producerDetails->businessLat = $dbProducer->Latitude;
            $producerDetails->businessLong = $dbProducer->Longitude;
            $producerDetails->businessAddress = $dbProducer->Address;
        }

        return $producerDetails;
    }

    public function getPasswordDetails($producerEmailId) {
        $producerDetails = null;
        $dbCustomer = $this->find()
                ->where(['EmailId' => $producerEmailId])
                ->select(['Name', 'Password'])
                ->first();
        if ($dbCustomer) {
            $producerDetails = new \App\Dto\UserEmailPasswordDto();
            $producerDetails->name = $dbCustomer->Name;
            $producerDetails->password = $dbCustomer->Password;
        }
        return $producerDetails;
    }

    /**
     * Updates profile for the producer
     * @param \App\Dto\Requests\ProducerProfileUpdateRequestDto $producerData
     * @param int $producerId
     * @return boolean 
     */
    public function updateProfile($producerData, $producerId) {
        $profileUpdated = false;
        $dbProducer = $this->find()
                ->where(['ProducerId' => $producerId])
                ->select(['Name', 'Password', 'EmailId', 'ProducerId'])
                ->first();

        if ($dbProducer) {
            $dbProducer->Name = $producerData->name;
            $dbProducer->EmailId = $producerData->emailId;
            $dbProducer->Password = $producerData->password;
            if ($this->save($dbProducer)) {
                $profileUpdated = true;
            }
        }
        return $profileUpdated;
    }

}
