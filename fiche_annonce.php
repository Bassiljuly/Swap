<?php 
include 'inc/init.inc.php';
include 'inc/functions.inc.php';


    // CODE ...


include 'inc/header.inc.php'; 
include 'inc/nav.inc.php';
?>
        <main class="container">
            <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
                <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Annonces <i class="fas fa-bahai seaGreen"></i></h1>
                <p class="lead seaGreen ">Bienvenue sur notre site.<hr><?php echo $msg; ?></p>                
            </div>

            <div class="row">
                <div class="col-6 mt-5">
                   <h2> <!-- TITRE - CATEGORIE --></h2>
                </div>
                <div class="col-6 mt-5">
                    <!-- LIEN CONTACT -->
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-6 mt-5">
                    <!-- PHOTO -->
                </div>
                <div class="col-6 mt-5">
                        <h3 class="grayS">Description</h3>
                    <!-- TEXTE DESCRITPION -->
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-3 mt-5">
                    <i class="fas fa-calendar-alt grayS"></i><!-- DATE PUBLICATION -->
                </div>
                <div class="col-3 mt-5">
                    <i class="fas fa-user grayS"></i><!-- NOTE AVIS -->
                </div>
                <div class="col-3 mt-5">
                    <i class="fas fa-euro-sign grayS"></i> <!-- PRIX -->
                </div>
                <div class="col-3 mt-5">
                <i class="fas fa-map-marker-alt grayS"></i><!-- ADRESSE -->
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <!-- GOOGLE MAP -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h2 class="grayS">Autres Annonces</h2>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-3">
                    <!-- PHOTO ANNONCE -->
                </div>
                <div class="col-3">
                    <!-- PHOTO ANNONCE -->
                </div> 
                <div class="col-3">
                    <!-- PHOTO ANNONCE -->
                </div> <div class="col-3">
                    <!-- PHOTO ANNONCE -->
                </div>
            </div>
        </main>

<?php 
include 'inc/footer.inc.php';
 