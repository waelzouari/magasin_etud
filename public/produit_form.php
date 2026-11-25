<?php
// Page "ajout / modification d'un produit"
// GET  produit_form.php          -> formulaire vide (ajout)
// GET  produit_form.php?code=24  -> formulaire pré-rempli (modification)
// POST produit_form.php          -> validation puis enregistrement

require '../app/init.php';

// Variables utilisées par le formulaire
$errors = [];
$categories = [];

$produit = [
    'code' => '',
    'designation' => '',
    'prix' => '',
    'qte' => '',
    'code_categorie' => ''
];

try {
    $produitModel = new ProduitModel();
    $categorieModel = new CategorieModel();

    // Charger toutes les catégories
    $categories = $categorieModel->findAll();

    // Si le formulaire est envoyé
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Récupérer les données saisies
        $produit = [
            'code' => isset($_POST['code']) ? $_POST['code'] : '',
            'designation' => isset($_POST['designation']) ? $_POST['designation'] : '',
            'prix' => isset($_POST['prix']) ? $_POST['prix'] : '',
            'qte' => isset($_POST['qte']) ? $_POST['qte'] : '',
            'code_categorie' => isset($_POST['code_categorie']) ? $_POST['code_categorie'] : ''
        ];

        // Enregistrer le produit
        $produitModel->save($produit);

        redirect('produits.php?msg=ajoute');

    } elseif (isset($_GET['code'])) {

        // Modification : charger le produit existant
        $existant = $_GET['code']
            ? $produitModel->find((int) $_GET['code'])
            : null;

        // Vérifier si le produit existe
        if ($existant === null) {
            redirect('produits.php?msg=introuvable');
        }

        $produit = $existant;
    }

} catch (PDOException $e) {
    redirect('produits.php?msg=erreur');
}

// Déterminer le titre
$title = $produit['code'] !== ''
    ? 'Modifier un produit'
    : 'Ajouter un produit';

require 'layouts/header.php';

// Ajouter la classe is-invalid si le champ contient une erreur
function invalid(array $errors, string $champ): string
{
    return isset($errors[$champ]) ? ' is-invalid' : '';
}
?>

<style>

/* =========================
   ARRIÈRE-PLAN DE LA PAGE
========================= */

body {
    background: #f3f6fb;
    font-family: "Segoe UI", Arial, sans-serif;
}

/* =========================
   CARTE PRINCIPALE
========================= */

.card.shadow-sm.mx-auto {
    max-width: 640px;
    margin-top: 45px;
    margin-bottom: 45px;
    border: none;
    border-radius: 18px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 10px 35px rgba(30, 50, 90, 0.10) !important;
}

/* =========================
   EN-TÊTE DE LA CARTE
========================= */

.card-header.bg-dark {
    background: linear-gradient(135deg, #1e3a5f, #2563eb) !important;
    color: white;
    padding: 24px 28px;
    border: none;
}

.card-header h5 {
    font-size: 23px;
    font-weight: 700;
    letter-spacing: 0.3px;
}

.card-header small {
    font-size: 14px;
}

/* =========================
   CORPS DU FORMULAIRE
========================= */

.card-body {
    padding: 30px;
}

/* =========================
   LABELS
========================= */

.form-label {
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
}

/* =========================
   INPUTS ET SELECT
========================= */

.form-control,
.form-select {
    border: 1px solid #dbe3ee;
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 15px;
    background-color: #f8fafc;
    color: #1e293b;
    transition: all 0.25s ease;
}

/* Effet lors du clic */

.form-control:focus,
.form-select:focus {
    background-color: #ffffff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
    outline: none;
}

/* Placeholder */

.form-control::placeholder {
    color: #94a3b8;
}

/* =========================
   CHAMPS INVALIDES
========================= */

.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #dc3545;
    background-color: #fff8f8;
}

.invalid-feedback {
    font-size: 13px;
    margin-top: 6px;
}

/* =========================
   BOUTONS
========================= */

.card-body .btn {
    padding: 11px 22px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.25s ease;
}

/* Bouton Annuler */

.card-body .btn-secondary {
    background-color: #e2e8f0;
    color: #334155;
    border: none;
}

.card-body .btn-secondary:hover {
    background-color: #cbd5e1;
    transform: translateY(-2px);
}

/* Bouton Enregistrer */

.card-body .btn-success {
    background: linear-gradient(135deg, #16a34a, #15803d);
    border: none;
    box-shadow: 0 4px 10px rgba(22, 163, 74, 0.20);
}

.card-body .btn-success:hover {
    background: linear-gradient(135deg, #15803d, #166534);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(22, 163, 74, 0.25);
}

/* =========================
   ESPACEMENT
========================= */

.card-body .mb-3 {
    margin-bottom: 22px !important;
}

/* =========================
   RESPONSIVE - MOBILE
========================= */

@media (max-width: 576px) {

    .card.shadow-sm.mx-auto {
        margin: 20px 12px !important;
        border-radius: 14px;
    }

    .card-header.bg-dark {
        padding: 20px;
    }

    .card-header h5 {
        font-size: 20px;
    }

    .card-body {
        padding: 20px;
    }

    .card-body .btn {
        padding: 10px 16px;
    }
}

</style>


<!-- =========================
     FORMULAIRE PRODUIT
========================= -->

<div class="card shadow-sm mx-auto">

    <!-- En-tête -->
    <div class="card-header bg-dark text-white">

        <h5 class="mb-1">
            <?= htmlspecialchars($title) ?>
        </h5>

        <small class="text-white-50">
            Gestion et informations du produit
        </small>

    </div>


    <!-- Corps -->
    <div class="card-body">

        <form method="post" action="produit_form.php" novalidate>

            <!-- Code du produit -->
            <input
                type="hidden"
                name="code"
                value="<?= htmlspecialchars((string)$produit['code']) ?>"
            >


            <!-- Désignation -->
            <div class="mb-3">

                <label for="designation" class="form-label">
                    Désignation
                </label>

                <input
                    type="text"
                    class="form-control<?= invalid($errors, 'designation') ?>"
                    id="designation"
                    name="designation"
                    maxlength="250"
                    placeholder="Nom du produit"
                    value="<?= htmlspecialchars((string)$produit['designation']) ?>"
                >

                <div class="invalid-feedback">
                    <?= isset($errors['designation']) ? $errors['designation'] : '' ?>
                </div>

            </div>


            <!-- Prix et quantité -->
            <div class="row">

                <!-- Prix -->
                <div class="col-md-6 mb-3">

                    <label for="prix" class="form-label">
                        Prix (DT)
                    </label>

                    <input
                        type="number"
                        class="form-control<?= invalid($errors, 'prix') ?>"
                        id="prix"
                        name="prix"
                        min="0"
                        placeholder="Prix du produit"
                        value="<?= htmlspecialchars((string)$produit['prix']) ?>"
                    >

                    <div class="invalid-feedback">
                        <?= isset($errors['prix']) ? $errors['prix'] : '' ?>
                    </div>

                </div>


                <!-- Quantité -->
                <div class="col-md-6 mb-3">

                    <label for="qte" class="form-label">
                        Quantité
                    </label>

                    <input
                        type="number"
                        class="form-control<?= invalid($errors, 'qte') ?>"
                        id="qte"
                        name="qte"
                        min="0"
                        placeholder="Quantité disponible"
                        value="<?= htmlspecialchars((string)$produit['qte']) ?>"
                    >

                    <div class="invalid-feedback">
                        <?= isset($errors['qte']) ? $errors['qte'] : '' ?>
                    </div>

                </div>

            </div>


            <!-- Catégorie -->
            <div class="mb-3">

                <label for="code_categorie" class="form-label">
                    Catégorie
                </label>

                <select
                    class="form-select<?= invalid($errors, 'code_categorie') ?>"
                    id="code_categorie"
                    name="code_categorie"
                >

                    <option value="">
                        -- Choisir une catégorie --
                    </option>

                    <?php foreach ($categories as $c): ?>

                        <option
                            value="<?= htmlspecialchars((string)$c['code']) ?>"
                            <?= (string)$c['code'] === (string)$produit['code_categorie'] ? 'selected' : '' ?>
                        >

                            <?= htmlspecialchars($c['nom']) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

                <div class="invalid-feedback">
                    <?= isset($errors['code_categorie']) ? $errors['code_categorie'] : '' ?>
                </div>

            </div>


            <!-- Boutons -->
            <div class="d-flex justify-content-end gap-2">

                <!-- Bouton Annuler -->
                <button
                    type="submit"
                    form="formAnnuler"
                    class="btn btn-secondary"
                >
                    Annuler
                </button>


                <!-- Bouton Enregistrer -->
                <button
                    type="submit"
                    class="btn btn-success"
                >
                    Enregistrer
                </button>

            </div>

        </form>


        <!-- Formulaire du bouton Annuler -->
        <form
            id="formAnnuler"
            action="produits.php"
            method="get"
        >
        </form>

    </div>

</div>


<?php require 'layouts/footer.php'; ?>