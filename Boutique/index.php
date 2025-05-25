<?php
require 'db.php';


$stmt = $pdo->query("SELECT * FROM produits ORDER BY id ASC LIMIT 40");
$produits = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Accueil - Abayas Boutique</title>
   <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="style.css">-->
</head>
<body>
  
<?php include 'header.php'; ?>



<div class="container">



<h1 class="titre" >
  🎀ABAYA Boutique🎀
</h1>

<div class="video-container">
  <video autoplay muted loop playsinline>
    <source src="upload/video.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>
  
  <div class="overlay-texte">
    <h2>Découvrez notre collection 2025</h2>
    <p>Des abayas élégantes et modernes, conçues pour vous accompagner avec style.</p>
    <a href="produits.php" class="btn btn-outline-primary">Voir plus</a>
  </div>
</div>



   <!--PAGE DE NOS-->
   
  <div class="container">
        <br><br><h1 class="text-center mb-4">🎀À propos de nous🎀</h1>

      <div class="section-nos mt-4">
    <p>
      Bienvenue chez <strong>Abayas Boutique</strong>, votre destination de confiance pour des abayas élégantes, modernes et confortables. Nous proposons une collection soigneusement sélectionnée pour répondre à vos besoins et refléter votre style unique.
    </p>
    <p>
      Notre mission est de vous offrir des produits de qualité à des prix abordables. Nous croyons en la beauté et la simplicité, c’est pourquoi chaque abaya est conçue avec soin et amour.
    </p>
    <p>
      Merci de nous faire confiance. N’hésitez pas à nous contacter pour toute question ou suggestion.
    </p>
  </div>

  <!-- Derniers produits -->
 <br><br> <h2 class="mb-4 text-center" style="color:#b30059;">🎀Nos Derniers Produits🎀</h2>

<div class="row">
  <?php foreach ($produits as $p): ?>
    <div class="col-md-4 mb-4">
      <div class="card produit-card h-100">
        <?php if ($p['image']): ?>
          <img src="<?= htmlspecialchars($p['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['titre']) ?>">
        <?php else: ?>
          <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Pas d'image" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#ffd6e8"></rect><text x="50%" y="50%" fill="#b30059" dy=".3em" text-anchor="middle">Pas d'image</text></svg>
        <?php endif; ?>
        <div class="card-body d-flex flex-column">
          <h5 class="card-title"><?= htmlspecialchars($p['titre']) ?></h5>
          <p class="card-text flex-grow-1"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
          <h6 class="text-primary"><?= number_format($p['prix'], 2) ?> Dh</h6>
          <a href="produit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primaryy mt-3">Voir détails</a>
        
        </div>
      </div>
    </div>
  <?php endforeach; ?>
              <a href="produits.php" class="btn btn-outline-primaryy">Voir plus</a>

</div><br><br>

         
          <!--PAGE CONTACT-->
          <div class="container">
   <br><br> <h1 class="text-center mb-4">🎀Contactez-nous🎀</h1>

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
</div><br><br>


 <!-- Icon Links -->
  <div class="icon-links d-flex justify-content-center gap-5 mb-5">
    <a href="nos.php" title="À propos">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.5-1.8 4.5-4.5S14.7 3 12 3 7.5 4.8 7.5 7.5 9.3 12 12 12zM6 19.5v-1.5c0-2.4 4.8-3.6 6-3.6s6 1.2 6 3.6v1.5H6z"/></svg>
      Nos
    </a>
    <a href="index.php" title="Produits">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 7h-4V5c0-1.1-.9-2-2-2H9C7.9 3 7 3.9 7 5v2H3c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm-9 8c-1.1 0-2-.9-2-2s.9-2 2-2a2 2 0 0 1 2 2c0 1.1-.9 2-2 2z"/></svg>
      Produits
    </a>
    <a href="contact.php" title="Contact">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 2l-8 5-8-5V6l8 5 8-5v2z"/></svg>
      Contact
    </a>
  </div>
</div>
<br><br>
</div>
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
