<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public $about_url = URLROOT . '/about';
    public $privacy_url = URLROOT . '/about/privacy';
    public $terms_url = URLROOT . '/about/terms';
    public $email_template = '';
    public $verify_url = '';
    public $subject = '';
    public $message =  '';

    function __construct($verificationData)
    {
        $this->mail = new PHPMailer(true);
        $this->data = $verificationData;
    }

    function start()
    {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  
        $this->mail->isSMTP();
        $this->mail->Host       = MAIL_HOST;
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = MAIL_USERNAME;
        $this->mail->Password   = MAIL_PASSWORD;
        $this->mail->Port       = MAIL_PORT;
        $this->mail->SMTPSecure = 'tls';        
    }

    function setRecipients()
    {
        $this->mail->setFrom(MAIL_FROM_ADDRESS, 'pda-dcc.com');
        $this->mail->addAddress($this->data['receiver_email'], 'PDA-DCC member');
    }

    function setMessage()
    {
        $this->message = file_get_contents($this->email_template);
        $this->message = str_replace('{{verify_url}}', $this->verify_url, $this->message);
        $this->message = str_replace('{{about_url}}', $this->about_url, $this->message);
        $this->message = str_replace('{{privacy_url}}', $this->privacy_url, $this->message);
        $this->message = str_replace('{{terms_url}}', $this->terms_url, $this->message);

        $this->mail->isHTML(true);
        $this->mail->Subject = $this->subject;
        $this->mail->MsgHTML($this->message);
    }

    function send()
    {
        $this->mail->send();

        if (isset($this->data['logoutAfter']) && $this->data['logoutAfter']) {
            sessionDestroyAll();
        }
        $this->view(
            'users/redirectPage',
            $this->data = [
                'message' => 'A confirmation link was just sent to ' . $this->data['receiver_email'] . '. The changes will take effect after you have clicked the link.',
                'email' => $this->data['receiver_email']
            ]
        );
    }
}
