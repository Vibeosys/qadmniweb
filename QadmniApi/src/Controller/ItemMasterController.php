<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemMaster Controller
 *
 * @property \App\Model\Table\ItemMasterTable $ItemMaster
 */
class ItemMasterController extends AppController {

    public function getList() {
        $this->apiInitialize();
        $itemListRequest = \App\Dto\Requests\ItemListRequestDto::Deserialize($this->postedData);
        $itemList = $this->ItemMaster->getItemList($this->languageCode, $itemListRequest->categoryId);
        if ($itemList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(202, $itemList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(102));
        }
    }

    public function getVendorItemList() {
        $this->apiInitialize();
        $isVendorValidated = $this->validateProducer();
        if (!$isVendorValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(105));
            return;
        }
        //Gets the list of items for a vendor id
        $itemList = $this->ItemMaster->getVendorItemList($this->languageCode, $this->postedProducerData->producerId);
        if ($itemList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(205, $itemList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(106));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $itemMaster = $this->paginate($this->ItemMaster);

        $this->set(compact('itemMaster'));
        $this->set('_serialize', ['itemMaster']);
    }

    /**
     * View method
     *
     * @param string|null $id Item Master id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $itemMaster = $this->ItemMaster->get($id, [
            'contain' => []
        ]);

        $this->set('itemMaster', $itemMaster);
        $this->set('_serialize', ['itemMaster']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $itemMaster = $this->ItemMaster->newEntity();
        if ($this->request->is('post')) {
            $itemMaster = $this->ItemMaster->patchEntity($itemMaster, $this->request->data);
            if ($this->ItemMaster->save($itemMaster)) {
                $this->Flash->success(__('The item master has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item master could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('itemMaster'));
        $this->set('_serialize', ['itemMaster']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Master id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $itemMaster = $this->ItemMaster->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemMaster = $this->ItemMaster->patchEntity($itemMaster, $this->request->data);
            if ($this->ItemMaster->save($itemMaster)) {
                $this->Flash->success(__('The item master has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item master could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('itemMaster'));
        $this->set('_serialize', ['itemMaster']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Master id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $itemMaster = $this->ItemMaster->get($id);
        if ($this->ItemMaster->delete($itemMaster)) {
            $this->Flash->success(__('The item master has been deleted.'));
        } else {
            $this->Flash->error(__('The item master could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
