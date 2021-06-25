<?php 
include '../inc/init.inc.php';
include '../inc/functions.inc.php';


// Si l'utilisateur n'est pas admin on redirige vers connexion.php
if( user_is_admin() == false ) {
    header('location:../connexion.php');
    }

    // Suppression des notes des notes 
    if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_note']) ) {
        // si l'indice action existe dans $_GET et si sa valeur est égal à supprimmer && et si id_note existe et n'est pas vide dans $_GET
        // Requete delete basée sur l'id_article pour supprimer la note  en question.
        $suppression = $pdo->prepare("DELETE FROM note WHERE id_note = :id_note");// preparer la requete
        $suppression->bindParam(':id_note', $_GET['id_note'], PDO::PARAM_STR);// selectionner la cible de la requete
        $suppression->execute(); // executer la requete 
        }

// Recuperation des info de la table note
$info_notes = $pdo->query("SELECT * FROM note ");

// Recuperation des nom des membres qui notent
$info_membre_1 = $pdo->query("SELECT * FROM membre AS m, note AS n WHERE m.id_membre = n.membre_id1");

// Recuperation de la personne qui a été notée

$info_membre_2 = $pdo->query("SELECT * FROM membre AS m, note AS n WHERE m.id_membre = n.membre_id2");


include '../inc/header.admin.inc.php'; 
include '../inc/nav.inc.php';
?>
        <main class="container">
            <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
                <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Gestion des notes <i class="fas fa-bahai seaGreen"></i></h1>
                <p class="lead seaGreen ">Bienvenue<hr><?php echo $msg; ?></p>                
            </div>

            <div class="row">
                <div class="col-12 mt-5">
                <table class="table border rounded text-center bg-secondary">
                    <thead  class="star sw text-white  border  border">
                        <tr>
                            <th>Id note</th>
                            <th>Membre noté</th>
                            <th>Membre donnant la note</th>
                            <th>Note</th>
                            <th>Avis</th>
                            <th>Date enregistrement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            if ($info_notes->rowCount() > 0) {
                                while ($note = $info_notes->fetch(PDO::FETCH_ASSOC)) {
                                    // definission des etoiles en fonction de la note
                                    if ($note['note'] == 1) {
                                        $noteetoilee =  '<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
                                    } elseif ($note['note'] == 2) {
                                        $noteetoilee = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
                                    } elseif ($note['note'] == 3) {
                                        $noteetoilee = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
                                    } elseif ($note['note'] == 4) {
                                        $noteetoilee = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>';
                                    } elseif ($note['note'] == 5) {
                                        $noteetoilee = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
                                    }
                                  
                                    $membre1 = $info_membre_1->fetch(PDO::FETCH_ASSOC);
                                    $membre2 = $info_membre_2->fetch(PDO::FETCH_ASSOC);

                                echo '<tr>
                                <td>'. $note['id_note'] . '</td>
                                <td>'. $membre1['pseudo'] .'</td>
                                <td>'.$membre2['pseudo'].'</td>
                                <td>'.$noteetoilee.'</td>
                                <td>'.$note['avis'].'</td>
                                <td>'.$note['date_enregistrement'].'</td>
                                <td><a href="?action=supprimer&id_note=' . $note['id_note'] . '" class="btn btn-danger" onclick="return (confirm(\'êtes vous sûr ?\'))"><i class="far fa-trash-alt"></i></a></td>
                                </tr>';

                                
                               
                                }
                            }
                            

                    ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </main>

<?php 
include '../inc/footer.inc.php';
 