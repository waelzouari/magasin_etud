<?php
// Page "ajout / modification d'un produit"
//   GET  produit_form.php          -> formulaire vide (ajout)
//   GET  produit_form.php?code=24  -> formulaire pré-rempli (modification)
//   POST produit_form.php          -> validation puis enregistrement

require '../app/init.php';

// Variables utilisées par le formulaire HTML ci-dessous
$errors     = [];   // messages d'erreur, ex. $errors['prix'] = 'Le prix doit être un entier positif.';
$categories = [];   // liste des catégories (pour la liste déroulante)
$produit    = ['code' => '', 'designation' => '', 'prix' => '', 'qte' => '', 'code_categorie' => ''];

// ......à compléter........
try {
    $produitModel = new ProduitModel();
    $categorieModel = new CategorieModel();
    $categories = $categorieModel->findAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $produit = [
            'code' => isset($_POST['code']) ? $_POST['code'] : '',
            'designation' => isset($_POST['designation']) ? $_POST['designation'] : '',
            'prix' => isset($_POST['prix']) ? $_POST['prix'] : '',
            'qte' => isset($_POST['qte']) ? $_POST['qte'] : '',
            'code_categorie' => isset($_POST['code_categorie']) ? $_POST['code_categorie'] : ''
        ];

        $produitModel->save($produit);
        redirect('produits.php?msg=ajoute');
    } elseif (isset($_GET['code'])) {

        // Modification : charger le produit existant
        $existant = $_GET['code']
            ? $produitModel->find((int) $_GET['code'])
            : null;

        if ($existant === null) {
            redirect('produits.php?msg=introuvable');
        }

        $produit = $existant;
    }
} catch (PDOException $e) {
    redirect('produits.php?msg=erreur');
}

$title = $produit['code'] !== '' ? 'Modifier un produit' : 'Ajouter un produit';
require 'layouts/header.php';


// 1. Créer un objet ProduitModel et un objet CategorieModel,
//    puis charger toutes les catégories dans $categories.
//
// 2. Si le formulaire est envoyé (méthode POST) :
//      a. récupérer les données saisies dans $produit (code, designation, prix, qte, code_categorie) ;
//      b. valider chaque champ, et en cas d'erreur remplir $errors['nom_du_champ'] :
//           - designation : obligatoire, 250 caractères au maximum ;
//           - prix et qte : entiers positifs ;
//           - code_categorie : doit correspondre à une catégorie existante ;
//      c. s'il n'y a aucune erreur : enregistrer le produit avec save(),
//         puis rediriger vers produits.php?msg=ajoute (ou msg=modifie si le code était rempli).
//
// 3. Sinon, si un code est passé dans l'URL (modification) :
//      charger le produit avec find() et le placer dans $produit ;
//      s'il n'existe pas, rediriger vers produits.php?msg=introuvable.
//
// 4. Entourer les étapes 1 à 3 d'un try / catch (PDOException)
//    qui redirige vers produits.php?msg=erreur.


// Ajoute la classe Bootstrap "is-invalid" au champ en erreur (fournie)
function invalid(array $errors, string $champ): string
{
    return isset($errors[$champ]) ? ' is-invalid' : '';
}


?>

<div class="card shadow-sm mx-auto" style="max-width: 640px;">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><?= $title ?></h5>
    </div>

    <div class="card-body">
        <form method="post" action="produit_form.php" novalidate>
            <!-- Vide pour un ajout, rempli pour une modification -->
            <input type="hidden" name="code" value="<?= $produit['code'] ?>">

            <div class="mb-3">
                <label for="designation" class="form-label">Désignation</label>
                <input type="text" class="form-control<?= invalid($errors, 'designation') ?>" id="designation"
                    name="designation" maxlength="250" value="<?= $produit['designation'] ?>">
                <div class="invalid-feedback"><?= isset($errors['designation']) ? $errors['designation'] : '' ?></div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="prix" class="form-label">Prix (DT)</label>
                    <input type="number" class="form-control<?= invalid($errors, 'prix') ?>" id="prix"
                        name="prix" min="0" value="<?= $produit['prix'] ?>">
                    <div class="invalid-feedback"><?= isset($errors['prix']) ? $errors['prix'] : '' ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="qte" class="form-label">Quantité</label>
                    <input type="number" class="form-control<?= invalid($errors, 'qte') ?>" id="qte"
                        name="qte" min="0" value="<?= $produit['qte'] ?>">
                    <div class="invalid-feedback"><?= isset($errors['qte']) ? $errors['qte'] : '' ?></div>
                </div>
            </div>

            <div class="mb-3">
                <label for="code_categorie" class="form-label">Catégorie</label>
                <select class="form-select<?= invalid($errors, 'code_categorie') ?>" id="code_categorie" name="code_categorie">
                    <option value="">-- Choisir une catégorie --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['code'] ?>"
                            <?= (string) $c['code'] === (string) $produit['code_categorie'] ? 'selected' : '' ?>>
                            <?= $c['nom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback"><?= isset($errors['code_categorie']) ? $errors['code_categorie'] : '' ?></div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <!-- form="formAnnuler" : ce bouton envoie le petit formulaire déclaré plus bas,
                     et non le formulaire du produit (deux formulaires ne peuvent pas être imbriqués) -->
                <button type="submit" form="formAnnuler" class="btn btn-secondary">Annuler</button>
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
        </form>

        <!-- Formulaire du bouton Annuler : retour à la liste -->
        <form id="formAnnuler" action="produits.php" method="get"></form>
    </div>
</div>

<?php require 'layouts/footer.php'; ?>