<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

// Restriction d'accès, si l'utilisateur n'est pas connecté, on redirige vers connexion.php
if (user_is_connected()) {

// Declaration des variables pour eviter les errerus dans le formulaire
$pseudo = '';
$nom = '';
$prenom = '';
$email ='';
$civilite ='';
$tel ='';

    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
    // SUPPRESSION D'UN MEMBRE
    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
    if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_SESSION['membre']['id_membre']) ) {
        // si l'indice action existe dans $_GET et si sa valeur est égal à supprimmer && et si id_article existe et n'est pas vide dans $_GET
        // Requete delete basée sur l'id_article pour supprimer l'article  en question.
        $suppression = $pdo->prepare("DELETE FROM membre WHERE id_membre = :id_membre");// preparer la requete
        $suppression->bindParam(':id_membre', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);// selectionner la cible de la requete
        $suppression->execute(); // executer la requete 

        session_destroy();
        echo "<script type='text/javascript'>alert('Vos données ont été supprimer');document.location.href = 'inscription.php';
                </script>";

        

        
    }
// Recuperation des commentaires ---------------------------
  // Recuperation des titre des annonces commentees
  $info_annonce = $pdo->prepare("SELECT * FROM commentaire AS c, annonce AS a, membre AS M WHERE c.annonce_id = a.id_annonce AND m.id_membre = :membre_id ORDER BY c.date_enregistrement DESC" ) ;
  $info_annonce->bindParam(':membre_id', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);

  $info_annonce->execute();
  // Recuperation des commentaire
 $liste_commentaires = $pdo->prepare("SELECT * FROM commentaire WHERE membre_id = :id_membre ORDER BY date_enregistrement DESC" ) ;
 $liste_commentaires->bindParam(':id_membre', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);
 $liste_commentaires->execute();

// Si tous les champs sont remplis
if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['civilite']) && isset($_POST['tel'])) {
         
    // On retire les caracteres speciaux et les espaces et on injecte les resultats du formulaire dans les variables
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $civilite = trim($_POST['civilite']);
    $tel = trim($_POST['tel']);

      // on prevois les cas d'erreur
      $erreur = false;



   
        // Verification du mail 
            // - Verification de son format
        if( filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $erreur = true;
            $msg .= '<div class="alert alert-warning" role="alert"> Attention, Le format du mail est invalide.</div>';

        }

          // POUR MODIFICATION
        // On vérifie si l'id_article existe et n'est pas vide : si c'est le cas, on est en modification
        if( !empty($_POST['id_membre']) ) {
            $id_membre = trim($_POST['id_membre']);
        } else  {
            $msg .= '<div class="alert alert-warning" role="alert"> Attention, Le format du mail est invalide.</div>';
        }
//---------------------------
         // Si tout est OK on lance lA MODIFICATION
         if($erreur == false) {
         
        $verif_id_membre = $pdo->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
        $verif_id_membre->bindParam(':id_membre', $id_membre, PDO::PARAM_STR);
        $verif_id_membre->execute();

        // Il ne faut pas vérifier si la référence  existe dans le cadre d'une modif, donc on rajoute un controle sur id_membre qui doit être vide. Car en cas d'insert, l'id_membre sera vide, en revanche sur une  modif il n'est pas vide.
        if( $verif_id_membre->rowCount()>= 1) {
          
            $enregistrement = $pdo->prepare("UPDATE membre SET  nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, civilite = :civilite WHERE id_membre = :id_membre");
        
        $enregistrement->bindParam(':id_membre', $id_membre, PDO::PARAM_STR);
        $enregistrement->bindParam(':nom', $nom, PDO::PARAM_STR);
        $enregistrement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $enregistrement->bindParam(':telephone', $tel, PDO::PARAM_STR);
        $enregistrement->bindParam(':email', $email, PDO::PARAM_STR);
        $enregistrement->bindParam(':civilite', $civilite, PDO::PARAM_STR);
        $enregistrement->execute();



        session_destroy();
        echo "<script type='text/javascript'>alert('Vos informations on bien été enregistrées. Vous allez être redirigé afin de vous reconnecter');document.location.href = 'connexion.php';
    </script>";
        
  
        // header('location:connexion.php');
      
        
    }
    


        }

    }

    // Si enregistrement ok on envoi sur la page connexion afin d'eviter le rechargement de la page
           // header('location:connexion.php');

$membre_id = $_SESSION['membre']['id_membre'];

$liste_annonces = $pdo->query("SELECT id_annonce, titre, description_courte, prix, photo FROM annonce WHERE membre_id = $membre_id ORDER BY  titre");
           
}else{
    header('location:connexion.php');
}



include 'inc/header.inc.php';
include 'inc/nav.inc.php';
?>
<main class="container">
    <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
        <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Votre profil <i class="fas fa-bahai seaGreen"></i></h1>
        <p class="lead seaGreen ">Bienvenue sur notre site.
            <hr><?php echo $msg; ?></p>
    </div>

    <div class="row">
        <div class=" mx-auto col-lg-8 col-sm-12 mt-5 mb-5">

            <?php



            // Pour sexe, on affiche homme ou femme pour m ou f
            if ($_SESSION['membre']['civilite'] == 'm') {
                $civilite = 'homme';
            } else {
                $civilite = 'femme';
            }

            // Pour le statut 
            if ($_SESSION['membre']['statut'] == 1) {
                $statut = 'membre';
            } else {
                $statut = 'administrateur';
            }
            ?>
<!-- AFFICHAGE DES INFO DU MEMBRE CONNECTE -->
            <h2 class="seaGreen text-center">Bonjour <?php echo ucfirst($_SESSION['membre']['nom']) . ' ' . ucfirst($_SESSION['membre']['prenom']); ?><br> Voici vos info : </h2>

            <ul class="list-group rounded-3">
                <li class="list-group-item p-3"><b>N° utilisateur: </b><?php echo $_SESSION['membre']['id_membre']; ?></li>
                <li class="list-group-item p-3"><b><span class="seaGreen">Pseudo : </span></b><?= $_SESSION['membre']['pseudo']; ?></li>
                <!-- la balise au dessus avec le  signe = provoque un affichage. Dans cette balise, le echo est inclu -->
                <li class="list-group-item p-3"><b><span class="seaGreen">Nom : </span></b><?php echo $_SESSION['membre']['nom']; ?></li>
                <li class="list-group-item p-3"><b><span class="seaGreen">Prénom : </span></b><?php echo $_SESSION['membre']['prenom']; ?></li>
                <li class="list-group-item p-3"><b><span class="seaGreen">Email : </span></b><?php echo $_SESSION['membre']['email']; ?></li>
                <li class="list-group-item p-3"><b><span class="seaGreen">Téléphone : </span></b><?php echo $_SESSION['membre']['tel']; ?></li>
            </ul>
        </div>

    </div>


    <div class="row gx-5 justify-content-center mb-5">
        <div class="col-1 ">
            <button type="button" class=" btn btn-warning text-white" id="modifprofil"><i class="far fa-edit text-white"></i>Modifier</button>
        </div>
        <div class="col-1 ">
            <a href="?action=supprimer&id_membre='<?php $_SESSION['membre']['id_membre'] ?> '" class="btn btn-danger" ><i class="far fa-trash-alt text-white"></i>Supprimer</a>
        </div>
    </div>
    
    <form class="row border p-3 bg-grayS shadow p-3 mb-5 rounded hidden" id="formprofil" method="post" action="">
                        <div class="col-sm-6 text-center text-white">
                        <div class="mb-3">
                                <input type="text" class="form-control rounded-pill" id="id_membre" name="id_membre" value="<?php echo $_SESSION['membre']['id_membre']; ?>" hidden>
                            </div>

                            <div class="mb-3">
                                <label for="nom" class="form-label"><i class="fas fa-user-alt seaGreen"></i> Nom</label>
                                <input type="text" class="form-control rounded-pill" id="nom" name="nom" value="<?php echo $_SESSION['membre']['nom']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label"><i class="seaGreen fas fa-user-alt"></i> Prénom</label>
                                <input type="text" class="form-control rounded-pill" id="prenom" name="prenom" value="<?php echo $_SESSION['membre']['prenom']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 text-center text-white">
                            <div class="mb-3">
                                        <div class="mb-3">
                                            <label for="email" class="form-label"><i class="far fa-envelope-open seaGreen"></i> Email</label>
                                            <input type="email" class="form-control rounded-pill" id="email" name="email" value="<?php echo $_SESSION['membre']['email']; ?>">
                                        </div>                            
                                <label for="civilite" class="form-label"><i class="seaGreen fas fa-user-alt"></i> Civilité</label>
                                <select class="form-control rounded-pill" id="civilite" name="civilite">
                                    <option value="m">homme</option>
                                    <option value="f" <?php if( $civilite == 'f' ) { echo 'selected'; } ?> >femme</option>
                                </select>
                            </div>
                            <div class="mb-3 me-2">
                                <label for="tel" class="form-label"><i class="seaGreen fas fa-phone"></i> Téléphone</label>
                                <input type="text" class="form-control rounded-pill" id="tel" name="tel" value="<?php echo $_SESSION['membre']['tel'];  ?>">
                            </div>
                            <div class="mb-3 mt-4 ms-2">
                                <button type="submit" class="btn btn-outline bg-seaGreen w-50" id="enregistrerModiProfil" >Enregistrer</button>
                            </div>
                          
                        </div>
                    </form>
                    <!-- Affichage des commentaires si il y en a-->
                    <?php      if ($liste_commentaires->rowCount() > 0) {?>
                    <div class="p-5 mt-5 rounded text-center shadow-lg border border-seaGreen">
                <h2 class="seaGreen"> On vous contacte </h2>               
                </div>
                    <div class="col-12 mt-5 rounded p-3">
                    <table class="table bg-light table-bordered border-grayS text-center rounded">
                    <thead class="seaGreen bg-light">
                        <tr>
                        
                            <th>titre annonce</th>
                            <th>commentaire</th>
                            <th>date </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                         while(($titreannonce = $info_annonce->fetch(PDO::FETCH_ASSOC)) && ($commentaire = $liste_commentaires->fetch(PDO::FETCH_ASSOC))){
                                 echo '<tr><td>'.$titreannonce['titre'] .'</td><td>'.$commentaire['commentaire'] .'</td>
                                 <td>'.$commentaire['date_enregistrement'].'</td></tr>' ;
                              
                     }
      

                    ?>  
                    </tbody>
                    </table>
                </div>
                <?php   }      ?>
        <!-- Les annonces du membre connecte si il y en a-->
        <?php      if ($liste_annonces->rowCount() > 0) {?>
                <div class="p-5 mt-5 rounded text-center shadow-lg border border-seaGreen">
                <h2 class="seaGreen"> Vos annonces </h2>               
                </div>
                <div class="col-12 mt-5   rounded p-3">
                    <table class="table bg-light table-bordered border-grayS text-center rounded">
                    <thead class="seaGreen">
                        <tr>
                            <th>id</th>
                            <th>Titre</th>
                            <th>description courte</th>
                            <th>prix</th>
                            <th>photos</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php
                         while($annonce = $liste_annonces->fetch(PDO::FETCH_ASSOC)){
                                 echo '<tr>';
                                foreach($annonce AS $indice => $valeur) {
                                    if($indice == 'photo') {
                                        echo'<td><img src="' . URL . 'assets/img_annonce/' . $valeur . '" width="70" class="img_fluid" alt="image produit">';
                                    }else{
                                        echo '<td>' . $valeur . '</td>';
                                    }
                                }
                     }

                    ?> 
                    </tbody>
                    </table>
                </div>
                <?php   }      ?>

</main>
<script src="<?php echo URL; ?>assets/js/script_profil.js"></script>
<?php
include 'inc/footer.inc.php';
