<?php

include_once (dirname(dirname(__FILE__)) . '/config.php');

//Initial response is NULL
$response = null;

// Initialize appropriate action and return as HTML response
if (isset($_POST["action"]) && $_POST["action"] === "SendMessage") {
    if (
        isset($_POST["your-email"]) && !empty($_POST["your-email"]) &&
        isset($_POST["your-message"]) && !empty($_POST["your-message"]) &&
        isset($_POST["your-subject"]) && !empty($_POST["your-subject"])
    ) {
        $email = $_POST["your-email"];
        $message = $_POST["your-message"];
        $subject = $_POST["your-subject"];

        $response = (SendEmail($message, $subject, $_POST["your-name"], $email, $emailTo)) ? 'Message Sent' : "Sending Message Failed";
    } else {
        $response = "Sending Message Failed";
    }
} else {
    $response = "Invalid action is set!";
}

if (isset($response) && !empty($response) && !is_null($response)) {
    echo '{"ResponseData":' . json_encode($response) . '}';
}

function SendEmail($message, $subject, $name, $from, $to) {
    $isSent = false;
    // Content-type header
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Additional headers
    $headers .= 'From: ' . $name . '<' . $from . '>';

    if (@mail($to, $subject, $message, $headers)) {
        $isSent = true;
    }
    return $isSent;
}
?>