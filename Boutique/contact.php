
<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success text-center">Merci! Votre message a été envoyé.</div>
<?php elseif (isset($_GET['error'])): ?>
  <div class="alert alert-danger text-center">Erreur! Veuillez vérifier vos informations et réessayer.</div>
<?php endif; ?>

<?php
require 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Contact - Abayas Boutique</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
        <h1 class="text-center mb-4">Contactez-nous</h1>

  <div class="section-contact mt-4">
    <form action="send_message.php" method="POST">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Adresse email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-custom">Envoyer</button>
      </div>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
