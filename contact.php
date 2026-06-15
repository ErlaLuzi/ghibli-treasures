<?php
session_start();
include 'includes/header.php';
?>

<link rel="stylesheet" href="css/contact.css">

<div class="contact-page-wrapper">
    <section class="page-section contact-form-section">
        <h2>Contact Us</h2>
        <p>Have a question or suggestion? Fill out the form below.</p>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);

            $to = "eluzi23@epoka.edu.al"; 
            $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";

            $fullMessage = "From: $name\nEmail: $email\n\nMessage:\n$message";

            if (mail($to, $subject, $fullMessage, $headers)) {
                echo "<p class='success-message'>Thank you, $name! Your message has been sent successfully.</p>";
            } else {
                echo "<p class='error-message'>There was an error sending your message. Please try again later.</p>";
            }
        }
        ?>

        <form class="contact-form" action="contact.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required />
            <input type="email" name="email" placeholder="Your Email" required />
            <input type="text" name="subject" placeholder="Subject" required />
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </section>
</div>

<?php include 'includes/footer.php'; ?>
