<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrderCharges Controller
 *
 * @property \App\Model\Table\OrderChargesTable $OrderCharges
 */
class OrderChargesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $orderCharges = $this->paginate($this->OrderCharges);

        $this->set(compact('orderCharges'));
        $this->set('_serialize', ['orderCharges']);
    }

    /**
     * View method
     *
     * @param string|null $id Order Charge id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderCharge = $this->OrderCharges->get($id, [
            'contain' => []
        ]);

        $this->set('orderCharge', $orderCharge);
        $this->set('_serialize', ['orderCharge']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderCharge = $this->OrderCharges->newEntity();
        if ($this->request->is('post')) {
            $orderCharge = $this->OrderCharges->patchEntity($orderCharge, $this->request->data);
            if ($this->OrderCharges->save($orderCharge)) {
                $this->Flash->success(__('The order charge has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order charge could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('orderCharge'));
        $this->set('_serialize', ['orderCharge']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Charge id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderCharge = $this->OrderCharges->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderCharge = $this->OrderCharges->patchEntity($orderCharge, $this->request->data);
            if ($this->OrderCharges->save($orderCharge)) {
                $this->Flash->success(__('The order charge has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order charge could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('orderCharge'));
        $this->set('_serialize', ['orderCharge']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Charge id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderCharge = $this->OrderCharges->get($id);
        if ($this->OrderCharges->delete($orderCharge)) {
            $this->Flash->success(__('The order charge has been deleted.'));
        } else {
            $this->Flash->error(__('The order charge could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
