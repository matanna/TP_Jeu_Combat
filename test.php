<?php
class MaClasse
{
  public function __call($nom, $arguments)
  {
    echo 'La méthode <strong>', $nom, '</strong> a été appelée alors qu\'elle n\'existe pas ! Ses arguments étaient les suivants : <strong>', implode(' ', $arguments);
  }
}

$obj = new MaClasse;

$obj->methode(123, 'test');