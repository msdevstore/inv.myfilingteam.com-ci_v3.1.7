<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email_model extends CI_Model {
    

    function send($email_to, $subject, $message, $email_myself='', $user_mail){
        if ($this->settings->mail_protocol == 'smtp') {

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                
                $mail->CharSet = 'UTF-8';  

                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP(); 

                $mail->Host     = $this->settings->mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = $this->settings->mail_username;
                $mail->Password = base64_decode($this->settings->mail_password);
                if ($this->settings->mail_port == 587) {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       //Enable implicit TLS encryption
                } else {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit SSL encryption
                }
                $mail->Port     = $this->settings->mail_port;       

                //Recipients
                $mail->AddReplyTo($user_mail, $this->business->name);
                $mail->setFrom($user_mail, $this->business->name);
                $mail->addAddress($email_to);     //Add a recipient
                
                // Add cc or bcc 
                if (!empty($email_myself)) {
                    $mail->addCC($email_myself);
                }

                //Content
                $mail->isHTML(true);                                          //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;

                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }

        } else {
            $this->load->library('email');
            $this->load->library('encryption');
            $this->email->set_mailtype('html');
            
            $this->email->from($user_mail, $this->business->name);
            $this->email->to($email_to);
            if (!empty($email_myself)) {
                $this->email->cc($email_myself);
            }
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();

            if($this->email->send()){
               //Success email Sent
               return true;
            }else{
               //Email Failed To Send
               return $this->email->print_debugger();
            }
        }
    }
    

    function send_email($email_to, $subject, $message){

        if ($this->settings->mail_protocol == 'smtp') {

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                
                $mail->CharSet = 'UTF-8';  
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP(); 

                $mail->Host     = $this->settings->mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = $this->settings->mail_username;
                $mail->Password = base64_decode($this->settings->mail_password);
                if ($this->settings->mail_port == 587) {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       //Enable implicit TLS encryption
                } else {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit SSL encryption
                }
                $mail->Port     = $this->settings->mail_port;       

                //Recipients
                $mail->setFrom($this->settings->mail_username, $this->settings->site_name);
                $mail->addAddress($email_to);     //Add a recipient
             
                //Content
                $mail->isHTML(true);                                          //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;

                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        } else {
            $this->load->library('email');
            $this->load->library('encryption');
            $this->email->set_mailtype('html');
            $this->email->from($this->settings->mail_username, $this->settings->site_name);
            $this->email->to($email_to);
            $this->email->subject($subject);
            $this->email->message($message);
            if($this->email->send()){
               //euccess email Sent
               return true;
            }else{
               //email Failed To Send
               return $this->email->print_debugger();
            }
        }
    }

    function send_test_email($email_to, $subject, $message){

        if ($this->settings->mail_protocol == 'smtp') {

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
     
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP(); 

                $mail->Host     = $this->settings->mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = $this->settings->mail_username;
                $mail->Password = base64_decode($this->settings->mail_password);
                if ($this->settings->mail_port == 587) {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                } else {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit SSL encryption
                }
                $mail->Port     = $this->settings->mail_port;             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($this->settings->mail_username, $this->settings->site_name);
                $mail->addAddress($email_to);     //Add a recipient
               
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;

                $mail->send();
                echo "<br><br><strong style='color: green;'>Message has been sent successfully !<strong>";
            } catch (Exception $e) {
                echo "<br><br><strong style='color: red;'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}<strong>";
            }
        } else {
            $this->load->library('email');
            $this->load->library('encryption');
            $this->email->set_mailtype('html');
            $this->email->from($this->settings->mail_username, $this->settings->site_name);
            $this->email->to($email_to);
            $this->email->subject($subject);
            $this->email->message($message);
            if($this->email->send()){
               //euccess email Sent
               return true;
            }else{
               //email Failed To Send
               return $this->email->print_debugger();
            }
        }
    }

}