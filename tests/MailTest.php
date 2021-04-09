<?php declare(strict_types=1);

namespace Tests;

use App\Mail;
use PHPUnit\Framework\TestCase;

/**
 * MailTest class
 * 
 * Project found at : https://github.com/apgit33/mailer
 * Package use : 
 *      composer require "apgit33/mailer @dev"
 * 
 * @author Adrien <email@email.com>
 */

final class MailTest extends TestCase
{
    /**
     * Test all valid string additions 
     *
     * @return void
     */
    public function testAddStringEmailValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('recipients','user@example.fr'));
        $this->assertNull($mail->add('cc','user@example.fr'));
        $this->assertNull($mail->add('bcc','user@example.fr'));
        $this->assertNull($mail->addAttachment('./upload/html.txt'));
    }    
    
    /**
     * Test all valid array additions 
     *
     * @return void
     */
    public function testAddArrayEmailValid(): void
    {
        $mail = new Mail();

        $this->assertNull($mail->add('recipients',['user@example.com','secondemail@example.fr']));
        $this->assertNull($mail->add('cc',['user@example.com','secondemail@example.fr']));
        $this->assertNull($mail->add('bcc',['user@example.com','secondemail@example.fr']));
        $this->assertNull($mail->addAttachment(['./upload/html.txt','./upload/html_copy.txt']));
    } 

    /**
     * Test invalid string recipient
     *
     * @return void
     */
    public function testAddRecipientStringEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('recipients','user@examp');
    }

    /**
     * Test invalid array recipient
     *
     * @return void
     */
    public function testAddRecipientArrayEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('recipients',['user@examp','second%email']);
    }

    /**
     * Test invalid string cc
     *
     * @return void
     */
    public function testAddCcStringEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('cc','user@examp');
    }

    /**
     * Test invalid array cc
     *
     * @return void
     */
    public function testAddCcArrayEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('cc',['user@examp','second%email']);
    }

    /**
     * Test invalid string bcc
     *
     * @return void
     */
    public function testAddBccStringEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('bcc','user@examp');
    }

    /**
     * Test invalid array bcc
     *
     * @return void
     */
    public function testAddBccArrayEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('bcc',['user@examp','second%email']);
    }

    /**
     * Test invalid additional parameters with valid string email
     * 
     * @return void
     */
    public function testAddInvalidStringEmailValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('invalid','user@example.fr');
    }    

    /**
     * Test invalid additional parameters with invalid string email
     * 
     * @return void
     */ 
    public function testAddInvalidStringEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('invalid','user@example');
    }

    /**
     * Test invalid additional parameters with valid array email
     * 
     * @return void
     */ 
    public function testAddInvalidArrayEmailValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('invalid',['user@example.com','secondemail@example.fr']);
    }    

    /**
     * Test invalid additional parameters with invalid array email
     * 
     * @return void
     */ 
    public function testAddInvalidArrayEmailNotValid(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->add('invalid',['user@examp','second%email']);
    }

    /**
     * Test invalid string attchment file
     * 
     * @return void
     */ 
    public function testAddAttachmentStringFileNotExist(): void
    {
        $mail = new Mail();

        $this->expectException('Exception');

        $mail->addAttachment('invalid.txt');
    }

    /**
     * Test invalid array attchments files
     * 
     * @return void
     */ 
    public function testAddAttachmentArrayFileNotExist(): void
    {
        $mail = new Mail();

        $this->expectException('Exception');

        $mail->addAttachment(['invalid.txt','invalid2.txt']);
    }
    
    /**
     * Test invalid parameters send
     * 
     * @return void
     */ 
    public function testSendInvalidParams(): void
    {
        $mail = new Mail();

        $this->expectException('InvalidArgumentException');

        $mail->send();
    }

    /**
     * Test valid parameters send without attachment
     * 
     * @return void
     */ 
    public function testSendValidParamsWithoutAttachment(): void
    {
        ini_set('smtp_port', "1025"); // for mailhog

        $mail = new Mail();

        $mail->setSender('test@test.fr');
        $mail->add('recipients','rec@rec.fr');
        $mail->setBody('Hello');

        $this->assertTrue($mail->send());
    }

    /**
     * Test valid parameters send with attachment
     * 
     * @return void
     */ 
    public function testSendValidParamsWithAttachment(): void
    {
        ini_set('smtp_port', "1025"); // for mailhog

        $mail = new Mail();

        $mail->setSender('test@test.fr');
        $mail->add('recipients','rec@rec.fr');
        $mail->setBody('Hello');
        $mail->addAttachment('./upload/html.txt');

        $this->assertTrue($mail->send());
    }

}