<?php

namespace Core;

class Mailer
{
    protected $content;
    protected $headers;

    public function __construct($fromName, $fromEmail)
    {
        $endOfLine = "\n";
        $boundary = "-----=".md5(rand());

        $this->headers = "From: \"".$fromName."\"<".$fromEmail.">".$endOfLine;
        $this->headers .= "MIME-Version: 1.0".$endOfLine;
        $this->headers .= "Content-Type: text/html;".$endOfLine." boundary=\"$boundary\"".$endOfLine;
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
