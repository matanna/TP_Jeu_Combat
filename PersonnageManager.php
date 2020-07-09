<?php

class PersonnageManager
{
    //attribute
    private $_db;

    //constructor
    public function __construct(PDO $db)
    {
        $this -> setDb($db);
    }

    //setter
    public function setDb($db)
    {
        $this->_db = $db;
    }

    //Fonctionnalités de gestion de BDD et d'objets
    //** */
    //Enregistrer un personnage
    public function addNewPerso(Personnage $newPerso)
    {
        $req = $this->_db->prepare('INSERT INTO personnages (nom) VALUES (:nom)');
        $req -> execute(array('nom' => $newPerso->nom()));

        $newPerso -> hydrate(array('degats' => 0, 'id' => $this->_db->lastInsertId())); 
    }

    //modifier un personnage
    public function updatePerso(Personnage $perso)
    {
        $this->_db->exec('UPDATE personnages SET degats =' . $perso->degats());
    }

    //supprimer un personnage
    public function deletePerso(Personnage $perso)
    {
        $this->_db->exec('DELETE FROM personnages WHERE id =' . $perso->id());
    }

    //selectionner un personnage
    public function selectPerso($nomPerso)
    {
        $req = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom = :nom');
        $req -> bindValue(':nom', $nomPerso, PDO::PARAM_STR);
        $req -> execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    //compter le nombre de personnage
    public function countPerso()
    {
        return $req = $this->_db->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
    }

    //recuperer une liste de plusieurs personnage
    public function getListPerso($id)
    {
        $persos = [];
        $req = $this->_db->query('SELECT id, nom, degats FROM personnage WHERE id != ' . $id);
        while($data = $req->fetch(PDO::FETCH_ASSOC))
        {
            $persos = new Personnage($data);
        }
        return $persos;
    }

    //savoir si un personnage existe
    public function persoExists($nomPerso)
    {
        $req = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
        $req -> bindValue(':nom', $nomPerso,PDO::PARAM_STR);
        $req -> execute();

        $data = $req -> fetch(PDO::FETCH_ASSOC);
        return $data['COUNT(*)'];
    }
}