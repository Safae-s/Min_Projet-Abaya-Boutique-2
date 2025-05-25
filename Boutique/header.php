<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title><?= $pageTitle ?? 'Abayas Boutique' ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">🎀Abayas Boutique🎀</a>
    <div class="d-flex gap-3">
    <a href="index.php" class="nav-link">Acceuil</a>
      <a href="nos.php" class="nav-link">Nos</a>
            <a href="produits.php" class="nav-link">Produit</a>
      <a href="contact.php" class="nav-link">Contact</a>
      <a href="login.php" class="btn btn-outline-danger btn-sm">Admin Login</a>
    </div>
  </div>
</nav>
<div class="container">
