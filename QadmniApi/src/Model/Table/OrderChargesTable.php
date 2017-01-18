<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderCharges Model
 *
 * @method \App\Model\Entity\OrderCharge get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderCharge newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderCharge[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderCharge|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderCharge patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderCharge[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderCharge findOrCreate($search, callable $callback = null, $options = [])
 */
class OrderChargesTable extends Table
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

        $this->table('order_charges');
        $this->displayField('ChargeAutoId');
        $this->primaryKey('ChargeAutoId');
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
            ->allowEmpty('ChargeAutoId', 'create');

        $validator
            ->integer('OrderId')
            ->requirePresence('OrderId', 'create')
            ->notEmpty('OrderId');

        $validator
            ->integer('ChargeId')
            ->requirePresence('ChargeId', 'create')
            ->notEmpty('ChargeId');

        $validator
            ->numeric('ChargePercent')
            ->allowEmpty('ChargePercent');

        $validator
            ->numeric('ChargeAmount')
            ->requirePresence('ChargeAmount', 'create')
            ->notEmpty('ChargeAmount');

        return $validator;
    }
}
