<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrderDtl Controller
 *
 * @property \App\Model\Table\OrderDtlTable $OrderDtl
 */
class OrderDtlController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $orderDtl = $this->paginate($this->OrderDtl);

        $this->set(compact('orderDtl'));
        $this->set('_serialize', ['orderDtl']);
    }

    /**
     * View method
     *
     * @param string|null $id Order Dtl id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderDtl = $this->OrderDtl->get($id, [
            'contain' => []
        ]);

        $this->set('orderDtl', $orderDtl);
        $this->set('_serialize', ['orderDtl']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderDtl = $this->OrderDtl->newEntity();
        if ($this->request->is('post')) {
            $orderDtl = $this->OrderDtl->patchEntity($orderDtl, $this->request->data);
            if ($this->OrderDtl->save($orderDtl)) {
                $this->Flash->success(__('The order dtl has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order dtl could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('orderDtl'));
        $this->set('_serialize', ['orderDtl']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Dtl id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderDtl = $this->OrderDtl->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderDtl = $this->OrderDtl->patchEntity($orderDtl, $this->request->data);
            if ($this->OrderDtl->save($orderDtl)) {
                $this->Flash->success(__('The order dtl has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order dtl could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('orderDtl'));
        $this->set('_serialize', ['orderDtl']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Dtl id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderDtl = $this->OrderDtl->get($id);
        if ($this->OrderDtl->delete($orderDtl)) {
            $this->Flash->success(__('The order dtl has been deleted.'));
        } else {
            $this->Flash->error(__('The order dtl could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
