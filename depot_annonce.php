<?php 
include 'inc/init.inc.php';
include 'inc/functions.inc.php';


//******************************************************* 
// CONNECTION REQUISE POUR ACCES A LA PAGE
if( user_is_connected() == false ) {
    header('location:../connexion.php');
}

//****************************************************** 
// RECUPERATION DES VARIABLES POUR EVITER LES ERREURS DANS LE FORMULAIRE
$id_annonce = "";
$titre = '';
$description_courte = '';
$description_longue = '';
$prix = '';
$categorie = '';
$photo1 = '';
$photo2 = '';
$photo3 = '';
$photo4 = '';
$photo5 = '';
$pays = '';
$ville = '';
$adresse = '';
$cp ='';


//*******************************************
// RECUPERATION DES CATEGORIES

$recup_categorie = $pdo->query('SELECT * FROM categorie ORDER BY titre');


//**************************************************************************************************** */
// ------------------ POUR MODIFICATION ------------------------
if(isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id_annonce'])){
    // Pour la modification d'un annonce il faut proposer à l'utilisateur les données déjà enregistrées afin qu'il ne change que la ou les valeurs qu'il souhaite
    // Une requete pour récupérer les infos de cette annonce, un fetch et on affiche dasn le form via les variables déjà en place dans le form
    
    $modification = $pdo->prepare('SELECT * FROM annonce WHERE id_annonce = :id_annonce');
    $modification->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);
    $modification->execute();
  
    $infos_annonce = $modification->fetch(PDO::FETCH_ASSOC);
    $id_annonce = $infos_annonce['id_annonce'];
    $titre = $infos_annonce['titre'];
    $description_courte = $infos_annonce['description_courte'];
    $description_longue = $infos_annonce['description_longue'];
    $prix = $infos_annonce['prix'];
    $photo = $infos_annonce['photo'];
    $pays = $infos_annonce['pays'];
    $ville = $infos_annonce['ville'];
    $adresse = $infos_annonce['adresse'];
    $cp = $infos_annonce['cp'];
    $membre = $infos_annonce['membre_id'];
    $categorie = $infos_annonce['categorie_id'];
  
        // // On vérifie si l'id_membre existe et n'est pas vide : si c'est le cas, on est en modification
        // if(isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id_annonce']) ) {

            
        //     // On lance lA MODIFICATION
        // $id_annonce_recup = $_GET['id_annonce'];
         
        // $verif_id_annonce = $pdo->query("SELECT * FROM annonce WHERE id_annonce = $id_annonce ");
    

        //     // Récuperation des infos pour les afficher dans le formulaire pour modification
        // $modif_annonce = $verif_id_annonce->fetch(PDO::FETCH_ASSOC);
        // $id_annonce = $modif_annonce['id_annonce'];
        // $titre = $modif_annonce['titre'];
        // $description_courte = $modif_annonce['description_courte'];
        // $description_longue = $modif_annonce['description_longue'];
        // $prix = $modif_annonce['prix'];
        // $categorie = $modif_annonce['categorie_id'];
        // $photo1 = $modif_annonce['photo'];
        // $pays = $modif_annonce['pays'];
        // $ville = $modif_annonce['ville'];
        // $adresse = $modif_annonce['adresse'];
        // $cp =$modif_annonce['cp'];
      

        // Il ne faut pas vérifier si la référence  existe dans le cadre d'une modif, donc on rajoute un controle sur id_membre qui doit être vide. Car en cas d'insert, l'id_membre sera vide, en revanche sur une  modif il n'est pas vide.
        if( $verif_id_membre->rowCount()>= 1) {
          
            $enregistrement = $pdo->prepare("UPDATE annonce SET  titre = :titre, description_courte = :description_courte, description_longue = :description_longue, prix = :prix, photo = :photo, ville = :ville, adresse = :adresse, cp = :cp, membre_id = :membre_id, photo_id= :photo_id, categorie_id= :categorie_id WHERE id_annonce = :id_annonce");
        
            $enregistrement_annonce->bindParam(':titre', $titre, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':description_courte', $description_courte, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':description_longue', $description_longue, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':prix', $prix, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':photo', $photo1, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':pays', $pays, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':ville', $ville, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':cp', $cp, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':membre_id', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':photo_id', $id_photo, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':categorie_id', $_POST['categorie'] , PDO::PARAM_STR);
            $enregistrement_annonce->execute();

            echo "<script type='text/javascript'>alert('Votre annonce a bien été modifiée. Vous allez être redirigé Vers la page d'accueil');document.location.href = 'index.php';
            </script>";
                
        }
    }
        //    FIN DE MODIFICATION  *************************************
        // ____________________________________________________________

/// ______________________________________________________________________
// ENGEGISTREMENT D'UNE NOUVELLE ANNONCE
//*******************************************
// CHECKING DES ISSET DU FORMULAIRE
if(isset($_POST['titre']) &&
   isset($_POST['description_courte']) &&
   isset($_POST['description_longue']) &&
   isset($_POST['prix']) &&
   isset($_POST['categorie']) &&
   isset($_POST['pays']) &&
   isset($_POST['ville']) &&
   isset($_POST['adresse']) &&
   isset($_POST['cp'])) { 


//RECUPERATION DES POST 
    $titre = trim($_POST['titre']);
    $description_courte = trim($_POST['description_courte']);
    $description_longue = trim($_POST['description_longue']);
    $prix = trim($_POST['prix']);
    $categorie = $_POST['categorie'];
    $pays = trim($_POST['pays']);
    $ville = trim($_POST['ville']);
    $adresse = trim($_POST['adresse']);
    $cp = trim($_POST['cp']);
    // SI ERREUR
    $erreur = false;
     // CONTROLE DU PRIX
    if(!is_numeric($prix)) {
        $prix = 0;
        $msg .= '<div class="alert alert-warning" role="alert"> Cet article n\'ayant pas un prix, le prix a été mis à zéro.</div>';
    }
   // CONTROLE DES PHOTO

    if( !empty($_FILES['photo1']['name']) ) {
        // controle de l'extension du fichier
        $tab_extension = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        // on découpe la  chaine depuis la fin pour récupérer ce qui se trouve après le dernier "."
            $extension1 = pathinfo($_FILES['photo1']['name'], PATHINFO_EXTENSION);
            $extension2 = pathinfo($_FILES['photo2']['name'], PATHINFO_EXTENSION);
            $extension3 = pathinfo($_FILES['photo3']['name'], PATHINFO_EXTENSION);
            $extension4 = pathinfo($_FILES['photo4']['name'], PATHINFO_EXTENSION);
            $extension5 = pathinfo($_FILES['photo5']['name'], PATHINFO_EXTENSION);

   // CREATION DE NOM UNIQUE POUR LES PHOTO
        //  POUR CELA ON CREE UN NOMBRE ALEATOIRE AVEC LE RANDOM
        if(!empty($_FILES['photo1']['name'])){
            $random = random_int(1, 1000);
            $photo1 = $random . '-' . $_FILES['photo1']['name'];
        }

        

       
        
            
           
        // VERIFICATION DES EXTENSION DES PHOTO
        // in_array() 
        //photo1
        if( in_array($extension1, $tab_extension) ) {
            // On enlève les espaces et on les remplace par un -  dans le noms des images : 
            $photo1 = str_replace(' ', '-', $photo1);
            // REGEX of replacement caracter
            $photo1 = preg_replace('/[^A-Za-z0-9.\-]/', '', $photo1);
            // copy() // ON ENVOI LES PHOTO DANS LE DOSSIER img_annonce
            copy($_FILES['photo1']['tmp_name'], ROOT_PATH . PROJECT_PATH . 'assets/img_annonce/' . $photo1);
        } else {
            // CAS D'ERREUR
            $erreur = true;
            $msg .= '<div class="alert alert-warning" role="alert">Format de l\'image invalide, formats acceptés : jpg / jpeg / png / gif / webp.</div>';
        }
        //photo2
        if(!empty($_FILES['photo2']['name'])) {
                $random = random_int(1, 1000);
                $photo2 = $random . '-' . $_FILES['photo2']['name'];

            if( in_array($extension2, $tab_extension) ) {
            
            $photo2 = str_replace(' ', '-', $photo2);
            $photo2 = preg_replace('/[^A-Za-z0-9.\-]/', '', $photo2);
            copy($_FILES['photo2']['tmp_name'], ROOT_PATH . PROJECT_PATH . 'assets/img_annonce/' . $photo2);
            } else {
            $erreur = true;
            $msg .= '<div class="alert alert-warning" role="alert">Format de l\'image invalide, formats acceptés : jpg / jpeg / png / gif / webp.</div>';
            }
        }
        //photo3
        if(!empty($_FILES['photo3']['name'])) {
            
                $random = random_int(1, 1000);
                $photo3 = $random . '-' . $_FILES['photo3']['name'];
            
            if( in_array($extension3, $tab_extension) ) {
            $photo3 = str_replace(' ', '-', $photo3);
            $photo3 = preg_replace('/[^A-Za-z0-9.\-]/', '', $photo3);
            copy($_FILES['photo3']['tmp_name'], ROOT_PATH . PROJECT_PATH . 'assets/img_annonce/' . $photo3);
            } else {
            $erreur = true;
            $msg .= '<div class="alert alert-warning" role="alert">Format de l\'image invalide, formats acceptés : jpg / jpeg / png / gif / webp.</div>';
            }
        }
        //photo4
        if(!empty($_FILES['photo4']['name'])) {
            
                $random = random_int(1, 1000);
                $photo4 = $random . '-' . $_FILES['photo4']['name'];
            
            if( in_array($extension4, $tab_extension) ) {
            $photo4 = str_replace(' ', '-', $photo4);
            $photo4 = preg_replace('/[^A-Za-z0-9.\-]/', '', $photo4);
            copy($_FILES['photo4']['tmp_name'], ROOT_PATH . PROJECT_PATH . 'assets/img_annonce/' . $photo4);
            } else {
            $erreur = true;
            $msg .= '<div class="alert alert-warning" role="alert">Format de l\'image invalide, formats acceptés : jpg / jpeg / png / gif / webp.</div>';
            }
        }
        //photo5
        if(!empty($_FILES['photo5']['name'])) {
            
                $random = random_int(1, 1000);
                $photo5 = $random . '-' . $_FILES['photo5']['name'];
            
            if( in_array($extension5, $tab_extension) ) {
            $photo5 = str_replace(' ', '-', $photo5);
            $photo5 = preg_replace('/[^A-Za-z0-9.\-]/', '', $photo5);
            copy($_FILES['photo5']['tmp_name'], ROOT_PATH . PROJECT_PATH . 'assets/img_annonce/' . $photo5);
            } else {
            $erreur = true;
            $msg .= '<div class="alert alert-warning" role="alert">Format de l\'image invalide, formats acceptés : jpg / jpeg / png / gif / webp.</div>';
            }
        }
        // ENREGISTREMENT DES PHOTO DANS LA TABLE PHOTO SI TOUT EST OK
        if( $erreur == false ) {
            $enregistrement_photo = $pdo->prepare('INSERT INTO photo (id_photo, photo1, photo2, photo3, photo4, photo5) VALUES(NULL, :photo1, :photo2, :photo3, :photo4, :photo5)');
            $enregistrement_photo->bindParam(':photo1', $photo1, PDO::PARAM_STR);
            $enregistrement_photo->bindParam(':photo2', $photo2, PDO::PARAM_STR);
            $enregistrement_photo->bindParam(':photo3', $photo3, PDO::PARAM_STR);
            $enregistrement_photo->bindParam(':photo4', $photo4, PDO::PARAM_STR);
            $enregistrement_photo->bindParam(':photo5', $photo5, PDO::PARAM_STR);
            $enregistrement_photo->execute();
            $id_photo = $pdo->lastInsertId();
                
                // PUIS ENREGISTREMENT DES INFO DANS LA TABLE ANNONCE

            $recup_categorie_id = $recup_categorie->fetch(PDO::FETCH_ASSOC);
            $id_categorie = $recup_categorie_id['id_categorie'];
            $enregistrement_annonce = $pdo->prepare("INSERT INTO annonce (titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement) VALUES (:titre, :description_courte, :description_longue, :prix, :photo, :pays, :ville, :adresse, :cp, :membre_id, :photo_id, :categorie_id, NOW())");
            $enregistrement_annonce->bindParam(':titre', $titre, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':description_courte', $description_courte, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':description_longue', $description_longue, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':prix', $prix, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':photo', $photo1, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':pays', $pays, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':ville', $ville, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':cp', $cp, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':membre_id', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':photo_id', $id_photo, PDO::PARAM_STR);
            $enregistrement_annonce->bindParam(':categorie_id', $_POST['categorie'] , PDO::PARAM_STR);
            $enregistrement_annonce->execute();
            
            header('location:depot_annonce.php');

                    
        }

        }
} 
    


//-------------SUPPRESSION ANNONCE------------


if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_annonce']) ) {
   // si l'indice action existe dans $_GET et si sa valeur est égal à supprimmer && et si id_annonce existe et n'est pas vide dans $_GET
    // Requete delete basée sur l'id_annonce pour supprimer l'annonce  en question.
    $select_annonce = $pdo->prepare("SELECT * FROM annonce WHERE id_annonce = :id_annonce");
    $select_annonce->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);
    $select_annonce->execute();
    $annonce_suppr = $select_annonce->fetch(PDO::FETCH_ASSOC);
    $id_photo_supp = $annonce_suppr['photo_id'];


    $suppression = $pdo->prepare("DELETE FROM annonce WHERE id_annonce = :id_annonce");// preparer la requete
    $suppression->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);// selectionner la cible de la requete


    $suppression_id_photo = $pdo->prepare("DELETE FROM photo WHERE id_photo = :photo_id");
    $suppression_id_photo->bindParam(':photo_id',$id_photo_supp, PDO::PARAM_STR);
    $suppression_id_photo->execute();
    $suppression->execute(); // executer la requete
    
}

// RECUPERATION DU MEMBRE CONNECTE
$membre_id = $_SESSION['membre']['id_membre'];

// RECUPERATION DES ANNONCES DU MEMBRE CONNECTE
$liste_annonces = $pdo->query("SELECT id_annonce, titre, description_courte, prix, photo FROM annonce WHERE membre_id = $membre_id ORDER BY  titre");

include 'inc/header.inc.php'; 
 include 'inc/nav.inc.php';
?>
        <main class="container">
            <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
                <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Déposez votre annonce <i class="fas fa-bahai seaGreen"></i></h1>
                <p class="lead seaGreen ">Bienvenue sur notre site.<hr><?php echo $msg; ?></p>                
            </div>
<!-- FORMULAIRE AJOUT ANNONCE -->
                <form class="row border p-3 bg-grayS shadow p-3 mb-5 rounded" method="post" action="" enctype="multipart/form-data">
                        <div class="col-sm-6 text-center text-white">
                        <div class="mb-3">
                                <input type="text" class="form-control rounded-pill" id="id_annonce" name="titre" value="<?php echo $id_annnonce; ?>" hidden>
                            </div>
                            <div class="mb-3">
                                <label for="titre" class="form-label"><i class="fas fa-pencil-alt seaGreen"></i> Titre</label>
                                <input type="text" class="form-control rounded-pill" id="titre" name="titre" value="<?php echo $titre; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="description_courte" class="form-label"><i class="fas fa-pencil-alt seaGreen"></i> Description courte</label>
                                <textarea class="form-control rounded-pill" id="description_courte" name="description_courte"> <?php echo $description_courte; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="description_longue" class="form-label"><i class="fas fa-pencil-alt seaGreen"></i> Description longue</label>
                                <textarea class="form-control rounded-pill" id="description_longue" name="description_longue"><?php echo $description_longue; ?></textarea>
                            </div> 
                            <div class="mb-3">
                                <label for="prix" class="form-label"><i class="fas fa-euro-sign seaGreen"></i> Prix</label>
                                <input type="text" class="form-control rounded-pill" id="prix" name="prix" value="<?php echo $prix; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="categorie" class="form-label"><i class=" seaGreen fas fa-list-ul"></i> Catégorie</label>
                                <select class="form-control rounded-pill" id="categorie" name="categorie">
                                <?php while($categorie =$recup_categorie->fetch(PDO::FETCH_ASSOC)){ ?>
                                 
                                    <option value="<?php echo $categorie['id_categorie'] ?>"> <?php echo $categorie['titre'] ?> </option>
                                 
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 text-center text-white">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="photo1" class="form-label"><i class="far fa-image seaGreen"></i> Photo 1</label>
                                        <input type="file" class="form-control" id="photo1" name="photo1" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="photo2" class="form-label"><i class="far fa-image seaGreen"></i> Photo 2</label>
                                        <input type="file" class="form-control" id="photo2" name="photo2" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="photo3" class="form-label"><i class="far fa-image seaGreen"></i> Photo 3</label>
                                        <input type="file" class="form-control" id="photo3" name="photo3" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="photo4" class="form-label"><i class="far fa-image seaGreen"></i> Photo 4</label>
                                        <input type="file" class="form-control" id="photo4" name="photo4" >
                                    </div>
                                </div>
                                <div class="col-6 mx-auto">
                                    <div class="mb-3">
                                        <label for="photo5" class="form-label"><i class="far fa-image seaGreen"></i> Photo 5</label>
                                        <input type="file" class="form-control" id="photo5" name="photo5" >
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="pays" class="form-label"><i class="fas fa-house-user seaGreen"></i> Pays</label>
                                <input type="text" class="form-control rounded-pill" id="pays" name="pays" value="<?php echo $pays; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="adresse" class="form-label"><i class="fas fa-house-user seaGreen"></i> Adresse</label>
                                <input type="text" class="form-control rounded-pill" id="adresse" name="adresse" value="<?php echo $adresse; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="cp" class="form-label"><i class="fas fa-house-user seaGreen"></i> Code postal</label>
                                <input type="text" class="form-control rounded-pill" id="cp" name="cp" value="<?php echo $cp; ?>">
                            </div>
                            <div style="display :none; color:#f55;" id="error-message"></div>
                                            <div class="mb-3">
                                                <label for="ville" class="form-label"><i class="fas fa-house-user seaGreen"></i> Ville</label>
                                                <select class="form-control rounded-pill" id="ville" name="ville" ></select>
                                            </div>
                        </div>
                   
                      
                            <button type="submit" class="btn btn-outline bg-seaGreen w-25 mx-auto mt-5 text-white" id="validation_annonce" >Valider</button>
                 
                       
                </form>     
<!--  ANNONCES DU MEMBRE CONNECTE SI IL EN A POSTE -->
<?php      if ($liste_annonces->rowCount() > 0) {?>
                <div class="p-5 mt-5 rounded text-center shadow-lg border border-seaGreen">
                <h2 class="seaGreen"> Vos annonces </h2>               
                </div>
                <div class="col-12 mt-5   rounded p-3">
                    <table class="table bg-light table-bordered  text-center rounded">
                    <thead class="seaGreen">
                        <tr>
                            <th>id</th>
                            <th>Titre</th>
                            <th>description courte</th>
                            <th>prix</th>
                            <th>photos</th>
                            <th>Modif</th>
                            <th>Suppr</th>
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

                                // Rajout de deux liens pour les actions : modifier, supprimer
                                echo '<td><a href="?action=modifier&id_article=' . $annonce['id_annonce'] . '" class="btn btn-primary"><i class="far fa-edit"></i></a></td>';
                                echo '<td><a href="?action=supprimer&id_annonce=' . $annonce['id_annonce'] . '" class="btn btn-danger" onclick="return (confirm(\'êtes vous sûr ?\'))"><i class="far fa-trash-alt"></i></a></td>';
                                echo '</tr>';
                     }

                    ?> 
                    </tbody>
                    </table>
                </div>
            </div>
                    <?php } ?>
            
                    
        </main>

<?php 
include 'inc/footer.inc.php';



