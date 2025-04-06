<?php
// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // The email address where you want to receive inquiries
    $to = "damonduffy99@gmail.com"; 

    // Subject line of the email you will receive
    $subject = "New Inquiry from WebifyDubai";

    // Get the user's name, email, and message from the POST request
    // htmlspecialchars is used to sanitize input to prevent XSS attacks
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Construct the body of the email using the submitted form data
    $body = "Name: $name\nEmail: $email\nMessage:\n$message";

    // Set the "From" header so it appears to come from the user's email
    $headers = "From: $email";

    // Use the built-in mail function to send the email
    // Returns true if successful, false otherwise
    if (mail($to, $subject, $body, $headers)) {
        // If the email is sent successfully, show a success message
        echo "<h1>Thank you! Your message has been sent.</h1>";
    } else {
        // If the mail function fails, show an error message
        echo "<h1>Sorry, something went wrong. Please try again later.</h1>";
    }

} else {
    // If the page is accessed directly (not via form submission), show an error
    echo "<h1>Invalid request</h1>";
}
?>
