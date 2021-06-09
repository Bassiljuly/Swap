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

//-------------DELETE MEMBER------------
//--------------------------------------
//--------------------------------------

if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_annonce']) ) {
    // si l'indice action existe dans $_GET et si sa valeur est égal à supprimmer && et si id_article existe et n'est pas vide dans $_GET
    // Requete delete basée sur l'id_article pour supprimer l'article  en question.
    $suppression = $pdo->prepare("DELETE FROM annonce WHERE id_annonce = :id_annonce");// preparer la requete
    $suppression->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);// selectionner la cible de la requete
    $suppression->execute(); // executer la requete 
}
//--------------------------------------
//--------------------------------------
//--------------------------------------

//------RECUPERATION MEMBRE-------------
//--------------------------------------
//--------------------------------------
$liste_categorie = $pdo->query("SELECT * FROM annonce ORDER BY  titre");
//--------------------------------------
//--------------------------------------
//--------------------------------------




include '../inc/header.admin.inc.php'; 
include '../inc/nav.inc.php';
?>
        <main class="container">
            <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
                <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Gestion des annonces <i class="fas fa-bahai seaGreen"></i></h1>
                <p class="lead seaGreen ">Bienvenue<hr><?php echo $msg; ?></p>                
            </div>
            <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
                <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Gestion des catégories <i class="fas fa-bahai seaGreen"></i></h1>
                <p class="lead seaGreen ">Bienvenue<hr><?php echo $msg; ?></p>                
            </div>
        
            <br>
            <br>
            <br>
            <div class="row"> 
                    <table class="table border rounded text-center bg-secondary">
                    <thead  class="star sw text-white  border  border">
                        <tr>
                            <th>id</th>
                            <th>Titre</th>
                            <th>Description longue</th>
                            <th>Description courte</th>
                            <th>Prix</th>
                            <th>Photo</th>
                            <th>Pays</th>
                            <th>Ville</th>
                            <th>Adresse</th>
                            <th>CP</th>
                            <th>Membre</th>
                            <th>Catégorie</th>
                            <th>Date enregistrement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            
                        while($annonce= $liste_annonce->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr>
                                <td>'. $annonce['id_categorie'] . '</td>
                                <td>'. $annonce['titre'] . '</td>
                                <td>'.$annonce['description_longue'].'</td>
                                <td>'.$annonce['description_courte'].'</td>
                                <td>'.$annonce['prix'].'</td>
                                <td>'.$annonce['photo'].'</td>
                                <td>'.$annonce['pays'].'</td>
                                <td>'.$annonce['ville'].'</td>
                                <td>'.$annonce['adresse'].'</td>
                                <td>'.$annonce['cp'].'</td>
                                <td>'.$annonce['membre_id'].'</td>';
                                while($categorie = $liste_categorie->)

                                <td>'.$categorie['titre'].'</td>
                                <td>'.$annonce['date_enregistrement'].'</td>
                                <td><a href="?action=supprimer&id_categorie=' . $categorie['id_categorie'] . '" class="btn btn-danger" onclick="return (confirm(\'êtes vous sûr ?\'))"><i class="far fa-trash-alt"></i></a>
                                <a href="?action=modifier&id_categorie=' . $categorie['id_categorie'] . '" class="btn btn-warning"><i class="far fa-edit text-white"></i></a></td>
                                </tr>';

                                
                               
                                }

                        

                    ?>
                    </tbody>
                    </table>
       


                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-5">
                    
                </div>
            </div>
        </main>

<?php 
include '../inc/footer.inc.php';
 