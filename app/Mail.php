<?php

namespace App;

use Exception;
use InvalidArgumentException;

use function PHPUnit\Framework\throwException;

/**
 * Mail class
 * @author Adrien <email@email.com>
 */
class Mail
{
    /**
     * Mail sender
     *
     * @var string
     */
    protected $sender;

    /**
     * Mail recipients
     *
     * @var array
     */
    protected $recipients = [];

    /**
     * Mail subject
     *
     * @var string
     */
    protected $subject;

    /**
     * Mail body
     *
     * @var string
     */
    protected $body;

    /**
     * Mail headers
     *
     * @var string
     */
    protected $headers;

    /**
     * Mail cc
     *
     * @var array
     */
    protected $cc = [];

    /**
     * Mail bcc
     *
     * @var array
     */
    protected $bcc = [];

    /**
     * Mail type
     *
     * @var string
     */
    protected $type = "html";

    /**
     * Mail boundary
     *
     * @var string
     */
    protected $boundary;

    /**
     * Mail attachments
     *
     * @var array
     */
    protected $attchment = [];

    public function __construct()
    {
        $this->boundary = md5(uniqid(microtime(), true));
    }

    /**
     * Set mail sender
     *
     * @param string $sender
     * @return void
     */
    public function setSender(string $sender): void
    {
        $this->validateEmail($sender);

        $this->sender = strip_tags($sender);
    }

    /**
     * Add function
     *
     * @param string $param - must be recipients,bcc or cc
     * @param string|array $data - email(s) to add
     * @return void
     */
    public function add($param, $data): void
    {
        if (!in_array($param, ['recipients', 'bcc', 'cc'])) throw new InvalidArgumentException($param . " must be recipients, bcc or cc");

        $this->validateEmail($data);

        if (is_array($data)) {
            $this->{$param} = array_merge($this->{$param}, $data);
        } else {
            $this->{$param}[] = strip_tags($data);
        }
    }

    /**
     * Set mail subject
     *
     * @param string $subject
     * @return void
     */
    public function setSubject(string $subject): void
    {
        $this->subject = strip_tags($subject);
    }

    /**
     * Set mail body
     *
     * @param string $body
     * @return void
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * Set mail type
     *
     * @param string $type
     * @return void
     */
    public function setType(string $type): void
    {
        if ($type == "text" || $type == "html") {
            $this->type = $type;
        }
    }

    /**
     * Set mail headers
     *
     * @return void
     */
    private function setHeaders(): void
    {
        $this->headers = "";
        $this->headers .= "From: " . $this->sender . "\r\n";
        $this->headers .= "MIME-Version: 1.0\r\n";
        $this->headers .= "Content-Type: multipart/mixed; ";
        $this->headers .= "boundary=\"" . $this->boundary . "\"\r\n";
    }

    /**
     * Check mandatory parameters and set
     * sender,recipients
     *
     * @return void
     */
    private function checkParams(): void
    {
        $errors = [];
        $params = [
            'sender' => $this->sender,
            'recipients' => $this->recipients,
        ];

        foreach ($params as $key => $value) {
            if (empty($value)) $errors[] = $key . " can't be null";
        }

        if (!empty($errors)) {
            throw new \InvalidArgumentException(implode(" - \n", $errors));
        }

        $this->setHeaders();

        $this->body = $this->formatBody();
    }

    /**
     * Validates email address
     * 
     * @param string|array $email - email to validate
     * @return void
     */
    private function validateEmail($email): void
    {
        if (is_array($email)) {
            foreach ($email as $mail) {
                if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    throw new \InvalidArgumentException($mail . " must be a valid email");
                }
            }
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException($email . " must be a valid email");
            }
        }
    }

    /**
     * Add mail attachment
     * 
     * TODO : better check/exceptions
     *
     * @param string|array $file - pathname of the file(s) to add
     * @return void
     */
    public function addAttachment($file): void
    {
        if (is_array($file)) {
            foreach ($file as $f) {
                $content = @file_get_contents($f);

                if ($content === FALSE) throw new Exception($f . " doesn't exist");

                $content = chunk_split(base64_encode($content));

                $this->attchment[] = [$f => $content];
            }
        } else {
            $content = @file_get_contents($file);

            if ($content === FALSE) throw new Exception($file . " doesn't exist");

            $content = chunk_split(base64_encode($content));

            $this->attchment[] = [$file => $content];
        }
    }

    /**
     * Format mail body
     *
     * @return string - Mail message formated
     */
    private function formatBody(): string
    {
        $message  = "";
        $message .= "--" . $this->boundary . "\r\n";
        $message .= "Content-Type: text/" . $this->type . "; ";
        $message .= "charset=iso-8859-1\r\n ";
        $message .= "Content-Transfer-Encoding: 8bit\r\n";
        $message .= "\r\n";
        $message .= $this->body . "\r\n";
        $message .= "\r\n";

        foreach ($this->attchment as $attchments) {
            foreach ($attchments as $key => $value) {
                $message .= "--" . $this->boundary . "\r\n";
                $message .= "Content-Type: application/octet-stream; ";
                $message .= "name=\"" . $key . "\"\r\n";
                $message .= "Content-Transfer-Encoding: base64\r\n";
                $message .= "Content-Disposition: attachment; ";
                $message .= "filename=\"" . $key . "\"\r\n";
                $message .= "\r\n";
                $message .= $value . "\r\n";
                $message .= "\r\n";
            }
        }

        return $message .= "--" . $this->boundary . "--\r\n";
    }

    /**
     * Send mail
     *
     * TODO : exceptions attachments size, ...
     * 
     * @return boolean
     */
    public function send(): bool
    {
        $this->checkParams();

        if (!mail(implode(',', $this->recipients), $this->subject, $this->body, $this->headers)) {
            throw new \InvalidArgumentException("Problem while sending the mail");
        }

        return true;
    }
}
