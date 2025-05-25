<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = strip_tags(trim($_POST["nom"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    if (empty($nom) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?error=1");
        exit;
    }

    $to = "safae8891@gmail.com";
    $subject = "Nouveau message de $nom via Abayas Boutique";

    $email_content = "Nom: $nom\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    $headers = "From: $nom <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($to, $subject, $email_content, $headers)) {
        header("Location: contact.php?success=1");
    } else {
        header("Location: contact.php?error=1");
    }
    exit;
} else {
    header("Location: contact.php");
    exit;
}
?>
