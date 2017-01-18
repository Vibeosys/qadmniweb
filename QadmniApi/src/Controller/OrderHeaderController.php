<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrderHeader Controller
 *
 * @property \App\Model\Table\OrderHeaderTable $OrderHeader
 */
class OrderHeaderController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $orderHeader = $this->paginate($this->OrderHeader);

        $this->set(compact('orderHeader'));
        $this->set('_serialize', ['orderHeader']);
    }

    /**
     * View method
     *
     * @param string|null $id Order Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderHeader = $this->OrderHeader->get($id, [
            'contain' => []
        ]);

        $this->set('orderHeader', $orderHeader);
        $this->set('_serialize', ['orderHeader']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderHeader = $this->OrderHeader->newEntity();
        if ($this->request->is('post')) {
            $orderHeader = $this->OrderHeader->patchEntity($orderHeader, $this->request->data);
            if ($this->OrderHeader->save($orderHeader)) {
                $this->Flash->success(__('The order header has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order header could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('orderHeader'));
        $this->set('_serialize', ['orderHeader']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Header id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderHeader = $this->OrderHeader->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderHeader = $this->OrderHeader->patchEntity($orderHeader, $this->request->data);
            if ($this->OrderHeader->save($orderHeader)) {
                $this->Flash->success(__('The order header has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order header could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('orderHeader'));
        $this->set('_serialize', ['orderHeader']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Header id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderHeader = $this->OrderHeader->get($id);
        if ($this->OrderHeader->delete($orderHeader)) {
            $this->Flash->success(__('The order header has been deleted.'));
        } else {
            $this->Flash->error(__('The order header could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
