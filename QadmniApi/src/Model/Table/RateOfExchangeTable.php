<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RateOfExchange Model
 *
 * @method \App\Model\Entity\RateOfExchange get($primaryKey, $options = [])
 * @method \App\Model\Entity\RateOfExchange newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RateOfExchange[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RateOfExchange|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RateOfExchange patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RateOfExchange[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RateOfExchange findOrCreate($search, callable $callback = null, $options = [])
 */
class RateOfExchangeTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('rate_of_exchange');
        $this->displayField('ROEDate');
        $this->primaryKey('ROEDate');
    }

    private function getTable() {
        return \Cake\ORM\TableRegistry::get('rate_of_exchange');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->allowEmpty('ROEDate', 'create')
                ->add('ROEDate', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
                ->numeric('Rate')
                ->requirePresence('Rate', 'create')
                ->notEmpty('Rate');

        $validator
                ->dateTime('UpdatedOn')
                ->requirePresence('UpdatedOn', 'create')
                ->notEmpty('UpdatedOn');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['ROEDate']));

        return $rules;
    }

    /**
     * Gets last updated ROE
     * @return \App\Dto\ExchangeRateDto
     */
    public function getLastUpdatedROE() {
        $exchangeRateDto = new \App\Dto\ExchangeRateDto();
        $roeResult = $this->getTable()->find()
                ->select(['Rate', 'ROEDate'])
                ->orderDesc('UpdatedOn')
                ->first();

        if ($roeResult) {
            $dt = new \Cake\I18n\Date();            
            $time = strtotime($roeResult->ROEDate);
            $dt->setTimestamp($time);
            $exchangeRateDto->dateUpdated = $dt;
            $exchangeRateDto->rate = $roeResult->Rate;
        }
        
        return$exchangeRateDto;
    }
    
    /**
     * Adds new exchange rate
     * @param \App\Dto\ExchangeRateDto $exchangeRateData
     * @return boolean 
     */
    public function addNewExchangeRate($exchangeRateData){
        $dt = new \Cake\I18n\Date();
        $formattedDate = $dt->format('d-m-Y');
        
        $dbExchangeRate = $this->getTable()->newEntity();
        $dbExchangeRate->Rate = $exchangeRateData->rate;
        $dbExchangeRate->ROEDate = $formattedDate;
        $dbExchangeRate->UpdatedOn = new \Cake\I18n\Time();
        
        if($this->getTable()->save($dbExchangeRate)){
            return true;
        }
        
        return false;
    }

}
