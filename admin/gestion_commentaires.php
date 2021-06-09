<?php 
include '../inc/init.inc.php';
include '../inc/functions.inc.php';


 $liste_commentaires = $pdo->query("SELECT * FROM commentaire ORDER BY id_commentaire");



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
                            <th>Id membre</th>
                            <th>Id annonce</th>
                            <th>Commentaire</th>
                            <th>Date d'enregistrement</th>
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
                                <td>'.$commentaire['date_enregistrement'].'</td>
                                <td><a href="?action=supprimer&id_categorie=' . $commentaire['id_categorie'] . '" class="btn btn-danger" onclick="return (confirm(\'êtes vous sûr ?\'))"><i class="far fa-trash-alt"></i></a></td>
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
 