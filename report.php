<?php 
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;



try{
    ob_start();

    if(file_exists('util.php')){
        require('util.php');
    }else{
        throw new Exception("(report.php) util.php file doesnt exist");
    }

    if(file_exists('PHPMailer/src/Exception.php') && file_exists('PHPMailer/src/PHPMailer.php') && file_exists('PHPMailer/src/SMTP.php')){
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
    }else{
        throw new Exception("(report.php) Mailer files do not exist");   
    }

    require_once 'mail/Swift_mail/lib/swift_required.php';


    class Report{

        protected $messages = array();

        public function getMessages(){
            return $this->messages;
        }

        public function __construct($tobacco, $jj, $mr, $hmt, $gw){
            if($tobacco === true){
                if(Util::prepareExcel1()){ //if report is generated, send mail
                    $rec = $this->getRecipients("7");
                    $attachments = dirname(__FILE__).'/Reports/Tobacco_Call_Center_Summary_'.date('Y-m-d').'.xlsx'; 
                    $this->sendMail2($rec, $attachments, 'Tobacco');
                }
            }
            if($jj === true){
                if(Util::prepareExcel2()){
                    $rec = $this->getRecipients("3");
                    $attachments = dirname(__FILE__).'/Reports/J_and_JReport'.date('Y-m-d').'.xlsx'; 
                    $this->sendMail2($rec, $attachments, 'Johnson & Johnson');
                }
            }
            if($mr === true){
                if(Util::prepareExcel3()){
                    $rec = $this->getRecipients("0");
                    $attachments = dirname(__FILE__).'/Reports/Mars_and_Wrigley'.date('Y-m-d').'.xlsx'; 
                    $this->sendMail2($rec, $attachments,'Mars & Wrigley');
                }
            }
            if($hmt === true){
                if(Util::prepareExcel4()){
                    $rec = $this->getRecipients("2");
                    $attachments = dirname(__FILE__).'/Reports/Horeca_And_Modern_Trade'.date('Y-m-d').'.xlsx'; 
                    $this->sendMail2($rec, $attachments, 'Horeca And Modern Trade');
                }
            }
            if($gw === true){
                Util::prepareExcel5();
            }
        }//constructor

        public function connect($db){
            $servername = "91.109.247.182";
            $username = "mtrader";
            $password = "gtXeAg0dtBB!";
            $conn = new mysqli($servername, $username, $password);
            $conn->select_db($db);
            
            return $conn;
        }//connect

        public function getRecipients($rec){ 
            $emails = array();
            $qry = "select email from recipients where category like '%|$rec|%'";
            if($result = $this->connect('call_centre')->query($qry)){
                While($row = $result->fetch_row()){
                    $emails[]  = $row[0];
                }
            }
            return $emails; //returns an array of emails
        }//getRecipients

        public function sendMail($to, $attachmentArray, $unit){
            // Passing `true` enables exceptions
            try {
                $mail = new PHPMailer;

                $mail->From = "mobiletrader@greatbrandsng.com";
                $mail->FromName = "Mobile Trader";

                $mail->addAddress("softwaredeveloper2.ho@greatbrandsng.com", "Kolapo Babawale");

                //Attachments
                if(is_array($attachmentArray)){
                    foreach($attachmentArray as $attachmentArray1){
                        $mail->addAttachment($attachmentArray1);
                    }
                }else{
                    $mail->addAttachment($attachmentArray);
                }

                $mail->isHTML(true);

                $mail->Subject = 'Escalated Mail from the CRO';
                $mail->Body = '<p>Dear All,</p><p></p><br><br>
                Please, find attached the <b>Call Center Summary for $unit</b> for today.</p><br><br>
                <p>Regards,</p><br><br>
                <p><b>Mobile Trader</b></p>';

                if(!$mail->send()) 
                {
                    $this->messages[] = "Mailer Error: " . $mail->ErrorInfo;
                    return false;
                } 
                else 
                {
                    $this->messages[] = "Message has been sent successfully";
                    return true;
                }

            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
        }//sendMail

        function sendMail2($to, $attachmentArray, $unit){
		
            $host = 'secure.emailsrvr.com';
            $port = 587;
            $user = 'mobiletrader@greatbrandsng.com';
            $usnm = 'Mobiletrader';
            $pwd = 'P@ssword' ;
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
            if($mailer->send($msg, $failures)){
                return true;
            }else print_r($failures);
            echo '<br>concluded<br>';
            return false;
            
        }
        
    }

}catch(Exception $e){
    ob_end_clean(); 
    echo '<b>Error Message: (report.php) </b>'.' '.$e->getMessage().'<br />';
}

ob_end_flush();
?>