<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require __DIR__ . '/../../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions

// i need a function that will be exported that takes to and body and subject and sends an email
// i need to be able to send an email to a user when they register
// i need to be able to send an email to a user when they reset their password
// i need to be able to send an email to a user when they change their password
// i need to be able to send an email to a user when they change their email

class Mailer
{
    private $host = 'smtp.gmail.com';
    private $userName = 'ek4fly@gmail.com';
    private $password = 'fxzaydpnynjtdela';
    public $from = 'ek4fly@gmail.com';
    public $replyTo = 'ek4fly@gmail.com';
    var $tempVar;
    public $from_name = 'EK4EFLY';
    public $charSet = "CharSet = 'UTF-8'";
    public $charSetOpt = 0;
    public function __construct()
    {
        // $this->conn = $db;
    }

    public function sendEmail($to, $subject, $body, $attachement_path = "", $cc = "", $bcc = "")
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPDebug = false;
        $mail->Host = $this->host;
        $mail->Username = $this->userName;
        $mail->Password = $this->password;
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        if ($this->charSetOpt != 0) {
            $mail->CharSet = $this->charSet;
        }
        $mail->setFrom($this->from, $this->from_name);
        $mail->addAddress($to);
        $mail->addReplyTo($this->replyTo, $this->from_name);
        if ($cc != "") {
            $mail->addCC($cc);
        }
        if ($bcc != "") {
            $mail->addBCC($bcc);
        }
        if ($attachement_path != "") {
            $mail->addAttachment($attachement_path);
        }
        $mail->AddEmbeddedImage('../../image/logo1.png', 'logo');
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
    // send to multiple users
    public function sendEmails($to = array(), $subject, $body, $attachement_path = "", $cc = "", $bcc = "")
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = false;
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Host = $this->host;
        $mail->Username = $this->userName;
        $mail->Password = $this->password;
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        if ($this->charSetOpt != 0) {
            $mail->CharSet = $this->charSet;
        }
        $mail->setFrom($this->from, $this->from_name);
        $mail->addReplyTo($this->replyTo, $this->from_name);
        if ($cc != "") {
            $mail->addCC($cc);
        }
        if ($bcc != "") {
            $mail->addBCC($bcc);
        }
        if ($attachement_path != "") {
            $mail->addAttachment($attachement_path);
        }
        $mail->AddEmbeddedImage('../../image/logo1.png', 'logo');
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        foreach ($to as $email) {
            $mail->addAddress($email);
        }
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}
