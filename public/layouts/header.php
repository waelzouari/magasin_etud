<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $title : 'Magasin' ?></title>
    <!-- Bootstrap 5.3 (fichier téléchargé) -->
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Styles propres à l'application -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="produits.php">Magasin</a>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link active" href="produits.php">Produits</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Catégories</a></li>
        </ul>
    </div>
</nav>

<main class="container py-4">
