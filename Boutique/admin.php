<?php
require 'db.php';

$message = '';
$error = '';

//SUPPRIMER
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $prod = $stmt->fetch();
    if ($prod && $prod['image'] && file_exists($prod['image'])) {
        unlink($prod['image']); // حذف الصورة من المجلد
    }
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin.php');
    exit;
}
//MODIFIER
$edit_mode = false;
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $produit_edit = $stmt->fetch();
    if (!$produit_edit) {
        $error = "Produit introuvable.";
        $edit_mode = false;
    }
}

//AJOUTER
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
    $prix = $_POST['prix'] ?? 0;
    $prix = floatval($prix);
    $id = $_POST['id'] ?? null;

    // Validation simple
    if (!$titre || !$description || $prix <= 0) {
        $error = "Tous les champs sont obligatoires et le prix doit être positif.";
    } else {
        $image_path = null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $upload_dir = 'upload/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $image_name = uniqid() . '_' . basename($_FILES['image']['name']);
            $target_file = $upload_dir . $image_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_path = $target_file;
            } else {
                $error = "Erreur lors du téléchargement de l'image.";
            }
        }

        if (!$error) {
            if ($id) {

                $stmt = $pdo->prepare("SELECT image FROM produits WHERE id = ?");
                $stmt->execute([$id]);
                $old = $stmt->fetch();

                if ($image_path) {
                    if ($old && $old['image'] && file_exists($old['image'])) {
                        unlink($old['image']);
                    }
                    $stmt = $pdo->prepare("UPDATE produits SET titre = ?, description = ?, prix = ?, image = ? WHERE id = ?");
                    $stmt->execute([$titre, $description, $prix, $image_path, $id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE produits SET titre = ?, description = ?, prix = ? WHERE id = ?");
                    $stmt->execute([$titre, $description, $prix, $id]);
                }
                $message = "Produit modifié avec succès.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO produits (titre, description, prix, image) VALUES (?, ?, ?, ?)");
                $stmt->execute([$titre, $description, $prix, $image_path]);
                $message = "Produit ajouté avec succès.";
            }

            header("Location: admin.php?msg=" . urlencode($message));
            exit;
        }
    }
}

$stmt = $pdo->query("SELECT * FROM produits ORDER BY id DESC");
$produits = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Abayas Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container">
    <a class="navbar-brand" href="admin.php">Abayas Boutique - Admin</a>
    <div>
      <a href="logout.php" class="btn btn-outline-danger">Déconnexion</a>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h1 class="mb-4">Gestion des Abayas</h1>

    <?php if (!empty($_GET['msg'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Formulaire ajout/modification -->
    <div class="card mb-4">
        <div class="card-header">
            <?= $edit_mode ? 'Modifier un produit' : 'Ajouter un nouveau produit' ?>
        </div>
        <div class="card-body">
            <form action="admin.php" method="post" enctype="multipart/form-data">
                <?php if ($edit_mode): ?>
                    <input type="hidden" name="id" value="<?= (int)$produit_edit['id'] ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" name="titre" id="titre" class="form-control" required
                        value="<?= $edit_mode ? htmlspecialchars($produit_edit['titre']) : '' ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control" required><?= $edit_mode ? htmlspecialchars($produit_edit['description']) : '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="prix" class="form-label">Prix (Dh)</label>
                    <input type="number" step="0.01" min="0" name="prix" id="prix" class="form-control" required
                        value="<?= $edit_mode ? htmlspecialchars($produit_edit['prix']) : '' ?>">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image <?= $edit_mode ? '(laisser vide pour garder actuelle)' : '' ?></label>
                    <input type="file" name="image" id="image" class="form-control" <?= $edit_mode ? '' : 'required' ?>>
                    <?php if ($edit_mode && $produit_edit['image']): ?>
                        <img src="<?= htmlspecialchars($produit_edit['image']) ?>" alt="Image actuelle" style="width:100px;margin-top:10px;">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary"><?= $edit_mode ? 'Modifier' : 'Ajouter' ?></button>
                <?php if ($edit_mode): ?>
                    <a href="admin.php" class="btn btn-secondary ms-2">Annuler</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Tableau des produits -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Prix (Dh)</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($produits as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['titre']) ?></td>
                <td><?= htmlspecialchars($p['description']) ?></td>
                <td><?= number_format($p['prix'], 2) ?></td>
                <td>
                    <?php if ($p['image']): ?>
                        <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['titre']) ?>" style="width:80px;" />
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <a href="admin.php?edit=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                    <a href="admin.php?delete=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
