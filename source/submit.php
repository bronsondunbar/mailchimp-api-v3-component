<?php
  
include 'includes/MailChimp.php';

/* Declare variables */

$captcha = "";
$captchaError = "";

$userName = "";
$nameError = "";

$userEmail = "";
$emailError = "";

/* Check if the Google reCAPTCHA has been set */

if(isset($_POST['g-recaptcha-response'])){

 $captcha=$_POST['g-recaptcha-response'];

}

/* Check and make sure all form fields have data and populate response object with appropriate messages */

if (empty($_POST['name'])) {

 $responseData["nameError"] = "<i class='fa fa-times' aria-hidden='true'></i> Please type your name.";

} else {

 $userName = trim($_POST['name']);
 $userName = ucwords($userName);

}

if (empty($_POST['email'])) {

 $responseData["emailError"] = "<i class='fa fa-times' aria-hidden='true'></i> Please type your email.";

} else {

 $userEmail = trim($_POST['email']);

}

/* Set Google reCAPTCHA settings here */

$secret = "PRIVATE_KEY";
$ip = $_SERVER['REMOTE_ADDR'];
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);

/* Only if Google reCAPTCHA returns success move on to MailChimp API */

if(intval($responseKeys["success"]) !== 1) {

 $responseData["captchaError"] = "<i class='fa fa-times' aria-hidden='true'></i> Please verify that you are human.";

} else {

  /* Check to see if user agrees to join mailing list */

  $userAgree = $_POST['userAgree'];

  if ($userAgree == "Yes") {

    /* Set MailChimp API details here */

    $MailChimp = new MailChimp('MAILCHIMP_API');
    $list_id = 'LIST_ID';

    $result = $MailChimp->post("lists/$list_id/members", [
      'email_address' => $userEmail,
      'status'        => 'subscribed',
      'merge_fields'  => [
        'NAME'     => $userName
      ]
    ]);

    if ($MailChimp->success()) {

      $responseData["mailChimpMessage"] = "<i class='fa fa-check' aria-hidden='true'></i> You are subscribed!";

    } else {

      $responseData["mailChimpMessage"] = "<i class='fa fa-times' aria-hidden='true'></i>" . $MailChimp->getLastError();

    }

  } else {

    $responseData["agreeError"] = "<i class='fa fa-times' aria-hidden='true'></i> Please check the box above.";

  }

}

/* Return all responses gathered */

echo json_encode($responseData);

?>