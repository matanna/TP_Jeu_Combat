

<!DOCTYPE>
<html>
<?php
    if(!empty($perso))
    {
?>
    
    <p>Votre personnage : '<?= $perso->nom() ?> - Dégats :  <?= $perso->degats() ?> </p>

<?php
    }
    else
    {
?>
    <h1>Mini jeu de combat</h1>
    <form method='post' action="">
        <p>Nom : <input type='text' name='nom' /></p>
        <p><input type='submit' name='createPerso' value='Nouveau Personnage' /></p>
        <p><input type='submit' name='usePerso' value='Utiliser Personnage' /></p>
    </form>
<?php
    }
?>
    <?php
    function chargerClasse($classe)
    {
        require $classe .'.php';
    }

    spl_autoload_register('chargerClasse');

    $db = new PDO('mysql:host=localhost;port=3308;dbname=jeu_combat;charset=utf8','root','');
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $manager = new PersonnageManager($db);
    echo '<p>Il y a actuellement '. $manager->countPerso() . ' personnages enregistrés</p>';

    if(isset($_POST['createPerso']) && isset($_POST['nom']))
    {
        $perso = new Personnage(array('nom' => htmlspecialchars($_POST['nom'])));

        $verifNom = $perso -> nomValide($_POST['nom']);
        if (!$verifNom)
        {
            echo 'Le nom du personnage n\'est pas valide';
            unset($perso);
        }
        elseif($manager->persoExists($_POST['nom']) > 0)
        {
            echo 'Ce personnage existe déjà !!!';
            unset($perso);
        }
        else
        {
            echo $manager -> addNewPerso($perso);
            echo 'Personnage créé';
        }
    }
    elseif(isset($_POST['usePerso']) && isset($_POST['nom']))
    {
        if($manager->persoExists(htmlspecialchars($_POST['nom'])) > 0)
        {
            $data = $manager -> selectPerso($_POST['nom']);
            $perso = new Personnage($data);
        }
        else
        {
            echo 'Veuillez créer ce Personnage !!!';
        }
    }
    

    ?>
</html>