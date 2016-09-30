<?php

namespace Core;

class Mailer
{
    protected $content;
    protected $headers;

    public function __construct($fromName, $fromEmail)
    {
        $this->headers  = 'MIME-Version: 1.0' . PHP_EOL;
        $this->headers .= 'Content-type: "text/html"; charset="utf-8"' . PHP_EOL;
        $this->headers .= 'From: "' . $fromName . '" <' . $fromEmail . '>' . PHP_EOL;
    }
    
    public function loadContent($html)
    {
        $this->content = $html;
    }

    public function sendMail($to, $subject)
    {
        return mail($to, $subject, $this->content, $this->headers);
    }
}
