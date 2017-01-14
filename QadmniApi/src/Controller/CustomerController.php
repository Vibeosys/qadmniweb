<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Customer Controller
 *
 * @property \App\Model\Table\CustomerTable $Customer
 */
class CustomerController extends AppController {

    public function register() {
        $this->apiInitialize();
        $customerRegistrationRequest = \App\Dto\Requests\CustomerRegistrationRequestDto::Deserialize($this->postedData);
        $isDuplicateCustomer = $this->Customer->emailExists($customerRegistrationRequest->emailId);
        if ($isDuplicateCustomer) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(108));
            return;
        }
        //If email is new one then go ahead and register the customer
        $resultCustomerId = $this->Customer->registerUser($customerRegistrationRequest);
        if ($resultCustomerId) {
            $customerRegistrationResponse = new \App\Dto\Responses\CustomerRegistrationResponseDto();
            $customerRegistrationResponse->customerId = $resultCustomerId;
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(206, $customerRegistrationResponse));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(107));
        }
    }

    public function login() {
        $this->apiInitialize();
        $customerLoginRequest = \App\Dto\Requests\CustomerLoginRequestDto::Deserialize($this->postedData);
        $customerDetails = $this->Customer->getDetails($customerLoginRequest->emailId, $customerLoginRequest->password);

        if ($customerDetails) {
            //Get correct notification OS type like android or ios
            $osVersionType = \App\Utils\QadmniUtils::requestedNotificationOsType($customerLoginRequest->osVersionType);
            //Update the notifications
            $notificationUpdateSuccess = $this->Customer->updatePushNotificationDetails
                    ($customerDetails->customerId, $customerLoginRequest->pushId, $osVersionType);
            if (!$notificationUpdateSuccess) {
                \Cake\Log\Log::error('Notification details could not be updated for customer id ' . $customerDetails->customerId);
            }
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(207, $customerDetails));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(109));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $customer = $this->paginate($this->Customer);

        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $customer = $this->Customer->get($id, [
            'contain' => []
        ]);

        $this->set('customer', $customer);
        $this->set('_serialize', ['customer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $customer = $this->Customer->newEntity();
        if ($this->request->is('post')) {
            $customer = $this->Customer->patchEntity($customer, $this->request->data);
            if ($this->Customer->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The customer could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $customer = $this->Customer->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customer->patchEntity($customer, $this->request->data);
            if ($this->Customer->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The customer could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customer->get($id);
        if ($this->Customer->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
