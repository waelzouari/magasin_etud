
<?php
require '../app/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('produits.php');
}

if (isset($_POST['code'])) {
    $code = $_POST['code'];

    try {
        if ((new ProduitModel())->delete((int) $code)) {
            redirect('produits.php?msg=supprime');
        }

        redirect('produits.php?msg=introuvable');
    } catch (PDOException $e) {
        redirect('produits.php?msg=erreur');
    }
}
