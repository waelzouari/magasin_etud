<style>
    /* ===== STYLE GENERAL ===== */
    body {
        background-color: #f4f6fb;
        font-family: 'Segoe UI', Arial, sans-serif;
        color: #263238;
    }

    /* ===== CARTE PRINCIPALE ===== */
    .card {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08) !important;
    }

    /* ===== EN-TETE ===== */
    .card-header.bg-dark {
        background: linear-gradient(120deg, #173b70, #2563eb) !important;
        padding: 22px 26px;
        border: none;
    }

    .card-header h5 {
        font-size: 21px;
        font-weight: 700;
        margin: 0;
    }

    /* ===== BOUTON AJOUTER ===== */
    .card-header .btn-primary {
        background: white;
        color: #1d4ed8;
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .card-header .btn-primary:hover {
        background: #dbeafe;
        color: #1e40af;
        transform: translateY(-2px);
    }

    /* ===== TABLEAU ===== */
    .table {
        font-size: 14px;
        margin-bottom: 0;
    }

    .table thead th {
        background: #edf2f9;
        color: #475569;
        font-weight: 700;
        padding: 18px 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .table tbody td {
        padding: 17px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #edf0f5;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover td {
        background-color: #eff6ff;
    }

    /* ===== BOUTONS D'ACTION ===== */
    .table .btn {
        border: none;
        border-radius: 7px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    /* Modifier */
    .table .btn-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .table .btn-warning:hover {
        background: #fcd34d;
        color: #78350f;
    }

    /* Supprimer */
    .table .btn-danger {
        background: #fee2e2;
        color: #b91c1c;
    }

    .table .btn-danger:hover {
        background: #fca5a5;
        color: #7f1d1d;
    }

    /* ===== MESSAGES ===== */
    .alert {
        border: none;
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 24px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px;
        }

        .table th,
        .table td {
            padding: 12px;
            white-space: nowrap;
        }
    }
</style>



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