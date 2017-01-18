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
class OrderHeaderTable extends Table
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

        $this->table('order_header');
        $this->displayField('OrderId');
        $this->primaryKey('OrderId');
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
}
