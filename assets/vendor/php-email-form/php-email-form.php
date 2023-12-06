<?php
use PHPMailer\PHPMailer\PHPMailer;

class PHP_Email_Form
{
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $message;
    public $headers;

    // Correct property name: 'ajax' instead of '$ajax'
    public $ajax;

    // Correct property name: 'smtp' instead of '$smtp'
    public $smtp;

    public function __construct()
    {
        $this->to = '';
        $this->from_name = '';
        $this->from_email = '';
        $this->subject = '';
        $this->message = '';
        $this->headers = "MIME-Version: 1.0\r\n";
        $this->headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

        // Initialize 'ajax' property
        $this->ajax = false;

        // Initialize 'smtp' property
        $this->smtp = array();
    }

    public function add_message($content, $label = '')
    {
        $this->message .= "<p><strong>$label:</strong> $content</p>";
    }

    public function send()
    {
        $this->headers .= "From: $this->from_name <$this->from_email>\r\n";

        // If SMTP is configured, use it
        if (!empty($this->smtp)) {
            return $this->send_smtp();
        }

        // Otherwise, use regular mail function
        return mail($this->to, $this->subject, $this->message, $this->headers);
    }

    private function send_smtp()
    {
        // Implement SMTP sending logic here
        // You would need to use an SMTP library or implement your own logic

        // Example using PHPMailer library
        // require 'path/to/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = $this->smtp['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $this->smtp['username'];
        $mail->Password = $this->smtp['password'];
        $mail->Port = $this->smtp['port'];

        // Set other email parameters and send
        $mail->setFrom($this->from_email, $this->from_name);
        $mail->addAddress($this->to);
        $mail->Subject = $this->subject;
        $mail->msgHTML($this->message);

        return $mail->send();

    }
}

?>
