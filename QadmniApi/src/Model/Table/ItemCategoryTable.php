<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemCategory Model
 *
 * @method \App\Model\Entity\ItemCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemCategoryTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('item_category');
        $this->displayField('CategoryId');
        $this->primaryKey('CategoryId');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('CategoryId')
                ->allowEmpty('CategoryId', 'create');

        $validator
                ->requirePresence('CategoryName_En', 'create')
                ->notEmpty('CategoryName_En');

        $validator
                ->requirePresence('CategoryName_Ar', 'create')
                ->notEmpty('CategoryName_Ar');

        $validator
                ->integer('IsActive')
                ->requirePresence('IsActive', 'create')
                ->notEmpty('IsActive');

        return $validator;
    }

    public function getList($langCode) {
        $categoryList = NULL;
        $categoryName = 'CategoryName_' . $langCode;
        $result = $this->find()
                ->where(['IsActive' => 1])
                ->select(['CategoryId', $categoryName])
                ->all();

        $resultArray = $result->toArray();
        $recordCounter = 0;
        foreach ($resultArray as $categoryRecord) {
            $categoryItem = new \App\Dto\Responses\CategoryListResponseDto();
            $categoryItem->categoryId = $categoryRecord->CategoryId;
            $categoryItem->category = $categoryRecord->$categoryName;
            $categoryList[$recordCounter++] = $categoryItem;
        }
        return $categoryList;
    }

}
