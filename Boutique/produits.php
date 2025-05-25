<?php
require 'db.php';

// récupération des produits depuis la base
$stmt = $pdo->query("SELECT * FROM produits ORDER BY id ASC");
$produits = $stmt->fetchAll();

include 'header.php';  // inclure le header
?>

<h2 class="mb-4 text-center" style="color:#b30059;">Nos Derniers Produits</h2>

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
</div>

<?php include 'footer.php';  ?>
