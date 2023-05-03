<?php
session_start();

include_once "includes/functions.php";

try {
    if (isset($_POST['email']) && isset($_POST['message']) && isset($_POST['name'])) {
        $to_email = 'gella27@gmail.com';
        $from_email = $_POST['email'];
        $subject = "Message from my website from {$_POST['name']}";
        $body = wordwrap($_POST['message'], 70);
        $headers = array(
            'Mime-Version' => "1.0",
            'Content-type' => 'text/html; charset=iso-8859-1',
            'From' => "{$from_email}"
        );
    
        $result = mail($to_email, $subject, $body, implode("\r\n", $headers));
        if ($result) {
            setFeedbackAndRedirect("The message was sent. Thank you for contacting.", "success", "index.php");
        } else {
            setFeedbackAndRedirect("An error happened. Please try again later", "error", "index.php#contact");
        }
    }
} catch (Exception $ex) {
    setFeedbackAndRedirect($ex->getMessage(), "error", "create_post.php");
}

