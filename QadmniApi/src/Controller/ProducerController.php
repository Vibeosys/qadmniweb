<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Producer Controller
 *
 * @property \App\Model\Table\ProducerTable $Producer
 */
class ProducerController extends AppController {

    use \App\Utils\ForgotPasswordTrait;

    public function signUp() {
        $this->apiInitialize();
        $producerSignupRequest = \App\Dto\Requests\ProducerSignupRequestDto::Deserialize($this->postedData);

        $producerAdditionSuccess = $this->Producer->addNewProducer($producerSignupRequest);
        if ($producerAdditionSuccess) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(203));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(103));
        }
    }

    public function login() {
        $this->apiInitialize();
        $producerLoginRequest = \App\Dto\Requests\ProducerLoginRequestDto::Deserialize($this->postedData);
        $producerDetails = $this->Producer->getDetails($producerLoginRequest);
        if (!$producerDetails) {
            //TODO Unsuccessful login
            $this->response->body(\App\Utils\ResponseMessages::prepareError(104));
            return;
        }
        //Set typed value to OS type for push notifications
        $osTypeRequested = $producerLoginRequest->pushDeviceOsType;
        $producerLoginRequest->pushDeviceOsType = \App\Utils\QadmniUtils::requestedNotificationOsType($osTypeRequested);

        //Update push notification details to db
        $notificationDetailsUpdateSuccess = $this->Producer->updateNotificationDetails
                ($producerDetails->producerId, $producerLoginRequest->pushNotificationId, $producerLoginRequest->pushDeviceOsType);
        //Log an error if no notifications updated
        if (!$notificationDetailsUpdateSuccess) {
            \Cake\Log\Log::error('Notifications could not be updated for producer with id ' . $producerDetails->producerId);
        }

        $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(204, $producerDetails));
    }

    public function forgotPassword() {
        $this->apiInitialize();
        $forgotPasswordRequest = \App\Dto\Requests\ForgotPasswordRequestDto::Deserialize($this->postedData);
        $producerDetails = $this->Producer->getPasswordDetails($forgotPasswordRequest->emailId);

        $emailSent = false;

        if ($producerDetails) {
            try {
                $emailSent = $this->sendForgotPasswordEmail($forgotPasswordRequest->emailId, $producerDetails->name, $producerDetails->password);
            } catch (\Exception $ex) {
                $emailSent = false;
                Cake\Log\Log::error($ex->getTraceAsString());
            }
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(121));
            return;
        }
        //If email is sent then go ahead
        if ($emailSent) {
            $this->response->body(\App\Utils\ResponseMessages::prepareSuccessMessage(216));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(114));
        }
    }

    public function checkEmailExists() {
        $this->apiInitialize();
        $vendorEmailVerificationRequest = \App\Dto\Requests\VendorEmailVerificationRequest::Deserialize($this->postedData);
        $producerDetails = $this->Producer->getPasswordDetails($vendorEmailVerificationRequest->emailId);

        $this->Producer->getPasswordDetails($vendorEmailVerificationRequest->emailId);
        if ($producerDetails) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(122));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareSuccessMessage(217));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $producer = $this->paginate($this->Producer);

        $this->set(compact('producer'));
        $this->set('_serialize', ['producer']);
    }

    /**
     * View method
     *
     * @param string|null $id Producer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $producer = $this->Producer->get($id, [
            'contain' => []
        ]);

        $this->set('producer', $producer);
        $this->set('_serialize', ['producer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $producer = $this->Producer->newEntity();
        if ($this->request->is('post')) {
            $producer = $this->Producer->patchEntity($producer, $this->request->data);
            if ($this->Producer->save($producer)) {
                $this->Flash->success(__('The producer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The producer could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('producer'));
        $this->set('_serialize', ['producer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Producer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $producer = $this->Producer->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $producer = $this->Producer->patchEntity($producer, $this->request->data);
            if ($this->Producer->save($producer)) {
                $this->Flash->success(__('The producer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The producer could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('producer'));
        $this->set('_serialize', ['producer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Producer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $producer = $this->Producer->get($id);
        if ($this->Producer->delete($producer)) {
            $this->Flash->success(__('The producer has been deleted.'));
        } else {
            $this->Flash->error(__('The producer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
