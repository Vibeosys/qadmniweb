<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderDtl Model
 *
 * @method \App\Model\Entity\OrderDtl get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderDtl newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderDtl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderDtl|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderDtl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderDtl[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderDtl findOrCreate($search, callable $callback = null, $options = [])
 */
class OrderDtlTable extends Table
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

        $this->table('order_dtl');
        $this->displayField('OrderDtlId');
        $this->primaryKey('OrderDtlId');
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
            ->allowEmpty('OrderDtlId', 'create');

        $validator
            ->integer('OrderId')
            ->requirePresence('OrderId', 'create')
            ->notEmpty('OrderId');

        $validator
            ->integer('ItemId')
            ->allowEmpty('ItemId');

        $validator
            ->integer('ItemQty')
            ->allowEmpty('ItemQty');

        $validator
            ->numeric('ItemUnitPrice')
            ->allowEmpty('ItemUnitPrice');

        $validator
            ->numeric('ItemTotalPrice')
            ->allowEmpty('ItemTotalPrice');

        return $validator;
    }
}