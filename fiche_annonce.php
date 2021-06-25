<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

if (isset($_GET['id_annonce'])) {
    $infos_annonce = $pdo->prepare("SELECT * FROM annonce WHERE id_annonce = :id_annonce");
    $infos_annonce->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_STR);
    $infos_annonce->execute();


    // Requete d'affichage des photos
    $id_annonce = $_GET['id_annonce'];

    $info_photo = $pdo->prepare("SELECT * FROM annonce, photo WHERE  id_annonce = :id_annonce AND photo_id = id_photo");
    $info_photo->bindParam('id_annonce', $id_annonce, PDO::PARAM_STR);
    $info_photo->execute();

    // Requete de recuperation des info du membre ayant posté l'annonce
    $info_membre = $pdo->prepare("SELECT * FROM annonce, membre WHERE  id_annonce = :id_annonce AND membre_id = id_membre");
    $info_membre->bindParam('id_annonce', $id_annonce, PDO::PARAM_STR);
    $info_membre->execute();

    // on vérifie si on a récupéré un article
    if ($infos_annonce->rowCount() > 0) {
        $infos = $infos_annonce->fetch(PDO::FETCH_ASSOC);
        $membre_info = $info_membre->fetch(PDO::FETCH_ASSOC);

        // On propose d'autres annonces
        $liste_annonces = $pdo->query("SELECT id_annonce, titre, description_courte, prix, photo FROM annonce ORDER BY  date_enregistrement");
    } else {

        header('location:index.php');
    }
} else {
    header('location:index.php');
}


// Si un commentaire est posté via le formulaire en lightbox
if(isset($_POST['comm'])) {
$commentaire = $_POST['comm'];
            
// ON COMMENCE L'ENREGISTREMENT
$enregistre_comm = $pdo->prepare("INSERT INTO commentaire (membre_id, annonce_id, commentaire,date_enregistrement) VALUES (:membre_id, :annonce_id, :commentaire, NOW())");
$enregistre_comm->bindParam(':membre_id', $membre_info['id_membre'], PDO::PARAM_STR);
$enregistre_comm->bindParam(':annonce_id', $id_annonce, PDO::PARAM_STR);
$enregistre_comm->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
$enregistre_comm->execute();

// Lors de l'envoi du formulaire  on envoi sur la page d'accueil
header('location:index.php');
}

// Si un avis et une note sont postés via le formulaire en lightbox
if(isset($_POST['notedonnee']) && isset($_POST['avisdonne'])) {
    $note = $_POST['notedonnee'];
    $avis = $_POST['avisdonne'];


                
    // ON COMMENCE L'ENREGISTREMENT
    $enregistre_avis = $pdo->prepare("INSERT INTO note (membre_id1, membre_id2, note, avis, date_enregistrement) VALUES (:membre_id1, :membre_id2, :note, :avis, NOW())");
    $enregistre_avis->bindParam(':membre_id1', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);
    $enregistre_avis->bindParam(':membre_id2',$membre_info['id_membre'], PDO::PARAM_STR);
    $enregistre_avis->bindParam(':note', $note, PDO::PARAM_STR);
    $enregistre_avis->bindParam(':avis', $avis, PDO::PARAM_STR);

    $enregistre_avis->execute();

    // Lors de l'envoi du formulaire  on envoi sur la page d'accueil
   // header('location:index.php');
    }



include 'inc/header.inc.php';
include 'inc/nav.inc.php';
?>
<main class="container">
    <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
        <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Annonces <i class="fas fa-bahai seaGreen"></i></h1>
        <p class="lead seaGreen ">Bienvenue sur notre site.
            <hr><?php echo $msg; ?></p>
    </div>

    <div class="row">
        <div class="col-6 mt-3">
            <h2>
                <!-- TITRE - CATEGORIE -->
                <?php echo $infos['titre']; ?></h2>
        </div>
        <div class="col-6 mt-3">
            <!-- LIEN CONTACT -->
            <!-- Ligthbox contact -->
            <button type="button" class="btn bg-seaGreen" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="<?php echo $membre_info['pseudo']; ?>">Contacter le vendeur</button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Envoyer un message à <?php echo $membre_info['pseudo']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3 text-center ">
                                    <p class="fw-bolder">Appeler le : <?php echo $membre_info['telephone']; ?></p>
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Message :</label>
                                    <textarea class="form-control" id="message-text"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="button" class="btn bg-seaGreen">Envoyer message</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Presnetation de l'annonce -->
    <div class="row mt-2">
        <div class="col-6 mt-2">

            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <?php
                    // ON met un compteur a 0 afin de pouvoir mettre un 'active' sur la premiere image du carousel
                    $counter = 1;

                    while ($photo = $info_photo->fetch(PDO::FETCH_ASSOC)) {


                        foreach ($photo as $indice => $valeur) {
                            // on recupere les indices des photos de la table photo
                            if ($indice == 'photo1' || $indice == 'photo2'  ||  $indice == 'photo3' ||  $indice == 'photo4'  ||  $indice == 'photo5') {
                                //On affiche les photo que si la variable $valeur n'est pas vide
                                if (!empty($valeur)) {  ?>

                                    <!-- si le compteur est a 1 le carousel sera 'active' -->
                                    <div class="row carousel-item <?php if ($counter === 1) {
                                                                        echo ' active';
                                                                    } ?>">

                                        <img src="<?php echo URL . 'assets/img_annonce/' . $valeur; ?>" alt="" class="d-block h-100 img-thumbnail">
                                    </div>

                    <?php
                                    // On incremente le compteur à chaque tour de la boucle pour l'affichage du carousel
                                    $counter++;
                                }
                            }
                        }
                    }
                    ?>
                    <!-- Bouttons du carousel -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

        </div>
        <div class="col-6 mt-5">
            <h3 class="grayS">Description </h3>
            <!-- TEXTE DESCRIPTION -->
            <?php echo $infos['description_longue']; ?>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-3 mt-2">
            <!-- DATE PUBLICATION -->
            <i class="fas fa-calendar-alt seaGreen"></i> <?php echo $infos['date_enregistrement']; ?>
        </div>
        <div class="col-3 mt-2">
            <!-- NOTE AVIS -->

            <i class="fas fa-user seaGreen"></i><a href="profil_annonce.php?id_membre=<?php echo $membre_info['id_membre']; ?>">Voir le profil de <?php echo $membre_info['pseudo']; ?></a>
        </div>
        <div class="col-3 mt-2">

            <!-- PRIX -->
            <i class="fas fa-euro-sign seaGreen"></i> <?php echo $infos['prix']; ?>
        </div>
        <div class="col-3 mt-2">
            <!-- ADRESSE -->
            <i class="fas fa-map-marker-alt seaGreen"></i> <?php echo $membre_info['adresse'] . ', ' . $membre_info['cp'] . ' ' . $membre_info['ville']; ?>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <?php
            // Google Maps Geocoder
            // $geocoder = "http://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false";

            // $arrAddresses = Address::LoadAll(); // Notre collection d'objets Address

            // foreach ($arrAddresses as $address) {

            //         if (strlen($address->Lat) == 0 && strlen($address->Lng) == 0) {

            //             $addesse = $membre_info['cp'];
            //             $adresse = $membre_info['adresse']->Rue;
            //             $adresse .= ', '.$membre_info['cp']->CodePostal;
            //             $adresse .= ', '.$membre_info['ville']->Ville;

            //             // Requête envoyée à l'API Geocoding
            //             $query = sprintf($geocoder, urlencode(utf8_encode($adresse)));

            //             $result = json_decode(file_get_contents($query));
            //             $json = $result->results[0];

            //             $adress->Lat = (string) $json->geometry->location->lat;
            //             $adress->Lng = (string) $json->geometry->location->lng;
            //             $adress->Save();

            //          }
            // }
            //             
            ?>
            <!-- GOOGLE MAP -->


        </div>
    </div>
    <!-- LightBox avis et commentaire si l'utilisateur est connecté-->
    <?php  if(user_is_connected()== true){                    ?>
    <div class="row mt-4">
        <div class="col-6">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#avis">
                Déposer une note ou poser une question
            </button>

            <!-- Modal -->
            <div class="modal fade p-4" id="avis" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Avis ou commentaire</h5>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                            <form class="row" method="post">
                                <select name="noter" id="noter">
                                    <option value="avis">Noter/donner un avis sur le vendeur</option>
                                    <option value="commentaire">Laisse un commentaire sur l'annonce</option>
                                </select>

                        </div>
                        <!-- <div class="modal-body">
                ...
            </div> -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Choisir</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }    ?>
    <!-- Si l'utilisteur connete decide de laisser un commentaire  -->
                <?php
    if(isset($_POST['noter']) && $_POST['noter'] == 'commentaire') {
            echo '<form method="post" class="row border p-3 shadow p-3 mb-5 mt-4 rounded w-50 mx-auto">
            <div class="col-11 col-lg-6 text-center text-white mx-auto">
            <div class="mb-3 ">
            <label for="comm">Laisser un commentaire</label>
            <textarea name="comm" id="comm" class=""mx-auto" cols="30" rows="6"></textarea> 
            <input type="submit" class="btn btn-secondary">
            </div>
            </div>
            </form>';

        }elseif(isset($_POST['noter']) && $_POST['noter'] == 'avis'){
            echo '<form method="post" class="row border p-3  shadow mb-5 mt-5 rounded w-50 mx-auto">
            <div class="col-11 text-center mx-auto">
            <div class="mb-3  text-center">
            <label for="notedonnee">Donnez une note sur 5</label>
            <select name="notedonnee" id="notedonnee"  class="form-control rounded-pill text-center">
            <option value="1" class="text-center">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
            <label for="avisdonne">Donnez votre avis</label>
            <textarea name="avisdonne" id="avisdonne" cols="30" rows="6"></textarea>
        <input type="submit" class="btn btn-secondary mt-3">
        </div>
        </div>
        </form>';


        }
        ?>
   <div class="row">
       <div class="col-12">
           <h2 class="grayS afterh2">Autres annonces</h2>

       </div>
   </div>
    <div class="row mt-2 mb-3">

        <?php

        while ($annonce = $liste_annonces->fetch(PDO::FETCH_ASSOC)) {
            echo  '<div class="col-2">
                             <div class=" bg-light border-dark border">
                             <img  src="' . URL . 'assets/img_annonce/' . $annonce['photo'] . '
                            " class="card-img-top img-fluid" alt="photo_produit">
                            <div class="card-body"><h4>' . $annonce['titre'] . '</h4>
                           <button type="button" class="btn btn-outline-dark"><a href="fiche_annonce.php?id_annonce=' . $annonce['id_annonce'] . '
                            "style="text-decoration: none; color: black;">Voir l\'annonce</a></button></div></div></div>';
        }

        ?>
    </div>
   
</main>
<?php
include 'inc/footer.inc.php';
