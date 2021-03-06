<?php 
include '../inc/init.inc.php';
include '../inc/functions.inc.php';

// ------ VALID USER : ADMIN------------
//--------------------------------------
//--------------------------------------
if( user_is_admin() == false ) {
    header('location:../connexion.php');
    }

//--------------------------------------
//--------------------------------------
//--------------------------------------
//-------------DELETE CATEGORE------------
//--------------------------------------
//--------------------------------------

if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_categorie']) ) {
// si l'indice action existe dans $_GET et si sa valeur est égal à supprimmer && et si id_article existe et n'est pas vide dans $_GET
// Requete delete basée sur l'id_article pour supprimer l'article  en question.
$suppression = $pdo->prepare("DELETE FROM categorie WHERE id_categorie = :id_categorie");// preparer la requete
$suppression->bindParam(':id_categorie', $_GET['id_categorie'], PDO::PARAM_STR);// selectionner la cible de la requete
$suppression->execute(); // executer la requete 
}
//--------------------------------------
//--------------END DELETE CATEGORIE-------
//--------------------------------------    

$titre = '';
$motcles = '';
$id_categorie='';


//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//MODIFICATION D UNE CATEGORIE
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------


if( isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id_categorie']) ){
// pour la modification d'une catégorie il faut proposer  des données déjà enregistrées afin qu'il ne change que la valeur concernée
// une requete pour récupérer les informations de cette categorie, un fetch et un affichage dans la form via les variables déjà en place dans le form
$modification = $pdo->prepare("SELECT * FROM categorie WHERE id_categorie = :id_categorie");
$modification->bindParam(':id_categorie', $_GET['id_categorie'], PDO::PARAM_STR);
$modification->execute();

$infos_categorie = $modification->fetch(PDO::FETCH_ASSOC);

$titre = $infos_categorie['titre'];
$motcles = $infos_categorie['motcles'];
$id_categorie = $infos_categorie['id_categorie'];

}
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
// FIN MODIFICATION ARTICLE
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
// ENREGISTREMENT & MODIFICATION ARTICLE
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------

// on vérifie l'existence des éléments dans POST
if ( isset($_POST['titre']) &&
    isset($_POST['motcles']) 
){


    $titre = trim($_POST['titre']);
    $motcles = trim($_POST['motcles']);

    $erreur = false;

// POUR MODIFICATION
// On vérifie si l'id_categorie existe et n'est pas vide si c'est le cas on est en modification
if( !empty($_POST['id_categorie']) ) {
    $id_categorie = trim($_POST['id_categorie']);
}




$erreur = false;
// CONTROLE----------------------------------------------------------

// TITRE
if( iconv_strlen($titre) < 4 || iconv_strlen($titre) > 14) {
$erreur = true;
$msg .= '<div class="alert alert-danger mb-3">Attention,<br>Le nom de la  catégorie doit contenir entre 4 et 14 caractères merci.</div>';
}
$verif_caractere = preg_match('#^[a-zA-Z0-9._-]+$#', $titre);
    
if($verif_caractere == false) {
// cas d'erreur
$erreur = true;
$msg .= '<div class="alert alert-danger mb-3">Attention,<br>Caractère autorisé pour le titre : a-z 0-9 ._- </div>';
}

  // - disponibilité du nom de catégorie 
  $verif_titre = $pdo->prepare("SELECT * FROM categorie WHERE titre = :titre");
  $verif_titre->bindParam(':titre' , $titre, PDO::PARAM_STR);
  $verif_titre->execute();
  if( $verif_titre->rowCount() > 0 && empty($id_categorie)) {
      $erreur = true;
      $msg .= '<div class="alert alert-danger mb-3">Attention,<br>Ce titre est déjà pris</div>';

  } 
  //enregistrement de la BDD 
    if($erreur == false){
        

        if(empty($id_categorie)) {
            //si $id_categorie est vide : INSERT
            $enregistrement = $pdo->prepare("INSERT INTO categorie (titre, motcles) VALUES (:titre, :motcles)");

    }else{
        // SINON UPDATE
        $enregistrement = $pdo->prepare("UPDATE categorie SET  titre = :titre, motcles = :motcles WHERE id_categorie = :id_categorie");
        $enregistrement->bindParam(':id_categorie', $id_categorie, PDO::PARAM_STR);
        header('location:gestion_categories.php');
    }

    $enregistrement->bindParam(':titre', $titre, PDO::PARAM_STR);
    $enregistrement->bindParam(':motcles', $motcles, PDO::PARAM_STR);
    $enregistrement->execute();

    $msg .= '<div class="alert alert-success text-center mb-3">Catégorie ajoutée</div>';
    // Pour éviter de renvoyer les données lors du rechargement de page, on envoie sur gestion_categorie
    header('location:gestion_categories.php');
    }


}


//------RECUPERATION CATEGORIE-------------
//--------------------------------------
//--------------------------------------
$liste_categorie = $pdo->query("SELECT * FROM categorie ORDER BY  titre");
//--------------------------------------
//--------------------------------------
//--------------------------------------

//

   





include '../inc/header.admin.inc.php'; 
include '../inc/nav.inc.php';
?>
        <main class="container">
            <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
                <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Gestion des catégories <i class="fas fa-bahai seaGreen"></i></h1>
                <p class="lead seaGreen ">Bienvenue<hr><?php echo $msg; ?></p>                
            </div>
            <form class="row border rounded  bg-dark text-light mx-auto " method="post" action="">
                    <div class="col-12 text-center">
                        <div class="mb-3 mt-3">
                        <h3 class="seaGreen">Ajout d'une catégorie</h3>
                        </div>
                        <div class="mb-3">
                     
                             <!-- Ajout d'un champ caché contenant l'id_article pour la modification ! -->
                             <input type="hidden" readonly id="id_categorie" name="id_categorie" value="<?php echo $id_categorie; ?>">
                            <label for="titre" class="form-label text-light"><i class="seaGreen fas fa-user-alt"></i> Titre </label>
                            <input type="text" class="form-control w-50 mx-auto" id="titre" name="titre" value="<?php echo $titre; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="motcles" class="form-label text-light"><i class="seaGreen fas fa-user-alt"></i> Mots-clés </label>
                            <textarea  class="form-control w-50 mx-auto" id="motscles" name="motcles"><?php echo $motcles; ?></textarea>
                        </div>
                        <div class="mb-3 ">
                            <button type="submit" class="btn bg-seaGreen" id="ajout" >Ajouter</button>
                        </div>

                    </div>
                </form>
        
            <br>
            <br>
            <br>
     <div class="row"> 
                    <table class="table border rounded text-center bg-secondary">
                    <thead  class="text-white border">
                        <tr>
                            <th>id</th>
                            <th>Titre</th>
                            <th>Mots clé</th>
                            <th>Supprimer</th>
                            <th>Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            
                        while($categorie= $liste_categorie->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr>
                                <td>'. $categorie['id_categorie'] . '</td>
                                <td>'. $categorie['titre'] . '</td>
                                <td>'.$categorie['motcles'].'</td>
                                <td><a href="?action=s       upprimer&id_categorie=' . $categorie['id_categorie'] . '" class="btn btn-danger" onclick="return (confirm(\'êtes vous sûr ?\'))"><i class="far fa-trash-alt"></i></a></td>
                                <td><a href="?action=modifier&id_categorie=' . $categorie['id_categorie'] . '" class="btn btn-warning"><i class="far fa-edit text-white"></i></a></td>
                                </tr>';

                                
                               
                                }

                        

                    ?>
                    </tbody>
                    </table>
       


                </div>
            </div>
        </main>

<?php 
include '../inc/footer.inc.php';
 