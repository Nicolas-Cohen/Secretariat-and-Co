<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupération et sécurisation des données
  $name = htmlspecialchars(trim($_POST['name'] ?? ''));
  $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
  $email = htmlspecialchars(trim($_POST['email'] ?? ''));
  $message = nl2br(htmlspecialchars(trim($_POST['message'] ?? '')));

  // Vérification des champs requis
  if (empty($name) || empty($phone) || empty($email) || empty($message)) {
    echo "<div style='color: red;'>Tous les champs sont requis.</div>";
    exit;
  }

  // Validation email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<div style='color: red;'>Adresse email invalide.</div>";
    exit;
  }

  // Infos de destination
  $to = "nc.cohen@yahoo.com";
  $subjectRecipient = "Nouveau message via secretariat-co.fr";

  // Entêtes de l'email
  $headers = "From: no-reply@secretariat-co.fr\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

  // Contenu HTML du mail
  $body = "<html><body>";
  $body .= "<div align='center' style='font-family: Arial, sans-serif;'>";
  $body .= "<table width='600' style='border-collapse: collapse; text-align: left;'>";
  $body .= "<tr><td align='center' style='padding-bottom: 15px;'><img src='https://www.secretariat-co.fr/assets/img/logo-removed.webp' alt='Secretariat and Co' style='max-width: 150px;'></td></tr>";
  $body .= "<tr><td align='center' style='padding-bottom: 15px;'><h2 style='margin: 0; padding-bottom: 10px;'>Nouveau message reçu</h2></td></tr>";
  $body .= "<tr><td style='padding: 5px 0;'><strong>Nom:</strong> $name</td></tr>";
  $body .= "<tr><td style='padding: 5px 0;'><strong>Email:</strong> $email</td></tr>";
  $body .= "<tr><td style='padding: 5px 0;'><strong>Message:</strong><br>$message</td></tr>";
  $body .= "<tr><td align='center' style='padding-top: 15px; font-size: small; color: gray;'>
             <em>Ce message a été généré automatiquement via le formulaire de contact de secretariat-co.fr<br>
             Merci de ne pas répondre à cet email.</em></td></tr>";
  $body .= "</table></div>";
  $body .= "</body></html>";

  $body = html_entity_decode($body, ENT_QUOTES, 'UTF-8');

  // Envoi de l'email
  if (mail($to, $subjectRecipient, $body, $headers)) {
    echo "<div style='color: green;'>Votre message a été envoyé avec succès. Merci !</div>";
  } else {
    echo "<div style='color: red;'>Erreur lors de l'envoi du message. Veuillez réessayer.</div>";
  }
} else {
  echo "<div style='color: red;'>Requête invalide.</div>";
}
