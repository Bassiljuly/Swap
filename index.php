<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';




// Requetes
$liste_categories = $pdo->query("SELECT titre FROM categorie GROUP BY titre");
$liste_membres = $pdo->query("SELECT pseudo FROM membre GROUP BY pseudo");
$annonces_cp = $pdo->query("SELECT id_annonce, cp FROM annonce ORDER BY  date_enregistrement");



// requete de récupération des annonces par categorie
if (isset($_GET['categorie'])) {
    $liste_annonces = $pdo->prepare("SELECT * FROM annonce WHERE categorie_id IN (SELECT id_categorie FROM categorie WHERE titre = :titre)");
    $liste_annonces->bindParam(':titre', $_GET['categorie'], PDO::PARAM_STR);
    $liste_annonces->execute();
}elseif (isset($_GET['membre'])) {
    // requete de recupration des annonces par membre
    $liste_annonces = $pdo->prepare("SELECT * FROM annonce WHERE membre_id IN (SELECT id_membre FROM membre WHERE pseudo = :pseudo)");
    $liste_annonces->bindParam(':pseudo', $_GET['membre'], PDO::PARAM_STR);
    $liste_annonces->execute();
}elseif (isset($_GET['cp'])) {
    // requete de recupration des annonces par code postal
    $liste_annonces = $pdo->prepare("SELECT * FROM annonce WHERE cp = :cp");
    $liste_annonces->bindParam(':cp', $_GET['cp'], PDO::PARAM_STR);
    $liste_annonces->execute();
} else {
    $liste_annonces = $pdo->query("SELECT id_annonce, titre, description_courte, prix, photo, categorie_id, cp FROM annonce ORDER BY  date_enregistrement");
}


//$requete_filtre.='price<=:price';
if(isset($_POST['prix']) ){
   // $prix = $_POST['prix'];
   // echo $prix;
    $liste_annonces = $pdo->prepare("SELECT * FROM annonce WHERE prix <= :prix ORDER BY prix");
    $liste_annonces->bindParam(':prix', $_POST['prix'] , PDO::PARAM_STR);
    $liste_annonces->execute();
  //  header('location:index.php');
  
}

include 'inc/header.inc.php';
include 'inc/nav.inc.php';

?>
<main class="container">
    <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
        <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Accueil <i class="fas fa-bahai seaGreen"></i></h1>
        <p class="lead seaGreen ">Bienvenue sur notre site.
            <hr><?php echo $msg; ?></p>
    </div>
    <!--  Filtrage des annonces -->
    <div class="col-sm-12 mt-5">
        <div class="row ">


        <!-- Price filter -->
        <div class="col-3 text-center">
            <form action="" class="bg-grayS rounded pb-2" method="post">
                <div class="mb-3  p-3 star text-white ">
                    <label for="prix" class="form-label text-center ">Prix</label>
                    <input type="range" name="prix" value="10000" min="0" max="10000" oninput="prixMax.value=parseInt(prix.value)+parseInt(prix.value)" class="form-range" id="customRange1">
                    
                    <output name="prixMax">10000</output>
                </div>
                <div class="mb-3 mt-4">
                            <button type="submit" class="btn btn-outline-dark bg-seaGreen w-80" id="envoyer"> soumettre</button>
                        </div>
            </form>
        </div>
            <!-- Filtre catégories -->
           
               
                <div class="dropdown col-3 text-center">
                    <button class="btn bg-grayS text-light dropdown-toggle mt-4 mb-4 col-10 mx-auto" type="button" id="dropdownButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Catégorie
                    </button>
                    <ul class="dropdown-menu col-10 text-center" aria-labelledby="dropdownButton1">
                        <li class="list-group-item "><a href="<?php echo URL; ?>">Tous les produits</a></li>
                        <?php
                        while ($categorie = $liste_categories->fetch(PDO::FETCH_ASSOC)) {
                            // var_dump($categorie);
                            echo '<li class="list-group-item"><a href="?categorie=' . $categorie['titre'] . '">' . $categorie['titre'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
           
           
            <!-- Filtre membres -->
           
                <div class="dropdown col-3 text-center">
                    <button class="btn bg-grayS text-light dropdown-toggle col-10 mt-4 mb-4 mx-auto" type="button" id="dropdownButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        Membre
                    </button>
                    <ul class="dropdown-menu col-10 text-center " aria-labelledby="dropdownButton2">
                        <?php
                        while ($membre = $liste_membres->fetch(PDO::FETCH_ASSOC)) {

                            echo '<li class="list-group-item"><a href="?membre=' . $membre['pseudo'] . '">' . $membre['pseudo'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
           
            <!-- Filtre code postal -->
       
            <div class="dropdown col-3 text-center">
                    <button class="btn bg-grayS text-light dropdown-toggle col-10 mt-4 mb-4 mx-auto" type="button" id="dropdownButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        Code postal
                    </button>
                    <ul class="dropdown-menu col-10 text-center " aria-labelledby="dropdownButton2">
                        <?php
                        while ($cp = $annonces_cp->fetch(PDO::FETCH_ASSOC)) {

                            echo '<li class="list-group-item"><a href="?cp=' . $cp['cp'] . '">' . $cp['cp'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
          
        </div>
    </div>
    <!-- Fin des filtres -->
  

    <!-- Affichage des annonces -->
    <div class="row mt-5">
        <div class="col-lg-10 col-md-9 col-sm-8 mt-2">
            <div class="row mb-5">

                <?php
                if ($liste_annonces->rowCount() < 1) {
                    echo '<div class="col-12 alert alert-danger">Aucun produit ne correspond à votre recherche !</div>';
                } else {
                    while ($annonce = $liste_annonces->fetch(PDO::FETCH_ASSOC)) {
                        echo  '<div class="col-sm-4 text-center mt-4">
                             <div class=" bg-light border rounded border-seaGreen">
                             <img class="height_img" src="' . URL . 'assets/img_annonce/' . $annonce['photo'] . '
                            " class="card-img-top" alt="photo_produit">
                            <div class="card-body"><h4>' . $annonce['titre'] . '</h4>
                            <p class="card-text">description :' . substr($annonce['description_courte'], 0, 15)  . ' <a href=fiche_annonce.php?id_annonce=' . $annonce['id_annonce'] . '
                            "style="text-decoration: none; color: black;">...</a>' . ' 
                            </p><br>Prix : ' . $annonce['prix'] . '<i class="fas fa-euro-sign"></i></p><button type="button" class="btn btn-outline-dark bg-seaGreen"><a href="fiche_annonce.php?id_annonce=' . $annonce['id_annonce'] . '
                            "style="text-decoration: none; color: black;">Voir l\'annonce</a></button></div></div></div>';
                    }
                }
                ?>
            </div>
        </div>

    </div>



</main>
<?php
include 'inc/footer.inc.php';
