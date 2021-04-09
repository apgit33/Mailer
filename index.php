<?php
require dirname(__FILE__) . DIRECTORY_SEPARATOR . "vendor/autoload.php";

use App\Mail;

$mail = new Mail();

$mail->setSender("admin@admid.fr");
$mail->add('recipients', ['test@test.fr','admin@test.fr','test2@test.fr']);
$mail->add('cc', 'cc@cc.fr');
$mail->add('bcc', 'bcc@bcc.fr');
$mail->setSubject('test_mail');
$mail->setBody('<h1>Title</h1>');
$mail->setType('html');
$mail->addAttachment(['upload/html.txt','upload/html_copy.txt']);

print_r($mail->send());
