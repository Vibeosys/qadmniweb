<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemCategory Controller
 *
 * @property \App\Model\Table\ItemCategoryTable $ItemCategory
 */
class ItemCategoryController extends AppController
{

    public function getList(){
        $this->apiInitialize();
        $categoryList= $this->ItemCategory->getList($this->languageCode);
        $this->response->charset('utf-8');
        if($categoryList){
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(201, $categoryList));
        }
        else{
            $this->response->body(\App\Utils\ResponseMessages::prepareError(101));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $itemCategory = $this->paginate($this->ItemCategory);

        $this->set(compact('itemCategory'));
        $this->set('_serialize', ['itemCategory']);
    }

    /**
     * View method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemCategory = $this->ItemCategory->get($id, [
            'contain' => []
        ]);

        $this->set('itemCategory', $itemCategory);
        $this->set('_serialize', ['itemCategory']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemCategory = $this->ItemCategory->newEntity();
        if ($this->request->is('post')) {
            $itemCategory = $this->ItemCategory->patchEntity($itemCategory, $this->request->data);
            if ($this->ItemCategory->save($itemCategory)) {
                $this->Flash->success(__('The item category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('itemCategory'));
        $this->set('_serialize', ['itemCategory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemCategory = $this->ItemCategory->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemCategory = $this->ItemCategory->patchEntity($itemCategory, $this->request->data);
            if ($this->ItemCategory->save($itemCategory)) {
                $this->Flash->success(__('The item category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('itemCategory'));
        $this->set('_serialize', ['itemCategory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemCategory = $this->ItemCategory->get($id);
        if ($this->ItemCategory->delete($itemCategory)) {
            $this->Flash->success(__('The item category has been deleted.'));
        } else {
            $this->Flash->error(__('The item category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
