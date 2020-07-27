include  __DIR__ . "/../library/swiftmailer/lib/swift_required.php";

public function sendSuccessMailUser($obj,$emailer_str)
	{
		
		$transport = Swift_SmtpTransport::newInstance($host,$port,$smtpsecure)->setUsername($username)->setPassword($password);
	

		$mailer = Swift_Mailer::newInstance($transport);
		$message = $emailer_str['message']->setFrom(array('noreply@tripr.com' => 'Tripr'))
						->setTo(array($email))
						->setBody($emailer_str['html'], "text/html"); // . $code

		
		return $mailer->send($message);
		
	}