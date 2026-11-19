<?php

/**
 * Classe mère de tous les modèles : fournit le CRUD générique.
 * Chaque classe fille précise le nom de sa table et de sa clé primaire.
 */
abstract class Model
{
    protected string $table;              // nom de la table, ex. 'produit'
    protected string $primaryKey;  // nom de la clé primaire, ex. 'code'

    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Tous les enregistrements de la table
    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey}";
        return $this->db->query($sql)->fetchAll();
    }

    // Un enregistrement par sa clé primaire (null s'il n'existe pas)
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    // Insère un enregistrement et renvoie sa clé générée
    public function create(array $data): int
    {
        // ex. "designation, prix, qte, code_categorie"
        $columns = implode(', ', array_keys($data));
        // ex. ":designation, :prix, :qte, :code_categorie"
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int) $this->db->lastInsertId();
    }

    // Modifie l'enregistrement $id
    public function update(int $id, array $data): bool
    {
        // ex. "designation = :designation, prix = :prix, ..."
        $sets = [];
        foreach (array_keys($data) as $column) {
            $sets[] = "$column = :$column";
        }
        $setString = implode(', ', $sets);

        $sql = "UPDATE {$this->table} SET $setString WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Insère ou modifie selon la présence de la clé primaire dans $data
    public function save(array $data): int
    {
        // La clé primaire est mise de côté : elle n'est jamais insérée ni modifiée
        $id = isset($data[$this->primaryKey]) ? $data[$this->primaryKey] : '';
        unset($data[$this->primaryKey]);

        if ($id !== '') {
            $this->update((int) $id, $data);   // clé remplie : modification
            return (int) $id;
        }
        return $this->create($data);           // clé vide : insertion
    }

    // Supprime l'enregistrement $id (renvoie false s'il n'existait pas)
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
