<?php
// Routes

$app->get('/', function ($request, $response, $args) {

    return $this->renderer->render($response, 'index.phtml');
});

$app->post('/send', function ($request, $response, $args) {

	$data = $request->getParsedBody();
    $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($data['password'], FILTER_SANITIZE_STRING);
    $to = filter_var($data['to'], FILTER_SANITIZE_STRING);
    $text = filter_var($data['text'], FILTER_SANITIZE_STRING);

	$message = Swift_Message::newInstance()
	  ->setSubject('[mykyta]')
	  ->setFrom([$username])
	  ->setTo([$to])
	  ->setBody($text)
	  ;
/*
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465)
	  ->setUsername($username)
	  ->setPassword($password)
	  ;
*/
$transport = Swift_SmtpTransport::newInstance()
  ->setHost('smtp.gmail.com')
  ->setPort(465)
  ->setEncryption('ssl')
	  ->setUsername($username)
	  ->setPassword($password);
	$mailer = Swift_Mailer::newInstance($transport);

	$mailer->send($message);

/*
$mail = new PHPMailer;                             // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $username;                 // SMTP username
$mail->Password = $password;                           // SMTP password
$mail->SMTPSecure= "ssl"; 
$mail->Port= 465;                                  // TCP port to connect to

$mail->setFrom($username, 'JoJo');
$mail->addAddress($to);                                 // Set email format to HTML

$mail->Subject = '[mykyta]';
$mail->Body    = $text;


if(!$mail->send()) {
    throw new \Exception('Mailer Error: ' . $mail->ErrorInfo);
} 
*/
   return $response->withRedirect('/');
});
