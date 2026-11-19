<?php
// Page "liste des produits"

require '../app/init.php';

// Messages possibles après une action (le code arrive dans l'URL : produits.php?msg=ajoute)
// On n'affiche jamais le texte de l'URL, seulement un message choisi dans cette liste.
$messages = [
    'ajoute'      => ['success', 'Produit ajouté avec succès.'],
    'modifie'     => ['success', 'Produit modifié avec succès.'],
    'supprime'    => ['success', 'Produit supprimé avec succès.'],
    'introuvable' => ['warning', 'Produit introuvable.'],
    'erreur'      => ['danger',  "Erreur d'accès à la base de données."],
];
$message = null;
if (isset($_GET['msg']) && isset($messages[$_GET['msg']])) {
    $message = $messages[$_GET['msg']];
}


// ......à complèter........

try {
    $produits = (new ProduitModel())->findAllWithCategorie();
} catch (PDOException $e) {
    $produits = [];
    $message  = ['danger', 'Impossible de charger les produits. Vérifiez la connexion à la base de données.'];
}

$title = 'Gestion des produits';
require 'layouts/header.php';
?>

<?php if ($message): ?>
    <div class="alert alert-<?= $message[0] ?> alert-dismissible fade show" role="alert">
        <?= $message[1] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Gestion des Produits</h5>
        <form action="produit_form.php" method="get" class="m-0">
            <button type="submit" class="btn btn-primary btn-sm">Ajouter Produit</button>
        </form>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th>Désignation</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Catégorie</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produits)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Aucun produit.</td>
                    </tr>
                <?php endif; ?>


                <?php foreach ($produits as $p): ?>
                    <tr>
                        <td><?= $p['code'] ?></td>
                        <td><?= $p['designation'] ?></td>
                        <td><?= $p['prix'] ?> DT</td>
                        <td><?= $p['qte'] ?></td>
                        <td><?= $p['categorie'] ?></td>

                        <td class="text-end">
                            <form action="produit_form.php" method="get" class="d-inline">
                                <button type="submit" class="btn btn-warning btn-sm">Éditer</button>
                                <input type="hidden" name="code" value="<?= $p['code'] ?>">
                            </form>

                            <form action="produit_delete.php" method="post" class="d-inline"
                                onsubmit="return confirm('Supprimer ce produit ?');">

                                <input type="hidden" name="code" value="<?= $p['code'] ?>">

                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>


                <!--......à complèter........-->


            </tbody>
        </table>
    </div>
</div>


<?php require 'layouts/footer.php'; ?>