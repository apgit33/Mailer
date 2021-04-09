<?php declare(strict_types=1);

namespace Tests;

use App\Mail;
use PHPUnit\Framework\TestCase;

final class MailTest extends TestCase
{
    //recipients
    public function testAddRecipientStringEmailValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('recipients','user@example.fr'));
    }    
    
    public function testAddRecipientStringEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('recipients','user@examp');
    }

    public function testAddRecipientArrayEmailValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('recipients',['user@example.com','secondemail@example.fr']));
    }    
    
    public function testAddRecipientArrayEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('recipients',['user@examp','second%email']);
    }

    //cc
    public function testAddCcStringEmailValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('cc','user@example.fr'));
    }    
    
    public function testAddCcStringEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('cc','user@examp');
    }

    public function testAddCcArrayEmailValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('cc',['user@example.com','secondemail@example.fr']));
    }    
    
    public function testAddCcArrayEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('cc',['user@examp','second%email']);
    }

    //bcc
    public function testAddBccStringEmailValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('bcc','user@example.fr'));
    }    
    
    public function testAddBccStringEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('bcc','user@examp');
    }

    public function testAddBccArrayEmailValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('bcc',['user@example.com','secondemail@example.fr']));
    }    
    
    public function testAddBccArrayEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('bcc',['user@examp','second%email']);
    }

    //invalid arg
    public function testAddInvalidStringEmailValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('invalid','user@example.fr');
    }    
    
    public function testAddInvalidStringEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('invalid','user@example');
    }

    public function testAddInvalidArrayEmailValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('invalid',['user@example.com','secondemail@example.fr']);
    }    
    
    public function testAddInvalidArrayEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('invalid',['user@examp','second%email']);
    }

    //attachment
    public function testAddAttachmentStringFileExist(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->addAttachment('./upload/html.txt'));
    }

    public function testAddAttachmentArrayFileExist(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->addAttachment(['./upload/html.txt','./upload/html_copy.txt']));
    }

    public function testAddAttachmentStringFileNotExist(): void
    {
        $mail = new Mail();

        $this->expectException('Exception');

        $mail->addAttachment('invalid.txt');
    }

    public function testAddAttachmentArrayFileNotExist(): void
    {
        $mail = new Mail();

        $this->expectException('Exception');

        $mail->addAttachment(['invalid.txt','invalid2.txt']);
    }
    
    //send
    public function testSendInvalidParams(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->send();
    }

    public function testSendValidParamsWithoutAttachment(): void
    {
        $mail = new Mail();
        $mail->setSender('test@test.fr');
        $mail->add('recipients','rec@rec.fr');
        $mail->setBody('Hello');

        $this->assertTrue($mail->send());
    }

    public function testSendValidParamsWithAttachment(): void
    {
        $mail = new Mail();
        $mail->setSender('test@test.fr');
        $mail->add('recipients','rec@rec.fr');
        $mail->setBody('Hello');
        $mail->addAttachment('./upload/html.txt');

        $this->assertTrue($mail->send());
    }

}