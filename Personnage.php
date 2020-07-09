<?php

class Personnage
{
    //attributes
    private $_id;
    private $_nom;
    private $_degats;

    //constantes
    const CEST_MOI = 1;
    const PERSONNAGE_TUE = 2;
    const PERSONNAGE_FRAPPE = 3;

    //constructor
    public function __construct(array $init)
    {
        $this -> hydrate($init);
    }

    //hydrate
    public function hydrate(array $init)
    {
        foreach ($init as $key => $value)
        {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method))
            {
                $this -> $method($value);
            }
        }
    }

    //getters
    public function id()
    {
        return $this->_id;
    }

    public function nom()
    {
        return $this->_nom;
    }

    public function degats()
    {
        return $this->_degats;
    }

    //setters
    public function setId($id)
    {
        $id = (int) $id;
        if ( $id > 0 )
        {
            $this->_id = $id;
        }
    }

    public function setNom($nom)
    {
        if (is_string($nom))
        {
            $this->_nom = $nom;
        }
    }

    public function setDegats($degats)
    {
        $degats = (int)$degats;
        if ($degats>=0 && $degats<=100)
        {
            $this->_degats = $degats;
        }
    }
    //fonctions        
    public function frapper(Personnage $persoAFrapper)
    {
        if ($persoAFrapper->id() == $this->_id)
        {
            return self::CEST_MOI;
        }
        else
        {
            $persoAFrapper -> recevoirDegats();
            if ($persoAFrapper->degats() >= 100)
            {
                return self::PERSONNAGE_TUE;
            } 
            else
            {
                return self::PERSONNAGE_FRAPPE;
            }
        }
    }

    public function recevoirDegats()
    {
        $this->_degats += 5;
    }

    public function nomValide($nomAVerifier)
    {
        if(empty($nomAVerifier))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}