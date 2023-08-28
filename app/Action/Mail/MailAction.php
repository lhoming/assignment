<?php
namespace App\Action\Mail;

use App\Action\Action;
use App\Model\User;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailAction extends Action
{
    function __construct()
    {
        parent::__construct();
    }
    public function sendVerificationMail($data)
    {
        $mail = new PHPMailer(true);
        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = $this->config['mail_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->config['mail_username'];
            $mail->Password = $this->config['mail_password'];
            $mail->SMTPSecure = $this->config['mail_encription'];
            $mail->Port = $this->config['mail_port'];
            $mail->setFrom($this->config['mail_from'], $this->config['mail_from_name']);
            $mail->addAddress($data['email'], $data['username']);
            $mail->isHTML(true);
            $mail->Subject = '2FA Verification Link';
            $token = str_random();
            $verificationLink = $this->config['app_url'].'/verify-2FA?username='.$data['username'].'&token=' . $token;
            $_SESSION[$data['username'].'_token'] = $token;
            $mail->Body = "
                <p>Hello {$data['username']},</p>
                <p>Click the button below to verify your account:</p>
                <a href='{$verificationLink}' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none;'>Verify Account</a>
                <p>If the button doesn't work, you can also copy and paste the following link into your browser:</p>
                <p>{$verificationLink}</p>
            ";
            $mail->send();
            $userClass = new User();
            $userClass->update(['token'=>$token], ['id'=>$data['id']]);
            return true;
        } catch (Exception $e) {
           return false;
        }
    }
}