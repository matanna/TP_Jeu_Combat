<?php
    function chargerClasse($classe)
    {
        require $classe .'.php';
    }

    spl_autoload_register('chargerClasse');

    session_start();
    if(isset($_SESSION['perso']))
    {
        $perso = $_SESSION['perso'];
    }
    

    if(isset($_GET['page']) && $_GET['page'] == 'deconnexion')
    {
        session_destroy();
    }

    $db = new PDO('mysql:host=localhost;port=3308;dbname=jeu_combat;charset=utf8','root','');
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $manager = new PersonnageManager($db);
    

    if(isset($_POST['createPerso']) && !empty($_POST['nom']))
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
    elseif(isset($_POST['usePerso']) && !empty($_POST['nom']))
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
    elseif(isset($_GET['id']))
    {
        $data = $manager->selectPerso((int)$_GET['id']);
        $persoAFrapper = new Personnage($data);
        if(isset($perso))
        {
            $result = $perso -> frapper($persoAFrapper);
            $manager -> updatePerso($persoAFrapper);
            
        }
        if(isset($result))
        {
            switch($result)
            {
                case 1 :
                    $message = 'Vous vous frappez vous même';
                break;

                case 2 :
                    $message = 'Le personnage est mort';
                    $manager -> deletePerso($persoAFrapper);
                break;
                
                case 3 :
                    $message = 'le perso vient de prendre 5 points de dégats';
            }
            if(isset($message))
            {
            echo $message;
            }
        }
        
        
    }
?>

<!DOCTYPE>
<html> 
<p>Il y a actuellement <?=$manager->countPerso() ?> personnages enregistrés</p>   
<?php
    if(isset($perso))
    {
?>
    
    <p>Votre personnage : <?= $perso->nom() ?> - Dégats :  <?= $perso->degats() ?> </p>
    <p>Quel personnage voulez vous frapper ? :</p>
    <p>
        <?php 

        $persos = $manager->getListPerso($perso->id());

        foreach($persos as $value) 
        {
            echo '<p><a href="?id=' . $value->id() .'">' .  $value->nom() . '</a> - Dégats : '. $value->degats() . '</p>'; 
        }
        ?>
    </p>
    <p><a href="index.php?page=deconnexion">Changer de personnage</a></p>

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
    if(isset($perso))
        {
            $_SESSION['perso'] = $perso;
        }
?>
    
</html>