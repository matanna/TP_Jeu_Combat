<?php

class Guerrier extends Personnage
{
    public function recevoirDegats()
    {
        $doseDegats = 5 - $this->atout();
        $degats = $this->degats() + $doseDegats;
        $this->setDegats($degats);
    }

    public function frapper(Personnage $persoAFrapper)
    {
    if ($persoAFrapper->id() == $this->id())
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
}

