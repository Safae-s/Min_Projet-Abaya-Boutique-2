<?php
require 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch();

if (!$produit) {
    echo '<div class="container my-5">';
    echo '<div class="alert alert-danger text-center">Produit non trouvé. <a href="index.php" class="alert-link">Retour à l\'accueil</a></div>';
    echo '</div>';
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $quantite = (int)($_POST['quantite'] ?? 1);

    if ($nom && filter_var($email, FILTER_VALIDATE_EMAIL) && $adresse && $quantite > 0) {
        $to = 'safae8891@gmail.com';
        $subject = "Commande produit: " . $produit['titre'];
        $body = "Nom: $nom\nEmail: $email\nAdresse: $adresse\nProduit: " . $produit['titre'] . "\nQuantité: $quantite";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            $message = "Commande envoyée avec succès ! Merci.";
        } else {
            $message = "Erreur lors de l'envoi de la commande. Vérifiez la configuration de votre serveur mail.";
        }
    } else {
        $message = "Veuillez remplir correctement tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Détails produit - <?= htmlspecialchars($produit['titre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <script src="js/scripts.js"></script>

    <style>
       
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container my-5">
    <h2 class="mb-4 text-center" style="color:#b30059;"><?= htmlspecialchars($produit['titre']) ?></h2>

    <div class="row">
        <div class="col-md-6">
            <?php if ($produit['image']): ?>
                <img src="<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['titre']) ?>" class="produit-image mb-4">
            <?php else: ?>
                <div style="height:400px; background:#ffd6e8; display:flex; align-items:center; justify-content:center; color:#b30059; border-radius:8px;">
                    Pas d'image disponible
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h4>Description</h4>
            <p><?= nl2br(htmlspecialchars($produit['description'])) ?></p>

            <h4>Prix:</h4>
            <h5 class="text-primary"><?= number_format($produit['prix'], 2) ?> Dh</h5>

            <button class="btn btn-commander mt-4" id="btnCommander">Commander</button>

            <?php if ($message): ?>
                <div class="alert alert-info mt-3"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form id="formCommande" class="commande-form" method="POST" action="">
                <h4>Formulaire de commande</h4>

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom complet</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse de livraison</label>
                    <textarea id="adresse" name="adresse" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité</label>
                    <input type="number" id="quantite" name="quantite" min="1" value="1" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-commander">Envoyer la commande</button>
            </form>
        </div>
    </div>
</div>

<script>
    const btnCommander = document.getElementById('btnCommander');
    const formCommande = document.getElementById('formCommande');

    btnCommander.addEventListener('click', () => {
        if (formCommande.style.display === 'none' || formCommande.style.display === '') {
            formCommande.style.display = 'block';
            btnCommander.scrollIntoView({behavior: 'smooth'});
        } else {
            formCommande.style.display = 'none';
        }
    });
</script>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
