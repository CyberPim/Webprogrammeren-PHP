<?php 

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'D:\Xampp\htdocs\Composer\vendor\phpmailer\phpmailer\src\Exception.php';
require 'D:\Xampp\htdocs\Composer\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'D:\Xampp\htdocs\Composer\vendor\phpmailer\phpmailer\src\SMTP.php';

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

require_once "config.php";

$email_err = "";


try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'pimdegroot01@gmail.com';                     // SMTP username
    $mail->Password   = 'Ppampet2001';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('servicedesk@example.com', 'Mailer');
    //$mail->addAddress('pimdegroot01@gmail.com');     // Add a recipient

    $body = '<p><strong>Hello</strong> this is my first email using phpmailer</p>';

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Test email';
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email address";     
    } else{
        $mail->addAddress(trim($_POST["email"]));
    }
    $mail->send();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Contact us</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="email">
                    <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Send">
            </div>
        </form>
    </div>    
</body>
</html>