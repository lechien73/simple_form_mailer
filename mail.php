<?php

/* Shever's Form Mailer 1.2
   Matt Rudge, 201 to 2017
   See README.md for instructions.
*/

if (isset($_POST['error_page'])) {
    $error_page = $_POST['error_page'];
} else {
    $error_page = "./error.html";
}

if (isset($_POST["g-recaptcha-response"])) {

    $reCaptcha_version = 1;

    require_once "";                    // Path to Composer autoload.php, recaptchalib.php or custom autoload.php

    $secret = "";                       // Insert your ReCaptaha secret here
 
    $response = null;

    if ($reCaptcha_version == 1) {
 
        $reCaptcha = new ReCaptcha($secret); 

        $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$_POST["g-recaptcha-response"]);
    
	   if ($response != null && $response->success) {} else {
		  header('Location: '.$error_page);
		  exit;
	   }
    } else {
        $recaptcha = new \ReCaptcha\ReCaptcha($secret);

        $response = $recaptcha->verify($_POST["g-recaptcha-response"], $_SERVER["REMOTE_ADDR"]);

        if ($response->isSuccess()) {} else {
           header('Location: '.$error_page);
           exit; 
        }
    }
}

$recipient = "";                        // Put the destination email address here if you don't want to supply it as a hidden form field

if (isset($_POST['recipient'])) {
    $recipient = $_POST['recipient'];
}

$reserved_names = array('subject', 'recipient', 'success_page', 'error_page', 'g-recaptcha-response');

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$success_page = $_POST['success_page'];
$ip_address = $_SERVER['REMOTE_ADDR'];


foreach ($_POST as $mailer_name => $mailer_value) {

    if (!in_array($mailer_name, $reserved_names)) {
        $formcontent .= "$mailer_name:  $mailer_value \n";
    }

}

$formcontent .= "\nMail sent from IP Address: $ip_address. \n";

$mailheader = "From: $name <$email> \r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("An error occurred, your mail could not be sent");

header('Location: '.$success_page);
exit;
?>