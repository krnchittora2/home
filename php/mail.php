<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

include 'functions.php';

if (!empty($_POST)){

  $data['success'] = true;
  $_POST  = multiDimensionalArrayMap('cleanEvilTags', $_POST);
  $_POST  = multiDimensionalArrayMap('cleanData', $_POST);

  $name = $_POST["name"];
  $email = $_POST["email"];
  $comment = $_POST["comment"];
  $message = "NAME: $name<br>EMAIL: $email<br>COMMENT: $comment";

  if($name == "")
   $data['success'] = false;
 
  if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) 
	$data['success'] = false;

  if($comment == "")
	$data['success'] = false;

  if($data['success'] == true){
	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
	    $mail->isSMTP();                                            // Send using SMTP
        $mail->Mailer = "smtp";
	    $mail->Host       = 'smtp.gmail.com';                // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = 'shyingshameless@gmail.com';                        // SMTP username
	    $mail->Password   = 'Desikalakar';                       // SMTP password
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	    //Recipients
	    $mail->setFrom('admin@sociohacker.cf', 'SocioHacker Admin');
	    $mail->addAddress('shyingshameless@gmail.com');       // Add a recipient
	    $mail->addReplyTo('no-reply@sociohacker.cf', 'No Reply');

	    // Content
	    $mail->isHTML(true);                                        // Set email format to HTML
	    $mail->Subject = 'New Comment on the website';
	    $mail->Body    = $message;

	    $mail->send();
	    $data['success'] = true;
		echo json_encode($data);
	} catch (Exception $e) {
	    echo "Message could not be sent.";
	}
	
  }
}

