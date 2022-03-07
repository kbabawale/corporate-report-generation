<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (file_exists('PHPMailer/src/Exception.php') && file_exists('PHPMailer/src/PHPMailer.php') && file_exists('PHPMailer/src/SMTP.php')) {
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
}
else {
    throw new Exception("(report.php) Mailer files do not exist");

}

$start_dtt = $end_dtt = date('2018-09-05');
$time_start = microtime(true);

require('util.php');

require_once 'mail/Swift_mail/lib/swift_required.php';

class Report
{

    protected $messages = array();

    public function getMessages()
    {
        return $this->messages;
    }

    public function __construct($tobacco, $jj, $mr, $hmt, $gw, $competition)
    {
        if ($tobacco === true) {
            Util::prepareExcel1();
        // if(file_exists(dirname(__FILE__).'/Reports/Tobacco_Call_Center_Summary_'.date('Y-m-d').'.xlsx')){ //if report is generated, send mail
        //     $rec = $this->getRecipients("7");
        //     $attachments = dirname(__FILE__).'/Reports/Tobacco_Call_Center_Summary_'.date('Y-m-d').'.xlsx'; 
        //     //$this->messages[] = 'yeah';
        //     $this->sendMail($rec, $attachments, 'Tobacco');
        // }else{
        //     $this->messages[] = "File doesnt exist";
        // }

        }
        if ($jj === true) {
            Util::prepareExcel2();
        // if(file_exists(dirname(__FILE__).'/Reports/J_and_JReport'.date('Y-m-d').'.xlsx')){
        //     $rec = $this->getRecipients("3");
        //     $attachments = dirname(__FILE__).'/Reports/J_and_JReport'.date('Y-m-d').'.xlsx'; 
        //     //echo $attachments;
        //     $this->sendMail($rec, $attachments, 'Johnson & Johnson');
        // }else{
        //     $this->messages[] = "File doesnt exist";
        // }
        }
        if ($mr === true) {
            Util::prepareExcel3();
        // if(file_exists(dirname(__FILE__).'/Reports/Mars_and_Wrigley'.date('Y-m-d').'.xlsx')){
        //     $rec = $this->getRecipients("0");
        //     $attachments = dirname(__FILE__).'/Reports/Mars_and_Wrigley'.date('Y-m-d').'.xlsx'; 
        //     //echo $attachments;
        //     $this->sendMail($rec, $attachments,'Mars & Wrigley');
        // }else{
        //     $this->messages[] = "File doesnt exist";
        // }
        }
        if ($hmt === true) {
            Util::prepareExcel4();
        // if(file_exists(dirname(__FILE__).'/Reports/Horeca_And_Modern_Trade'.date('Y-m-d').'.xlsx')){
        //     $rec = $this->getRecipients("2");
        //     $attachments = dirname(__FILE__).'/Reports/Horeca_And_Modern_Trade'.date('Y-m-d').'.xlsx'; 
        //     //echo $attachments;
        //     $this->sendMail($rec, $attachments, 'Horeca And Modern Trade');
        // }else{
        //     $this->messages[] = "File doesnt exist";
        // }
        }
        if ($gw === true) {
            Util::prepareExcel5();
        // if(file_exists('Reports/Gallo_Wholesalers'.date('Y-m-d').'.xlsx')){
        //     $rec = $this->getRecipients("1");
        //     $attachments = 'Reports/Gallo_Wholesalers'.date('Y-m-d').'.xlsx'; 
        //     //echo $attachments;
        //     $this->sendMail($rec, $attachments, 'Gallo Wholesalers');
        // }else{
        //     $this->messages[] = "File doesnt exist";
        // }
        }
        if ($competition === true) {
            Util::prepareExcel6();
        // if(file_exists('Reports/Gallo_Wholesalers'.date('Y-m-d').'.xlsx')){
        //     $rec = $this->getRecipients("1");
        //     $attachments = 'Reports/Gallo_Wholesalers'.date('Y-m-d').'.xlsx'; 
        //     //echo $attachments;
        //     $this->sendMail($rec, $attachments, 'Gallo Wholesalers');
        // }else{
        //     $this->messages[] = "File doesnt exist";
        // }
        }
    } //constructor

    public function connect($db)
    {
        $servername = "91.109.247.182";
        $username = "mtrader";
        $password = "XXXXXXXXXX!";
        $conn = new mysqli($servername, $username, $password);
        $conn->select_db($db);

        return $conn;
    } //connect

    public function getRecipients($rec)
    {
        $emails = array();
        $qry = "select email from recipients where category like '%|$rec|%'";
        if ($result = $this->connect('call_centre')->query($qry)) {
            while ($row = $result->fetch_row()) {
                $emails[] = $row[0];
            }
        }
        return $emails; //returns an array of emails
    } //getRecipients

    public function sendMail($to, $attachmentArray, $unit)
    {
        // Passing `true` enables exceptions
        $mail = new PHPMailer(true); // Passing `true` enables exceptions

        //Server settings
        $mail->SMTPDebug = 2; // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'secure.emailsrvr.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'mobiletrader@greatbrandsng.com'; // SMTP username
        $mail->Password = 'XXXXXXXXXX'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465; // TCP port to connect to

        //Recipients
        $mail->setFrom('mobiletrader@greatbrandsng.com', 'MobileTrader');
        $mail->addAddress("softwaredeveloper2.ho@greatbrandsng.com", "Kolapo Babawale");

        //Attachments
        if (is_array($attachmentArray)) {
            foreach ($attachmentArray as $attachmentArray1) {
                $mail->addAttachment($attachmentArray1);
            }
        }
        else {
            $mail->addAttachment($attachmentArray);
        }

        //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Escalated Mail from the CRO';
        $mail->Body = "<p>Dear All,</p><p></p><br><br>
            Please, find attached the <b>Call Center Summary for $unit</b> for today.</p><br><br>
            <p>Regards,</p><br><br>
            <p><b>Mobile Trader</b></p>";

        if (!$mail->send()) {
            $this->messages[] = "Mailer Error: " . $mail->ErrorInfo;

        }
        else {
            $this->messages[] = "Message has been sent successfully";

        }

    } //sendMail

    function sendMail2($to, $attachmentArray, $unit)
    {

        $host = 'secure.emailsrvr.com';
        $port = 587;
        $user = 'mobiletrader@greatbrandsng.com';
        $usnm = 'Mobiletrader';
        $pwd = 'XXXXXXXXXX';
        $transport = Swift_SmtpTransport::newInstance($host, $port);
        $transport->setUsername($user);
        $transport->setPassword($pwd);
        $mailer = Swift_Mailer::newInstance($transport);
        $logger = new Swift_Plugins_Loggers_ArrayLogger();
        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
        $subject = "Escalated Mail from the CRO";
        $msg = Swift_Message::newInstance();
        $msg->setSubject($subject);
        $msg->setFrom('mobiletrader@greatbrandsng.com');
        //$msg->setContentType("text/html");        

        //$msg->setTo($to);
        $msg->setTo('softwaredeveloper2.ho@greatbrandsg.com');
        //$msg->setReadReceiptTo($cc);    
        $message = '<p>Dear All,</p><p></p><br><br>
        Please, find attached the <b>Call Center Summary for $unit</b> for today.</p><br><br>
        <p>Regards,</p><br><br>
        <p><b>Mobile Trader</b></p>';
        $msg->setBody($message);
        $failures = 'log.txt';
        if ($mailer->send($msg, $failures)) {
            return true;
        }
        else {
            print_r($failures);
            echo '<br>concluded<br>';
            return false;

        }
    }


}

$report = new Report(true, true, true, true, true, false);
$mess = $report->getMessages();

foreach ($mess as $mess1) {
    echo $mess1 . "<br />";
}

//Dami - 7
//Bolanle - 1
//Catherine - 2
//Adebola - 3
//Chinwe - 0
//Judith - 9

//J and J--Call Summary
//Tobacco - - Call Center Summary -
//Horeca & Modern Trade -- Call Summary
//Gallo Wholesalers -- Call Summary

// Dear All,

// Please, find attached the Call Center Summary for Johnson & Johnson for today.

// Regards,

// Mobile Trader

?>