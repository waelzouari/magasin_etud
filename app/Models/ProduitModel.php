<?php
class ProduitModel extends Model
{
    protected string $table = 'produit';
    protected string $primaryKey = 'code';

    // Méthode spécifique : les produits avec le nom de leur catégorie (jointure)
    public function findAllWithCategorie(): array
    {
        $sql = "SELECT p.code,
                       p.designation,
                       p.prix,
                       p.qte,
                       c.nom AS categorie
                FROM produit p
                LEFT JOIN categorie c
                ON p.code_categorie = c.code
                ORDER BY p.code;";
        return $this->db->query($sql)->fetchAll();
    }
}
