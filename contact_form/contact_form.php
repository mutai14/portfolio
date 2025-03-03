<?php

// configure
$from = 'your-email@yourdomain.com'; // Replace with your valid email address
$sendTo = 'gabe.mutai@gmail.com'; // Replace with your personal email
$subject = 'New message from contact form';
$fields = array('name' => 'Name', 'email' => 'Email', 'subject' => 'Subject', 'message' => 'Message'); 

$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

// let's do the sending
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $emailText = "You have a new message from the Contact Form:\n\n";

        foreach ($_POST as $key => $value) {
            if (isset($fields[$key])) {
                $emailText .= "$fields[$key]: $value\n";
            }
        }

        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: " . $_POST['email'] . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($sendTo, $subject, $emailText, $headers)) {
            $responseArray = array('type' => 'success', 'message' => $okMessage);
        } else {
            $responseArray = array('type' => 'danger', 'message' => $errorMessage);
        }
    } catch (Exception $e) {
        $responseArray = array('type' => 'danger', 'message' => $errorMessage);
    }

    header('Content-Type: application/json');
    echo json_encode($responseArray);
}
?>
