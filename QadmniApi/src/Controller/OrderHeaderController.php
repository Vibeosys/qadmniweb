<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * OrderHeader Controller
 *
 * @property \App\Model\Table\OrderHeaderTable $OrderHeader
 */
class OrderHeaderController extends AppController {

    public function getLiveOrderList() {
        $this->apiInitialize();

        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        $liveOrderList = $this->OrderHeader->getLiveOrderList($this->postedCustomerData->customerId, $this->languageCode);
        \App\Utils\DeliveryStatusProvider::provideStatus($liveOrderList);

        if ($liveOrderList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(213, $liveOrderList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(118));
        }
    }

    public function getPastOrderList() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        $pastOrderList = $this->OrderHeader->getPastOrderList($this->postedCustomerData->customerId, $this->languageCode);
        \App\Utils\DeliveryStatusProvider::providePastDeliveryStatus($pastOrderList);

        if ($pastOrderList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(214, $pastOrderList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(119));
        }
    }

    public function getVendorOrders() {
        $this->apiInitialize();
        $isProducerValidated = $this->validateProducer();
        if (!$isProducerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(104));
            return;
        }

        $vendorOrderList = $this->OrderHeader->getVendorOrderList();
        \App\Utils\DeliveryStatusProvider::provideDeliveryStatusForVendorList($vendorOrderList);
        if ($vendorOrderList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(215, $vendorOrderList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(120));
        }
    }

    public function updateDeliveryStatus() {
        $this->apiInitialize();
        $isProducerValidated = $this->validateProducer();
        if (!$isProducerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(104));
            return;
        }

        $isDelivered = false;
        $orderStatusUpdateRequest = \App\Dto\Requests\OrderStatusUpdateRequestDto::Deserialize($this->postedData);
        $completionDeliveryStatusList = \App\Utils\DeliveryStatusProvider::getDeliveredStatusList();
        //update is delivered flag if the status update is one of them
        if (in_array($orderStatusUpdateRequest->deliveryStatusId, $completionDeliveryStatusList)) {
            $isDelivered = true;
        }
        $statusUpdated = $this->OrderHeader->updateDeliveryStatus
                ($orderStatusUpdateRequest->orderId, $orderStatusUpdateRequest->deliveryStatusId, $isDelivered);
        if ($statusUpdated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(218));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(123));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
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
    public function view($id = null) {
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
    public function add() {
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
    public function edit($id = null) {
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
    public function delete($id = null) {
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
