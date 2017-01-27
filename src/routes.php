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

	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
	  ->setUsername($username)
	  ->setPassword($password)
	  ;

	$mailer = Swift_Mailer::newInstance($transport);

	$mailer->send($message);

   return $response->withRedirect('/');
});
