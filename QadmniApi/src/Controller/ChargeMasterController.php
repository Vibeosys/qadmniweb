<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ChargeMaster Controller
 *
 * @property \App\Model\Table\ChargeMasterTable $ChargeMaster
 */
class ChargeMasterController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $chargeMaster = $this->paginate($this->ChargeMaster);

        $this->set(compact('chargeMaster'));
        $this->set('_serialize', ['chargeMaster']);
    }

    /**
     * View method
     *
     * @param string|null $id Charge Master id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chargeMaster = $this->ChargeMaster->get($id, [
            'contain' => []
        ]);

        $this->set('chargeMaster', $chargeMaster);
        $this->set('_serialize', ['chargeMaster']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chargeMaster = $this->ChargeMaster->newEntity();
        if ($this->request->is('post')) {
            $chargeMaster = $this->ChargeMaster->patchEntity($chargeMaster, $this->request->data);
            if ($this->ChargeMaster->save($chargeMaster)) {
                $this->Flash->success(__('The charge master has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The charge master could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('chargeMaster'));
        $this->set('_serialize', ['chargeMaster']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Charge Master id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chargeMaster = $this->ChargeMaster->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chargeMaster = $this->ChargeMaster->patchEntity($chargeMaster, $this->request->data);
            if ($this->ChargeMaster->save($chargeMaster)) {
                $this->Flash->success(__('The charge master has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The charge master could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('chargeMaster'));
        $this->set('_serialize', ['chargeMaster']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Charge Master id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chargeMaster = $this->ChargeMaster->get($id);
        if ($this->ChargeMaster->delete($chargeMaster)) {
            $this->Flash->success(__('The charge master has been deleted.'));
        } else {
            $this->Flash->error(__('The charge master could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
