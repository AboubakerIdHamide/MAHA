<?php

namespace App\Libraries;

class Mail
{
	private $mail;

	public function __construct()
	{
		$mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        // Load Environment Variables (.env)
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(dirname(__DIR__)));
        $dotenv->load();

		//Send using SMTP
    	$mail->isSMTP();

		//Set the SMTP server to send through => 'smtp.gmail.com'
		$mail->Host = $_ENV['MAIL_HOST'];

		//Enable SMTP authentication
		$mail->SMTPAuth = true;

		//SMTP username
		$mail->Username = $_ENV['MAIL_USERNAME'];

		//SMTP password
		$mail->Password = $_ENV['MAIL_PASSWORD'];

		//Enable TLS encryption;
		$mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;

		//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
		$mail->Port = $_ENV['MAIL_PORT'];

		//Recipients
		$mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);

		//Set email format to HTML
    	$mail->isHTML(true);

    	$mail->CharSet = "UTF-8";

		$this->mail = $mail;
	}

    public function to($recipientEmail)
    {
    	$this->mail->addAddress($recipientEmail);
    	return $this;
    }

    public function subject($subject)
    {
    	$this->mail->Subject = $subject;
    	return $this;
    }

    public function body($message, $fileName = '', $search = [], $replace = [])
    {
    	if(!$fileName){
    		$this->mail->Body = $message;
    	}else{
    		$this->mail->Body = $this->getMailFile($fileName, $search, $replace);
    	}

    	return $this;
    }

    public function attach($files)
    {
    	// e.g: ['images/logo.png' => 'logo']
    	$publicFolder = dirname(dirname(__DIR__)).'/public/';

    	foreach ($files as $name => $src) {
    		$this->mail->addEmbeddedImage($publicFolder.$name, $src);
    	}
    	
    	return $this;
    }

    public function send()
    {
    	// send it
    	$this->mail->send();
    }

    public function getMailFile($fileName, $search, $replace)
    {
    	$fileContent = file_get_contents("../App/views/emails/".$fileName);

    	if(!$search || !$replace){
    		return $fileContent;
    	}

        return str_replace(
            array_values($search),
            array_values($replace),
            $fileContent
        );
    }
}
