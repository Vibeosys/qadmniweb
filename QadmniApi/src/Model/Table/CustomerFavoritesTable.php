<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerFavorites Model
 *
 * @method \App\Model\Entity\CustomerFavorite get($primaryKey, $options = [])
 * @method \App\Model\Entity\CustomerFavorite newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CustomerFavorite[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CustomerFavorite|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CustomerFavorite patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerFavorite[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerFavorite findOrCreate($search, callable $callback = null, $options = [])
 */
class CustomerFavoritesTable extends Table
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

        $this->table('customer_favorites');
        $this->displayField('FavId');
        $this->primaryKey('FavId');
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
            ->integer('FavId')
            ->allowEmpty('FavId', 'create');

        $validator
            ->integer('CustomerId')
            ->requirePresence('CustomerId', 'create')
            ->notEmpty('CustomerId');

        $validator
            ->integer('ItemId')
            ->requirePresence('ItemId', 'create')
            ->notEmpty('ItemId');

        return $validator;
    }
    
    /**
     * Adds product to favorites
     * @param int $customerId
     * @param int $productId
     * @return boolean
     */
    public function addToFavorite($customerId, $productId){
        $addSuccess = true;
        $dbFav = $this->find()
                ->where(['CustomerId' => $customerId, 'ItemId' => $productId])
                ->first();
        
        if(!$dbFav){
            $dbFav = $this->newEntity();
            $dbFav->CustomerId = $customerId;
            $dbFav->ItemId = $productId;
            if(!$this->save($dbFav)){
                $addSuccess = false;
            }
        }
        return $addSuccess;
    }
    
    /**
     * Removes product from favorites
     * @param int $customerId
     * @param int $productId
     * @return boolean
     */
    public function removeFavorite($customerId, $productId){
        $deleteSuccess   = false;
        $dbFav = $this->find()
                ->where(['CustomerId' => $customerId, 'ItemId' => $productId])
                ->first();
        if($dbFav){
            if($this->delete($dbFav)){
                $deleteSuccess = true;
            }
        }
        return $deleteSuccess;
    }
}
