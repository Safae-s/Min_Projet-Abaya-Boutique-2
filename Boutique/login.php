<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && hash('sha256', $password) === $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header('Location: admin.php');
            exit;
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Abaya Boutique - Connexion Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="style.css">
<style>
  body {
    background: #ffe6f0;
    font-family: 'Poppins', sans-serif;
  }
  .card {
    border: none;
    border-radius: 30px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    overflow: hidden;
  }
  .gradient-custom-2 {
    background: linear-gradient(135deg, #b30059, #ff4da6);
  }
  .form-control:focus {
    border-color: #b30059;
    box-shadow: 0 0 0 0.2rem rgba(179, 0, 89, 0.25);
  }
  .btn-custom {
    background-color: #b30059;
    color: #fff;
    transition: 0.3s;
  }
  .btn-custom:hover {
    background-color: #80003d;
  }
  .login-title {
    color: #b30059;
    font-weight: bold;
    margin-bottom: 6px;
  }
  .alert {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
  }
  .form-label {
    font-size: 15px;
    font-weight: 600;
    color: #b30059;
  }
  .form-control {
    font-size: 16px;
    border-radius: 8px;
  }
  .welcome-text h4 {
    font-weight: 700;
    margin-bottom: 1rem;
    color: #fff;
  }
  .welcome-text p {
    font-size: 16px;
    line-height: 1.5;
    color: #f0f8ff;
  }
  .welcome-image img {
    max-width: 220px;
  }
</style>

</head>
<body>
<h1 class="titre " >🎀 Abaya Boutique 🎀</h1>

<section class="h-100 d-flex align-items-center justify-content-center" style="min-height: 60vh;">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-xl-10">
        <div class="card shadow border-0 rounded-4 overflow-hidden">
          <div class="row g-0">
            <div class="col-lg-6 gradient-custom-2 d-flex flex-column align-items-center justify-content-center p-4">
              <div class="welcome-image mb-3">
                <img src="upload/image.png" alt="Livres ouverts" >
              </div>
              <div class="welcome-text text-center text-white px-3">
                <h4>Bienvenue à votre espace d'administration</h4>
                <p>Gérez vos produits facilement et efficacement avec notre interface intuitive et moderne.</p>
              </div>
            </div>

            <!-- Formulaire -->
            <div class="col-lg-6 d-flex flex-column justify-content-center p-4">
              <h2 class="text-center mb-3 login-title"> Connexion Admin </h2>
              <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
              <?php endif; ?>

              <form method="post" action="">
                <div class="mb-3">
                  <label class="form-label">Nom d'utilisateur</label>
                  <input type="text" name="username" class="form-control" required />
                </div>
                <div class="mb-3">
                  <label class="form-label">Mot de passe</label>
                  <input type="password" name="password" class="form-control" required />
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-custom">Se connecter</button>
                </div>
              </form>
            </div>
          </div> <!-- row -->
        </div> <!-- card -->
      </div>
    </div>
  </div>
</section>

</body>
</html>
