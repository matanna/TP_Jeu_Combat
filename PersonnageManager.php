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
        $req = $this->_db->prepare('INSERT INTO personnages (nom, type, atout, reveil) VALUES (:nom, :type, :atout, :reveil)');
        $req -> execute(array('nom' => $newPerso->nom(), 'type' => $newPerso->type(),
    'atout' => 4, 'reveil' => 0));

        $newPerso -> hydrate(array('degats' => 0, 'id' => $this->_db->lastInsertId(),
    'atout' => 4, 'reveil' => 0)); 
    }

    //modifier un personnage
    public function updatePerso(Personnage $perso)
    {
        $req = $this->_db->prepare('UPDATE personnages SET degats = :degats, atout = :atout, reveil = :reveil WHERE id = :id');
        $req -> execute(array('degats' => $perso->degats(),'atout' => $perso->atout(),
        'reveil' => $perso->reveil() ,'id' => $perso->id()));
    }

    //supprimer un personnage
    public function deletePerso(Personnage $perso)
    {
        $this->_db->exec('DELETE FROM personnages WHERE id =' . $perso->id());
    }

    //selectionner un personnage
    public function selectPerso($info)
    {
        if(is_string($info))
        {
        $req = $this->_db->prepare('SELECT id, nom, degats, type, atout, reveil FROM personnages WHERE nom = :nom');
        $req -> bindValue(':nom', $info, PDO::PARAM_STR);
        $req -> execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data;
        }
        elseif(is_int($info))
        {
        $req = $this->_db->prepare('SELECT id, nom, degats, type, atout, reveil FROM personnages WHERE id = :id');
        $req -> bindValue(':id', $info, PDO::PARAM_INT);
        $req -> execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data;
        }
        
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
        $req = $this->_db->query('SELECT id, nom, degats, type, atout, reveil FROM personnages WHERE id != ' . $id);
        while($data = $req->fetch(PDO::FETCH_ASSOC))
        {
            $typePerso = ucfirst($data['type']);
            $persos[] = new $typePerso($data);
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

    //récupère une valeur de la base de données
    //public function getValue

}