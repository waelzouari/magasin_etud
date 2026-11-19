<?php

require '../app/init.php';

$produitModel = new ProduitModel();
$categorieModel = new CategorieModel();

echo '<h2>Produits</h2>';
echo '<pre>';
var_dump($produitModel->findAll());
echo '</pre>';

echo '<h2>Produit 24</h2>';
echo '<pre>';
var_dump($produitModel->find(24));
echo '</pre>';

echo '<h2>Produits avec catégorie</h2>';
echo '<pre>';
var_dump($produitModel->findAllWithCategorie());
echo '</pre>';

echo '<h2>Catégories</h2>';
echo '<pre>';
var_dump($categorieModel->findAll());
echo '</pre>';
