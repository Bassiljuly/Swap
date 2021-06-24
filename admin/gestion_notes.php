<?php 
include '../inc/init.inc.php';
include '../inc/functions.inc.php';

$liste_notes = $pdo->query("SELECT * FROM commentaire ORDER BY id_commentaire");



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
                            <th>Id membre noté</th>
                            <th>Id membre donnant la note</th>
                            <th>Note</th>
                            <th>Avis</th>
                            <th>Date enregistrement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            
                        while($note = $liste_notes->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr>
                                <td>'. $note['id_note'] . '</td>
                                <td>'. $note['membre_id1'] . '</td>
                                <td>'.$note['membre_id2'].'</td>
                                <td>'.$note['note'].'</td>
                                <td>'.$note['avis'].'</td>
                                <td>'.$note['date_enregistrement'].'</td>
                                <td><a href="?action=supprimer&id_note=' . $note['id_note'] . '" class="btn btn-danger" onclick="return (confirm(\'êtes vous sûr ?\'))"><i class="far fa-trash-alt"></i></a></td>
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
 