<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Customer Controller
 *
 * @property \App\Model\Table\CustomerTable $Customer
 */
class CustomerController extends AppController {

    use \App\Utils\ForgotPasswordTrait;

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

    public function forgotPassword() {
        $this->apiInitialize();
        $forgotPasswordRequest = \App\Dto\Requests\ForgotPasswordRequestDto::Deserialize($this->postedData);
        $customerDetails = $this->Customer->getPasswordDetails($forgotPasswordRequest->emailId);

        $emailSent = false;

        if ($customerDetails) {
            try {
                $emailSent = $this->sendForgotPasswordEmail($forgotPasswordRequest->emailId, 
                        $customerDetails->name, $customerDetails->password);
            } catch (\Exception $ex) {
                $emailSent = false;
                \Cake\Log\Log::error($ex->getTraceAsString());                
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

    public function updateProfile(){
        $this->apiInitialize();
        //validate customer
        $isCustomerValid = $this->validateCustomer();
        if(!$isCustomerValid){
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }
        
        $profileUpdateRequest = \App\Dto\Requests\CustomerProfileUpdateRequestDto::Deserialize($this->postedData);
        $profileUpdated = $this->Customer->updateProfile($profileUpdateRequest, $this->postedCustomerData->customerId);
        if($profileUpdated){
            $this->response->body(\App\Utils\ResponseMessages::prepareSuccessMessage(226));
        }else{
            $this->response->body(\App\Utils\ResponseMessages::prepareError(132));
        }
    }

}
