Author - Damon Duffy 34144772

## 1\. Launch an EC2 Instance

Creating the EC2 instance to host the web server on.

\- Go to AWS EC2 Dashboard.

\- Click Launch Instance and configure:

\- OS: Ubuntu Server

\- Instance Type: \`t3.micro\` (free tier eligible)

\- Key Pair: Create or select one

\- Security Group\* Allow SSH (22), HTTP (80), HTTPS (443)

\- Launch the instance.

## 2\. Set Up a Static IP

Renting and allocating the Static IP to allow users, and the DNS, to have a single IP to use.

\- Go to Elastic IPs in AWS.

\- Click Allocate Elastic IP.

\- Associate it with your EC2 instance.

## 3\. Connect to EC2

Connecting to the web server, updating and installing current necessary packages.

Use EC2 Instance Connect in the AWS console

sudo apt update && sudo apt upgrade

sudo apt install ssh apache2

## 4\. Domain Configuration (GoDaddy)

Purchasing a domain name and associating it with the static IP.

- Purchase a domain on GoDaddy.
- Go to DNS Management and add an A record:
  - Host: @
  - Points to: your EC2 static IP

## 5\. UFW Firewall Setup

Setting up the Firewall on the web server to protect the server from unauthorized access.

sudo ufw allow ssh

sudo ufw allow http

sudo ufw allow https

sudo ufw enable

## 6\. Install SSL with Certbot

Using cerbot to get a certificate and encrypt the website to ensure safety of data on website.

sudo snap install core

sudo snap refresh core

sudo snap install --classic certbot

sudo certbot --apache

sudo certbot renew --dry-run

## 7\. Build the Website

cd /var/www/html

sudo nano index.html #Repeat for about.html, inquiry.html, booking.html

sudo nano style.css

Example HTML snippet for navigation:

&lt;nav&gt;

&lt;a href="index.html"&gt;Home&lt;/a&gt; |

&lt;a href="about.html"&gt;About&lt;/a&gt; |

&lt;a href="booking.html"&gt;Booking&lt;/a&gt; |

&lt;a href="inquiry.html"&gt;Inquiry&lt;/a&gt;

&lt;/nav&gt;

## 8\. Install PHP and Sendmail

Install PHP on the web server and Sendmail to prepare for the inquiry script that allows customers to send inquiries to the website’s email address.

sudo apt install php libapache2-mod-php

sudo systemctl restart apache2

sudo apt install sendmail

## 9\. Contact Form Setup

The form setup that allows users to send inquiries.

HTML Form (inquiry.html)

&lt;form action="send.php" method="post"&gt;

&lt;label&gt;Name:&lt;/label&gt;&lt;br&gt;

&lt;input type="text" name="name" required&gt;&lt;br&gt;

&lt;label&gt;Email:&lt;/label&gt;&lt;br&gt;

&lt;input type="email" name="email" required&gt;&lt;br&gt;

&lt;label&gt;Message:&lt;/label&gt;&lt;br&gt;

&lt;textarea name="message" required&gt;&lt;/textarea&gt;&lt;br&gt;

&lt;input type="submit" value="Send"&gt;

&lt;/form&gt;

## 10\. PHP Script (send.php)

The PHP script that allows user input into the inquiry form.

<?php

// Check if the form was submitted using the POST method

if ($\_SERVER\["REQUEST_METHOD"\] == "POST") {

// The email address where you want to receive inquiries

$to = "email@example.com"; // <-- Receiving email

// Subject line of the email you will receive

$subject = "New Inquiry from WebifyDubai";

// Get the user's name, email, and message from the POST request

// htmlspecialchars is used to sanitize input to prevent XSS attacks

$name = htmlspecialchars($\_POST\["name"\]);

$email = htmlspecialchars($\_POST\["email"\]);

$message = htmlspecialchars($\_POST\["message"\]);

// Construct the body of the email using the submitted form data

$body = "Name: $name\\nEmail: $email\\nMessage:\\n$message";

// Set the "From" header so it appears to come from the user's email

$headers = "From: $email";

// Use the built-in mail function to send the email

// Returns true if successful, false otherwise

if (mail($to, $subject, $body, $headers)) {

// If the email is sent successfully, show a success message

echo "&lt;h1&gt;Thank you! Your message has been sent.&lt;/h1&gt;";

} else {

// If the mail function fails, show an error message

echo "&lt;h1&gt;Sorry, something went wrong. Please try again later.&lt;/h1&gt;";

}

} else {

// If the page is accessed directly (not via form submission), show an error

echo "&lt;h1&gt;Invalid request&lt;/h1&gt;";

}

?>

## 11\. Script Explanation

The send.php script handles and allows visitors of WebifyDubai to use the form submission. The script allows users to input their name, email and message and click a button to submit. The script will then capture the data using the POST method. After the data has been captured, it uses HTML special chars to sanitize the input to prevent cross-site scripting attacks, and it formats the data into a readable email. The script uses PHP’s mail() function to send the processed data as an email to the specified recipient email address. The script will show the user a successful confirmation or failure message if there is an issue.

