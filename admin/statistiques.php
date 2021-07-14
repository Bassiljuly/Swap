<?php
include '../inc/init.inc.php';
include '../inc/functions.inc.php';

// ------ ACCES A L'ADMIN------------

if (user_is_admin() == false) {
    header('location:../connexion.php');
}

// --------- RECUPERATION DES MEMBRES ET DE LA MOYENNE DE LEUR NOTE------------

$liste_membres = $pdo->query('SELECT FLOOR(AVG(note)) as "note_moyenne", pseudo FROM note, membre  WHERE id_membre = membre_id2 GROUP BY membre_id2 ORDER BY AVG(note_moyenne) DESC LIMIT 5');


//--------- RECUPERATION DU NOMBRE D'AVIS
$nb_avis = $pdo->query("SELECT COUNT(id_note) AS 'nb_note', FLOOR(AVG(note)) AS 'note_m' FROM note GROUP BY membre_id2 ORDER BY note_m DESC LIMIT 5");


// ----------- RECUPERATION DES ANNONCES LES PLUS ANCIENNES
$liste_annonces = $pdo->query("SELECT * , DATE_FORMAT(date_enregistrement, '%d/%m/%Y à %Hh:%i.' ) AS 'date_post' FROM annonce ORDER BY date_post LIMIT 5");


// ---------- RECUPERATION DES 5 CATEGORIES CONTENANT LE PLUS D'ANNONCES
$liste_categories = $pdo->query("SELECT COUNT(DISTINCT(categorie_id)) AS 'nb_categorie',  c.titre as 'titre_categorie' FROM annonce AS a, categorie AS c WHERE c.id_categorie = a.categorie_id GROUP BY id_categorie  ORDER BY categorie_id DESC LIMIT 5");


// ---------- RECUPERATION DES MEMBRES LES PLUS ACTIFS
$liste_membres_actifs = $pdo->query("SELECT COUNT(id_annonce) as 'nb_annonces', pseudo FROM annonce, membre WHERE membre_id = id_membre  GROUP BY membre_id ORDER BY nb_annonces DESC LIMIT 5");


include '../inc/header.admin.inc.php';
include '../inc/nav.inc.php';
?>
<main class="container">
    <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
        <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Statistiques <i class="fas fa-bahai seaGreen"></i></h1>
        <p class="lead seaGreen ">Bienvenue
            <hr><?php echo $msg; ?></p>
    </div>

    <!-- TOP DES MEMBRES LES MIEUX NOTES -->
    <div class="row">
        <div class="col-12 mt-5">
            <h3>
                Top 5 des membres les mieux notés :
            </h3>
            <div class="row">
                <div class="col-12">
                    <ul>
                        <?php
                         
                           // On crée un compteur pour le lister mes membres das l'ordre
                           $counter = 0;
   
                           while (($meilleurs_membres = $liste_membres->fetch(PDO::FETCH_ASSOC)) && ($nb_avis_membre = $nb_avis->fetch(PDO::FETCH_ASSOC))) {
   
                               //On ajoute +1 au compteur a chaque tour
                               $counter++;
                               // On recupère les infos souhaitées
                               foreach ($meilleurs_membres as $indice => $valeur) {
   
                                   if ($indice == 'pseudo') {
                                       echo '<li class="p-2">' . $counter . ' - <span class="text-white ps-3"> ' . $valeur . '</span> ';
                                   } elseif ($indice == 'note_moyenne') {
   
   
                                       echo '<span class="bg-light p-1 ms-3 border border-rounded">' . $valeur . ' étoiles sur ' . $nb_avis_membre['nb_note'] . ' avis</span></li>';
                                   }
                               }
                           };
   
                    
                           
                        ?>
                    </ul>
                </div>

            </div>
        </div>
        <!-- TOP DES MEMBRES LES PLUS ACTIFS -->
        <div class="row">
            <div class="col-12 mt-5">
                <h3>
                    Top 5 des membres les plus actifs :
                </h3>
                <div class="row">
                    <div class="col-12">
                        <ul>
                            <?php
                            $counter = 0;


                            while ($membre_actif = $liste_membres_actifs->fetch(PDO::FETCH_ASSOC)) {
                                // foreach($membre_actif as $info => $valeur_membre){
                                //On ajoute +1 au compteur a chaque tour   
                                $counter++;
                                //  if($indice == 'pseudo'){
                                // On recupère les info souhaitées
                                echo '<li class="p-2">' . $counter . ' - <span class="text-white ps-3"> ' . $membre_actif['pseudo'] . ' </span></li> ';
                            } ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <!-- TOP DES PLUS ANCIENNES ANNONCES -->
        <div class="row">
            <div class="col-12 mt-5">
                <h3>
                    Top 5 des annonces les plus anciennes :
                </h3>
                <div class="row">
                    <div class="col-12">
                        <ul>
                            <?php
                            $counter = 0;


                            while ($annonces_anciennes = $liste_annonces->fetch(PDO::FETCH_ASSOC)) {

                                //On ajoute +1 au compteur a chaque tour    
                                $counter++;
                                // On recupère les info souhaitées
                                echo '<li class="p-2">' . $counter . ' - <span class="text-white ps-3"> ' . $annonces_anciennes['titre'] . ' publiée le ' . $annonces_anciennes['date_post'] . '</span></li> ';
                            } ?>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- TOP DDES CATEGORIES LISTANTS LE PLUS D'ANNONCES -->
            <div class="row">
                <div class="col-12 mt-5">
                    <h3>
                        Top 5 des categories listants le plus d'annonces :
                    </h3>
                    <div class="row">
                        <div class="col-12">
                            <ul>
                                <?php
                                // On crée un compteur pour le lister mes membres das l'ordre
                                // On crée un compteur pour le lister mes membres das l'ordre
                                $counter = 0;


                                while ($categorie = $liste_categories->fetch(PDO::FETCH_ASSOC)) {
                                    $counter++;
                                    foreach ($categorie as $indice => $valeur) {
                                        //On ajoute +1 au compteur a chaque tour    
                                        if ($indice == 'titre_categorie') {
                                            // On recupère les info souhaitées
                                            echo '<li class="p-2">' . $counter . ' - <span class="text-white ps-3"> ' . $valeur . ' </span></li> ';
                                        }
                                    }
                                } ?>
                            </ul>
                        </div>

                    </div>
                </div>
</main>

<?php
include '../inc/footer.inc.php';
