<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customer Model
 *
 * @method \App\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Customer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Customer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Customer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Customer findOrCreate($search, callable $callback = null, $options = [])
 */
class CustomerTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('customer');
        $this->displayField('CustomerId');
        $this->primaryKey('CustomerId');
    }

    private function getTable(){
        return \Cake\ORM\TableRegistry::get('customer');
    }

        /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('CustomerId')
                ->allowEmpty('CustomerId', 'create');

        $validator
                ->requirePresence('Name', 'create')
                ->notEmpty('Name');

        $validator
                ->requirePresence('Phone', 'create')
                ->notEmpty('Phone');

        $validator
                ->requirePresence('Password', 'create')
                ->notEmpty('Password');

        $validator
                ->requirePresence('EmailId', 'create')
                ->notEmpty('EmailId');

        $validator
                ->dateTime('CreatedDate')
                ->allowEmpty('CreatedDate');

        $validator
                ->allowEmpty('PushId');

        $validator
                ->allowEmpty('OsVersionType');

        return $validator;
    }

    /**
     * Registers customer
     * @param \App\Dto\Requests\CustomerRegistrationRequestDto $customerRegistrationRequest
     * @return int $customerid
     */
    public function registerUser($customerRegistrationRequest) {
        $dbNewEntity = $this->newEntity();
        $dbNewEntity->EmailId = $customerRegistrationRequest->emailId;
        $dbNewEntity->Password = $customerRegistrationRequest->password;
        $dbNewEntity->Name = $customerRegistrationRequest->name;
        $dbNewEntity->Phone = $customerRegistrationRequest->phone;
        $dbNewEntity->CreatedDate = new \Cake\I18n\Time();
        if ($this->save($dbNewEntity)) {
            return $dbNewEntity->CustomerId;
        }
        return 0;
    }

    /**
     * Check if same email already exists
     * @param string $emailId
     * @return boolean
     */
    public function emailExists($emailId) {
        $customerExists = $this->exists(['EmailId' => $emailId]);
        return $customerExists;
    }

    /**
     * Gets details of the requested customer login
     * @param string $emailId
     * @param string $password
     * @return \App\Dto\Responses\CustomerLoginResponseDto
     */
    public function getDetails($emailId, $password) {
        $customerLoginResponse = NULL;
        $dbCustomerRecord = $this->find()
                ->where(['EmailId' => $emailId, 'Password' => $password])
                ->select(['Name', 'CustomerId', 'Phone'])
                ->first();

        if ($dbCustomerRecord) {
            $customerLoginResponse = new \App\Dto\Responses\CustomerLoginResponseDto();
            $customerLoginResponse->customerId = $dbCustomerRecord->CustomerId;
            $customerLoginResponse->name = $dbCustomerRecord->Name;
            $customerLoginResponse->phone = $dbCustomerRecord->Phone;
        }
        return $customerLoginResponse;
    }

    /**
     * Updates push notification details for provided customer id
     * @param int $customerId
     * @param string $pushId
     * @param string $osVersionType
     * @return boolean
     */
    public function updatePushNotificationDetails($customerId, $pushId, $osVersionType) {
        $updateSuccess = false;
        $dbCustomer = $this->find()
                ->where(['CustomerId' => $customerId])
                ->select(['CustomerId', 'PushId', 'OsVersionType'])
                ->first();

        if ($dbCustomer) {
            $dbCustomer->PushId = $pushId;
            $dbCustomer->OsVersionType = $osVersionType;
            if ($this->save($dbCustomer)) {
                $updateSuccess = true;
            }
        }
        return $updateSuccess;
    }

    /**
     * Validates customer data against database
     * @param \App\Dto\CustomerCredentialDetailsDto $customerCredentials
     * @return boolean true if exists
     */
    public function validateCustomerData($customerCredentials){
        $customerExists = $this->getTable()->exists([
            'CustomerId' => $customerCredentials->customerId,
            'Password' => $customerCredentials->password]);
        
        return $customerExists;
    }
    
    /**
     * Gets password details for a given email id
     * @param string $customerEmailId
     * @return \App\Dto\UserEmailPasswordDto
     */
    public function getPasswordDetails($customerEmailId){
        $customerDetails = null;
        $dbCustomer = $this->find()
                ->where(['EmailId' => $customerEmailId])
                ->select(['Name', 'Password'])
                ->first();
        if($dbCustomer){
            $customerDetails = new \App\Dto\UserEmailPasswordDto();
            $customerDetails->name = $dbCustomer->Name;
            $customerDetails->password = $dbCustomer->Password;
        }
        return $customerDetails;
    }
    
    /**
     * Updates profile for the customer
     * @param \App\Dto\Requests\CustomerProfileUpdateRequestDto $customerData
     * @param int $customerId
     */
    public function updateProfile($customerData, $customerId){
        $customerInfoUpdated = false;
        $dbCustomer = $this->find()
                ->where(['CustomerId' => $customerId])
                ->select(['Name', 'Password', 'CustomerId', 'Phone', 'EmailId'])
                ->first();
        if($dbCustomer){
            $dbCustomer->Name = $customerData->name;
            $dbCustomer->Phone = $customerData->phone;
            $dbCustomer->EmailId = $customerData->emailId;
            $dbCustomer->Password = $customerData->password;
            if($this->save($dbCustomer)){
                $customerInfoUpdated = true;
            }
        }
        return $customerInfoUpdated;
    }
}
