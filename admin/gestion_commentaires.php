<?php 
include '../inc/init.inc.php';
include '../inc/functions.inc.php';


// Si l'utilisateur n'est pas admin on redirige vers connexion.php
if( user_is_admin() == false ) {
    header('location:../connexion.php');
    }

// Recuperation des commentaires 

 $liste_commentaires = $pdo->query("SELECT * FROM commentaire ORDER BY id_commentaire");

// Supprimer un commentaire

if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_commentaire']) ) {
    // si l'indice action existe dans $_GET et si sa valeur est égal à supprimmer && et si id_commentaire existe et n'est pas vide dans $_GET
    // Requete delete basée sur l'id_article pour supprimer le commentaire en question.
    $suppression = $pdo->prepare("DELETE FROM commentaire WHERE id_commentaire = :id_commentaire");// preparer la requete
    $suppression->bindParam(':id_commentaire', $_GET['id_commentaire'], PDO::PARAM_STR);// selectionner la cible de la requete
    $suppression->execute(); // executer la requete 
    }

include '../inc/header.admin.inc.php'; 
include '../inc/nav.inc.php';
?>
        <main class="container">
            <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
                <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Gestion des commentaires <i class="fas fa-bahai seaGreen"></i></h1>
                <p class="lead seaGreen ">Bienvenue<hr><?php echo $msg; ?></p>                
            </div>

            <div class="row">
                <div class="col-12 mt-5">
                <table class="table border rounded text-center bg-secondary">
                    <thead  class="star sw text-white  border  border">
                        <tr>
                            <th>Id commentaire</th>
                            <th>Id membre commentant</th>
                            <th>Id annonce</th>
                            <th>Commentaire</th>
                            <th>Membre commenté</th>
                            <th>Date d'enregistrement</th>
                            <th>Réponse du membre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            
                        while($commentaire = $liste_commentaires->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr>
                                <td>'. $commentaire['id_commentaire'] . '</td>
                                <td>'. $commentaire['membre_id'] . '</td>
                                <td>'.$commentaire['annonce_id'].'</td>
                                <td>'.$commentaire['commentaire'].'</td>
                                <td>'.$commentaire['membre_id_2'].'</td>
                                <td>'.$commentaire['date_enregistrement'].'</td>
                                <td>'.$commentaire['reponse'].'</td>
                                <td><a href="?action=supprimer&id_commentaire=' . $commentaire['id_commentaire'] . '" class="btn btn-danger" onclick="return (confirm(\'êtes vous sûr ?\'))"><i class="far fa-trash-alt"></i></a></td>
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
