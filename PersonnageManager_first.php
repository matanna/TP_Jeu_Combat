<?php

class PersonnageManager
{   
    //Attributs - Objet PDO pour la connexion a la BDD
    private $_db;

    //Attribut static de classe
    private static $_instance;

    //constructeur
    public function __construct($db)
    {
        $db->setDb($db);
    }

    //setter
    public function setDb($db)
    {
        $this->_db = $db;
    }

    //enregistrer un personnage
    public function addNewPerso(Personnage $persoNew)
    {

    }

    //modifier un personnage
    public function updatePerso(Personnage $persoUpdate)
    {

    }

    //supprimer un personnage
    public function deletePerso(Personnage $persoDelete)
    {

    }

    //selectionner un personnage
    public function getPerso($id)
    {

    }

    //liste de plusieurs personnages
    public function getListPersos($nombrePerso)
    {

    }

    //si personnage existe
    public function existPerso($id)
    {
        
    }

    //compter le nombre de personnage - nombre d'instance de la classe
    public static function nombrePerso()
    {

    }
}