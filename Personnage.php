<?php

abstract class Personnage
{
    //attributes
    private $_id;
    private $_nom;
    private $_degats;
    protected $_type;
    protected $_atout;
    protected $_reveil;

    //constantes
    const CEST_MOI = 1;
    const PERSONNAGE_TUE = 2;
    const PERSONNAGE_FRAPPE = 3;

    //constructor
    public function __construct(array $init)
    {
        $this -> hydrate($init);
        $this->_type = strtolower(static::class);
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

    public function type()
    {
        return $this->_type;
    }

    public function atout()
    {
        return $this->_atout;
    }

    public function reveil()
    {
        return $this->_reveil;
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
        if ($degats>=0)
        {
            $this->_degats = $degats;
        }
    }

    public function setAtout($atout)
    {
        $atout = (int)$atout;
        if($this->_degats >= 0 && $this->_degats < 25 )
        {
            $this->_atout = 4;
        }
        elseif($this->_degats >= 25 && $this->_degats < 50 )
        {
            $this->_atout = 3;
        }
        if($this->_degats >= 50 && $this->_degats < 75 )
        {
            $this->_atout = 2;
        }
        elseif($this->_degats >= 75 && $this->_degats < 90 )
        {
            $this->_atout = 1;
        }
        elseif($this->_degats >= 90 &&  $this->_degats <=100)
        {
            $this->_atout = 0;
        }
    }

    public function setReveil($reveil)
    {
        $reveil = (int)$reveil;
        if($reveil < time())
        {
            $this->_reveil = 0;
        }
        else
        {
            $this->_reveil = $reveil;
        }
    }

    //fonctions        
    abstract public function frapper(Personnage $persoAFrapper);

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