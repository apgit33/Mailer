<?php
require dirname(__FILE__) . DIRECTORY_SEPARATOR . "vendor/autoload.php";

use App\Mail;


    $mail = new Mail();

    $mail->setSender("admin@admid.fr");
    // $mail->addRecipient(['test@test.fr','admi@test.fr','tddest@test.fr']);
    // $mail->deleteRecipient('admi@test.fr');

    // $mail->addCc(['aa@test.fr','aaa@test.fr']);
    // $mail->addBcc(['bb@test.fr','bbb@testsqsq.fr']);
    $mail->add('recipients', 'test@test.fr');
    $mail->setSubject('test_mail');
    $mail->setBody('<h1>Title</h1>');
    $mail->setType('html');
    // $mail->addAttachment(['html.txt','html_copy.txt']);

    print_r($mail->send());
