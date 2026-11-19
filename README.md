# Magasin : CRUD Produit en PHP orienté objet (solution complète)

## Installation (XAMPP)

1. Copier le dossier `magasin` dans `C:\xampp\htdocs\`.
2. Démarrer Apache et MySQL depuis le panneau XAMPP.
3. Dans phpMyAdmin, onglet **Importer**, choisir `magasin2.sql`.
   (Le script crée la base `magasin2`, les tables et quelques produits.)
4. Si besoin, adapter `config/config.php` (utilisateur, mot de passe).
5. Ouvrir : http://localhost/magasin/public/

PHP 8.0 ou plus récent est requis. Aucune connexion Internet n'est nécessaire :
Bootstrap est inclus dans `public/assets/bootstrap/`.

## Structure

```
magasin/
├── app/
│   ├── init.php              require_once des classes + fonction redirect()
│   ├── Database.php          connexion PDO (Singleton)
│   └── Models/
│       ├── Model.php         classe abstraite : CRUD générique
│       ├── ProduitModel.php  table produit + jointure avec categorie
│       └── CategorieModel.php
├── config/
│   └── config.php            paramètres de la base
├── public/
│   ├── index.php             redirige vers produits.php
│   ├── produits.php          liste (Read) + bouton de suppression
│   ├── produit_form.php      ajout et modification (Create / Update)
│   ├── produit_delete.php    suppression en POST (Delete)
│   ├── layouts/              header.php, footer.php
│   └── assets/
│       ├── bootstrap/        bootstrap.min.css, bootstrap.bundle.min.js
│       └── css/style.css
└── magasin2.sql              script de création de la base
```

## Correspondance avec les étapes du chapitre

| Étape | Fichiers |
|---|---|
| 1. Template et structure | `public/layouts/*`, `public/assets/*` |
| 2. Configuration et Database | `config/config.php`, `app/Database.php` |
| 3. Classe abstraite Model | `app/Models/Model.php` |
| 4. Classes filles | `app/Models/ProduitModel.php`, `app/Models/CategorieModel.php`, chargées par `app/init.php` |
| 5. Liste (Read) | `public/produits.php` |
| 6. Ajout / Modification | `public/produit_form.php` |
| 7. Suppression | `public/produit_delete.php`, formulaire POST + `confirm()` dans `produits.php` |
| 8. Bonnes pratiques | messages après redirection (`produits.php?msg=...`), `try/catch` dans les pages |

Ne sont pas utilisés à ce stade (prévus pour le chapitre MVC) : autoloading, namespaces,
sessions, séparation des pages en contrôleur + vue.
