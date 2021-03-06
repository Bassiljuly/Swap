<?php 
include '../inc/init.inc.php';
include '../inc/functions.inc.php';



// ------ SI L'UTILISATEUR EST ADMIN ------------

if( user_is_admin() == false ) {
    header('location:../connexion.php');
    }

//-----------SUPPRIMER UN MEMBRE------------


if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_membre']) ) {
    // si l'indice action existe dans $_GET et si sa valeur est égal à supprimmer && et si id_article existe et n'est pas vide dans $_GET
    // Requete delete basée sur l'id_article pour supprimer l'article  en question.
    $suppression = $pdo->prepare("DELETE FROM membre WHERE id_membre = :id_membre");// preparer la requete
    $suppression->bindParam(':id_membre', $_GET['id_membre'], PDO::PARAM_STR);// selectionner la cible de la requete
    $suppression->execute(); // executer la requete 
}


//------RECUPERATION MEMBRE-------------

$liste_membre = $pdo->query("SELECT id_membre, pseudo, nom, prenom, telephone, email, civilite, statut, date_enregistrement FROM membre ORDER BY  nom");
//--------------------------------------




include '../inc/header.admin.inc.php'; 
include '../inc/nav.inc.php';
?>
        <main class="container">
            <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
                <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Gestion des membres <i class="fas fa-bahai seaGreen"></i></h1>
                <p class="lead seaGreen ">Bienvenue<hr><?php echo $msg; ?></p>                
            </div>

            <div class="row">
                <div class="col-12 mt-5">
               
                    <table class="table border-dark rounded text-center bg-white">
                    <thead  class="sw seaGreen border  border-seaGrenn ">
                        <tr>
                            <th>id</th>
                            <th>pseudo</th>
                            <th>nom</th>
                            <th>prenom</th>
                            <th>telephone</th>
                            <th>email</th>
                            <th>civilité</th>
                            <th>statut</th>
                            <th>membre depuis</th>
                            <th>Suppr</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            
                        while($membre = $liste_membre->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr>';
                                

                                foreach($membre AS $indice => $valeur) {
                                    if($indice == 'photo') {
                                        echo'<td><img src="' . URL . 'assets/img_membres/' . $valeur . '" width="70" class="img_fluid" alt="image produit">';
                                    }else{
                                        echo '<td>' . $valeur . '</td>';
                                    }
                                }

                                // Rajout liens pour l'action supprimer
                                echo '<td><a href="?action=supprimer&id_membre=' . $membre['id_membre'] . '" class="btn btn-danger" onclick="return (confirm(\'êtes vous sûr ?\'))"><i class="far fa-trash-alt"></i></a></td>';
                                echo '</tr>';
                               
                        }

                    ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </main>

<?php 
include '../inc/footer.inc.php';
 