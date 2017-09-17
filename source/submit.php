<?php
  
include 'includes/MailChimp.php';

$captcha = "";
$captchaError = "";

$userName = "";
$nameError = "";

$userEmail = "";
$emailError = "";

if(isset($_POST['g-recaptcha-response'])){

 $captcha=$_POST['g-recaptcha-response'];

}

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

$secret = "PRIVATE_KEY";
$ip = $_SERVER['REMOTE_ADDR'];
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);

if(intval($responseKeys["success"]) !== 1) {

 $responseData["captchaError"] = "<i class='fa fa-times' aria-hidden='true'></i> Please verify that you are human.";

} else {

  $userAgree = $_POST['userAgree'];

  if ($userAgree == "Yes") {

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

echo json_encode($responseData);

?>