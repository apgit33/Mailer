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

        $this->assertNull($mail->add('invalid','user@example.fr'));
    }    
    
    public function testAddInvalidStringEmailNotValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('invalid','user@examp'));
    }

    public function testAddInvalidArrayEmailValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('invalid',['user@example.com','secondemail@example.fr']));
    }    
    
    public function testAddInvalidArrayEmailNotValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('invalid',['user@examp','second%email']));
    }

    //send
    public function testSendInvalidParams(): void
    {
        $mail = new Mail();

        $this->assertEquals('Mail not send', $mail->send());
    }

    public function testSendValidParams(): void
    {
        $mail = new Mail();
        $mail->setSender('test@test.fr');
        $mail->add('recipients','rec@rec.fr');
        $mail->setBody('Hello');

        $this->assertEquals('Mail send', $mail->send());
        
    }
}