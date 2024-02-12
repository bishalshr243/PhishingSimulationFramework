<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
 error_reporting(0);
 include('session.php');
include_once 'config.php';
?>
<html>
   <head>
      <title>Welcome Employee</title>
	<img src="header.jpg" style="width:100%;height:150px;">
	<style>
.selectBox{
  border-radius:4px;border:1px solid #AAAAAA;background: none repeat scroll 0 0 #FFFFFF;
  background-color:  #e0e0eb; height: 23px;
}
  .navbar a:hover {
  background: #ddd;
  color: black;
}
.navbar a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}
.navbar {
  overflow: hidden;
  background-color: #333;
  top: 0;
  width: 100%;
}
	</style>
   </head>
   <body> 
     <div class="navbar">
  <a href="setup.php">Setup Test Enviornment</a>
  <a href="analysis.php">Analysis</a>
  <a href="invite.php">Invite</a>
  <a href = "logout.php">Sign Out</a>
	 
	</div> 
	
	<?php
	$server= strval($_POST['server']);
	$username= strval($_POST['username']);
	$password= strval($_POST['password']);
	$mailbody = strval($_POST['mailbody']);
	$mail = new PHPMailer(true);
try {
    
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                           
    $mail->Host       = $server;                    
    $mail->SMTPAuth   = true;                                 
    $mail->Username   = $username;                     
    $mail->Password   = $password;                          
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
    $mail->Port       = 587;                                    

    
    $mail->setFrom($username, 'Mailer');
	
	 $query = "SELECT distinct * FROM invite";
	$result1 = mysqli_query($db, $query);
	if(mysqli_num_rows($result1) > 0){
	
	while ($row = mysqli_fetch_array($result1))
	{
		$mail->addAddress($row[1], $row[0]); 
	
	}
	mysqli_free_result($result1);
	}
 
    $mail->isHTML(true);                                 
    $mail->Subject = 'Invite!';
    $mail->Body    = $mailbody;
    $mail->AltBody = $mailbody;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
	?>