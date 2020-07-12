<?php
//TRAITEMENT 
    //Chargement automatiques des classes avec autoload
    function chargerClasse($classe)
    {
        require $classe .'.php';
    }

    spl_autoload_register('chargerClasse');

    //ouverture d'une session pour garder en mémoire le perso (objet) selectionné le temps de la connexion
    session_start();
    
    if(isset($_SESSION['perso']))
    {
        $perso = $_SESSION['perso'];
    }
    
    //destruction de la session pour changer de personnage
    if(isset($_GET['page']) && $_GET['page'] == 'deconnexion')
    {
        unset($perso);
        session_destroy();
        header('Location: index.php');
        
    }

    //connexion BDD
    $db = new PDO('mysql:host=localhost;port=3308;dbname=jeu_combat;charset=utf8','root','');
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //instanciation de la classe manager
    $manager = new PersonnageManager($db);
    
    //Si on clique sur Créer Personnage
    if(isset($_POST['createPerso']) && !empty($_POST['nom']))
    {
        //Création du personnage en determinant la class fille choisi (objet)
        $typePerso = ucfirst($_POST['type']);
        $perso = new $typePerso(array('nom' => htmlspecialchars($_POST['nom']), 'type' => $_POST['type']));
        //Si nom entré non valide (vide)
        $verifNom = $perso -> nomValide($_POST['nom']);
        if (!$verifNom)
        {
            echo 'Le nom du personnage n\'est pas valide';
            unset($perso);
        }
        //si perso existe déjà
        elseif($manager->persoExists($_POST['nom']) > 0)
        {
            echo 'Ce personnage existe déjà !!!';
            unset($perso);
        }
        //Créer Personnage
        else
        {
            echo $manager -> addNewPerso($perso);
            echo 'Personnage créé';
        }
    }
    //Si on clique sur Utiliser Personnage
    elseif(isset($_POST['usePerso']) && !empty($_POST['nom']))
    {
        //Vérifie que perso choisi existe, on récupère les données de la table et on crée le personnage
        if($manager->persoExists(htmlspecialchars($_POST['nom'])) > 0)
        {
            $data = $manager -> selectPerso($_POST['nom']);
            $typePerso = ucfirst($data['type']);
            $perso = new $typePerso($data);
        }
        //s'il n'existe pas
        else
        {
            echo 'Veuillez créer ce Personnage !!!';
        }
    }
    //Si on choisi un personnage a frapper (si variable GET existe dans l'URL)
    elseif(isset($_GET['id']))
    {
        //On récupère les elements du perso  frapper dans la BDD et on crée le perso a frapper
        $data = $manager->selectPerso((int)$_GET['id']);
        $typePerso = ucfirst($data['type']);
        $persoAFrapper = new $typePerso($data);
        //si le perso qui frappe existe
        if(isset($perso))
        {
            //On frappe en recuperant la valeur de retour de la fonction (constantes de la classe personnage)
            $result = $perso -> frapper($persoAFrapper);
            //on modifie la BDD avec les nouvelles valeurs (dégats)
            $manager -> updatePerso($persoAFrapper);      
        }
        //On affiche un message en fonction de la valeur de retour de frapper()
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
                break;

                case 5 : 
                    $message = 'Ce personnage est endormi, vous ne pouvez pas le frapper !!!';
                break;
            }
            if(isset($message))
            {
            echo $message;
            }
        }
        
        
    }
?>

<!--AFFICHAGE-->
<!DOCTYPE>
<html> 
<p>Il y a actuellement <?=$manager->countPerso() ?> personnages enregistrés</p>   
<?php
    //S'affiche uniquement si le perso est crée (objet Personnage)
    if(isset($perso))
    {
?>  
    <!--Affichage du perso choisi ou juste crée-->
    <p>Votre personnage : <?= $perso->nom() ?> - <?= ucfirst($perso->type()) ?> ( Dégats :  <?= $perso->degats() ?> ) 
    (Atout : <?= $perso->atout() ?>) (Reveil : ) </p>
    <p>Quel personnage voulez vous frapper ? :</p>
    <p>
        <?php 
        //Affichage de la liste des persos a frapper (les persos enregistrés dans la base)
        $persos = $manager->getListPerso($perso->id());

        foreach($persos as $value) 
        {
            if($value->reveil() < time())
            {
                $reveil = 'Prêt à combattre';
            }
            else
            {
               $reveil = date('d/m/Y H:i:s',$value->reveil()); 
            }
            echo '<p><a href="?id=' . $value->id() .'">' .  $value->nom() . '</a> - ' . ucfirst($value->type()) .' ( Dégats : '. $value->degats() . ' ) 
            (Atout : ' . $value->atout() .') ( Réveil : '. $reveil . ')</p>'; 
        }
        ?>
    </p>
    <!--lien vers la deconnexion - url avec variable GET pour supprimer les variables de SESSION-->
    <p><a href="index.php?page=deconnexion">Changer de personnage</a></p>

<?php
    }
    else
    {
    //S'affiche uniquement si le perso n'est pas crée (objet Personnage)
?>
    <h1>Mini jeu de combat</h1>
    <form method='post' action="">
        <p>Nom : <input type='text' name='nom' /></p>
        <p>
            <input type='submit' name='createPerso' value='Nouveau Personnage' />
            Type du personnage : 
            <select name='type'>
                <option value='magicien'>Magicien</option>
                <option value='guerrier'>Guerrier</option>
            </select>
        </p>
        <p><input type='submit' name='usePerso' value='Utiliser Personnage' /></p>
    </form>
<?php
    }
    //Enregistrement du perso dans une variable de SESSION
    if(isset($perso))
        {
            $_SESSION['perso'] = $perso;
        }
?>
    
</html>