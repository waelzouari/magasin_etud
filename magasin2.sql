-- Base de données du projet magasin
-- À importer dans phpMyAdmin (onglet Importer) ou avec : mysql -u root < magasin2.sql

SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS magasin2
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE magasin2;

DROP TABLE IF EXISTS produit;
DROP TABLE IF EXISTS categorie;

CREATE TABLE categorie (
    code INT AUTO_INCREMENT PRIMARY KEY,
    nom  VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE produit (
    code           INT AUTO_INCREMENT PRIMARY KEY,
    designation    VARCHAR(250) NOT NULL,
    prix           INT NOT NULL,
    qte            INT NOT NULL,
    code_categorie INT NOT NULL,
    CONSTRAINT fk_produit_categorie
        FOREIGN KEY (code_categorie) REFERENCES categorie(code)
) ENGINE=InnoDB;

INSERT INTO categorie (code, nom) VALUES
    (1, 'Matériel Informatique'),
    (2, 'Accessoires'),
    (3, 'Meuble Bureau'),
    (4, 'Informatique');

INSERT INTO produit (code, designation, prix, qte, code_categorie) VALUES
    (24, 'clavier', 60, 12, 1),
    (25, 'micro', 12, 100, 2),
    (26, 'souris', 10, 15, 2),
    (27, 'chaise', 60, 5, 3),
    (28, 'bureau', 200, 5, 3),
    (40, 'Souris', 15, 10, 4);
