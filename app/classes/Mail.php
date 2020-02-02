<?php

namespace App\Classes;

use Swift_Mailer as Mailer;
use Swift_SmtpTransport as Transport;
use Swift_Message as Message;

class Mail
{
    protected $transport;
    protected $mailer;
    protected $mode = [
        'development' => [
            'host' => '',
            'port' => ,
            'username' => '',
            'password' => '',         
            'activationLink' => ''
        ],
        'production' => []
    ];

    public function __construct($mode = 'development') 
    {   
        $this->transport = (new Transport($this->mode[$mode]['host'], $this->mode[$mode]['port']))
                                    ->setUsername($this->mode[$mode]['username'])
                                    ->setPassword($this->mode[$mode]['password']);

        $this->mailer = new Mailer($this->transport);
    }

    public function activate($mode, $email, $username, $activationCode)
    {
        $message = (new Message('Activação de Conta'))
        ->setFrom(['admin@mathmatica.net' => 'Direcção'])
        ->setTo([$email => $username])
        ->setBody(
            '<h1>Activação de Conta<h1>
            <p>Olá, '. $username .'!</p>
            <br>
            <p>Clique no link para activar a sua conta:</p>
            <br>
            <a href="'. $this->mode[$mode]['activationLink'] . $email .'/'. $activationCode .'">Activar Conta</a>
            <br><br>
            Direcção do Mathmatica.
            ', 
            'text/html'
        );

        // mailer returns 0 if no recipients has sent the email
        // converted that to false if 0 
        if($this->mailer->send($message)) {
            return true;
        }

        return false;
    }

    public function reset_password($email, $username, $temporaryPassword)
    {

        $message = (new Message('Nova Palavra-Passe'))
        ->setFrom(['admin@mathmatica.net' => 'Direcção'])
        ->setTo([$email => $username])
        ->setBody(
            '<h1>Nova Palavra-Passe<h1>
            <p>Olá, '. $username .'!</p>
            <br>
            <p><strong>Nova Palavra-Passe:</strong> '. $temporaryPassword .'</p>
            <br>
            <p style="color: red;">Esta palavra-passe deve ser temporária! Não se esqueça de alterar a palavra-passe assim que possível.</p>
            <br><br>
            Direcção do Mathmatica.
            ', 
            'text/html'
        );

        // mailer returns 0 if no recipients has sent the email
        // converted that to false if 0 
        if($this->mailer->send($message)) {
            return true;
        }

        return false;

    }

    public function resend_activation($mode, $email, $username, $activationCode)
    {
        $message = (new Message('Nova Activação de Conta'))
        ->setFrom(['admin@mathmatica.net' => 'Direcção'])
        ->setTo([$email => $username])
        ->setBody(
            '<h1>Activação de Conta<h1>
            <p>Olá, '. $username .'!</p>
            <br>
            <p>Clique no link abaixo para activar a sua conta.</p>
            <br>
            <a href="'. $this->mode[$mode]['activationLink'] . $email .'/'. $activationCode .'">Activar Conta</a>
            <br><br>
            Direcção do Mathmatica.
            ', 
            'text/html'
        );

        // mailer returns 0 if no recipients has sent the email
        // converted that to false if 0 
        if($this->mailer->send($message)) {
            return true;
        }

        return false;
    }

    public function contact($email, $name, $subject, $text)
    {
        $message = (new Message($subject))
        ->setFrom([$email => $name])
        ->setTo(['admin@mathmatica.net' => 'Admin'])
        ->setBody($text, 'text/html');

        // mailer returns 0 if no recipients has sent the email
        // converted that to false if 0 
        if($this->mailer->send($message)) {
            return true;
        }

        return false;
    }

}