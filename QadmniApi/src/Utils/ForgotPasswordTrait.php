<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

trait ForgotPasswordTrait {

    /**
     * Sending pasword email to customer or subscriber
     * @param string $emailId
     * @param string $name
     * @param string $password
     * @return boolean
     */
    public function sendForgotPasswordEmail($emailId, $name, $password) {
        $email = new \Cake\Mailer\Email('default');
        $email->emailFormat('html')->template('ForgotPasswordEmail')
                ->viewVars(['name' => $name, 'password' => $password])
                ->from(QadmniConstants::FROM_EMAIL_ID, QadmniConstants::SUPPORT_TEAM_NAME)
                ->to($emailId, $name)
                ->subject(QadmniConstants::FORGOT_PASSWORD_SUBJECT);
        $emailSendSuccess = $email->send();
        return $emailSendSuccess;
    }

}
