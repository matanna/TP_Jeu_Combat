<?php

class Magicien extends Personnage
{
    const PLUS_DE_MAGIE = 4;
    const IL_DORT = 5;

    public function lancerUnSort(Personnage $persoAEndormir)
    {
        if($this->atout() == 0)
        {
            return self::PLUS_DE_MAGIE;
        }
        else
        {
            {
                $tpsDodo = $this->atout()*6*3600;
                $reveil = $persoAEndormir->reveil() + time() + 5;
                $persoAEndormir->setReveil($reveil);
            }
        }
        
    }

    public function frapper(Personnage $persoAFrapper)
    {
        if ($persoAFrapper->id() == $this->id())
        {
            return self::CEST_MOI;
        }
        elseif($persoAFrapper->reveil() != 0)
        {
            return self::IL_DORT;
        }
        else
        {
            $persoAFrapper -> recevoirDegats();
            $this->lancerUnSort($persoAFrapper);
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