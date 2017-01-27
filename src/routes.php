<?php
// Routes

$app->get('/', function ($request, $response, $args) {

    return $this->renderer->render($response, 'index.phtml');
});

$app->post('/send', function ($request, $response, $args) {

$services = [
	'gmail.com' => [
		'host' => 'smtp.gmail.com',
		'port' => 465,
		'encrypt' => 'ssl'
	],
	'yandex.ru' => [
		'host' => 'smtp.yandex.ru',
		'port' => 465,
		'encrypt' => 'ssl'
	],
	'mail.ru' => [
		'host' => 'smtp.mail.ru',
		'port' => 465,
		'encrypt' => 'ssl'
	]
];

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

$service = $services[explode('@', $username)[1]];

	$transport = Swift_SmtpTransport::newInstance()
	  ->setHost($service['host'])
	  ->setPort($service['port'])
	  ->setEncryption($service['encrypt'])
	  ->setUsername($username)
	  ->setPassword($password);
	$mailer = Swift_Mailer::newInstance($transport);

	$mailer->send($message);


   return $response->withRedirect('/');
});
