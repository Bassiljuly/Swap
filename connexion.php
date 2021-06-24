<?php 
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

$pseudo ='';


// Deconnexion de l'utilisateur
    if(isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
        // destruction de la session
        session_destroy();
        header('location:connection.php');
    }

    // Restriction d'acces si l'utilisateur est connecté
    if(user_is_connected() == true) {
        header('location:profil.php');
    } 



// On verifie que le pseudo est validé
if( isset($_POST['pseudo']) && isset($_POST['mdp'])) {
    $pseudo = trim($_POST['pseudo']);
    $mdp = trim($_POST['mdp']);

    // On recherche le pseudo dans la BDD : requête
    $connexionbdd = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $connexionbdd->bindParam( ':pseudo', $pseudo, PDO::PARAM_STR );
    $connexionbdd->execute();

    // On verifie si il y a un pseudo correspondant dans la bdd
    if($connexionbdd->rowCount()> 0) {
        // Si le pseudo est trouvé dans la bdd, 
        // On verifie le mot de passe en se basant d'abord sur le pseudo 
        $infos = $connexionbdd->fetch(PDO::FETCH_ASSOC);
        // echo '<pre>'; print_r($infos); echo '</pre>';
        if(password_verify($mdp, $infos['mdp'])) {
            // Si le mdp est ok, on garde les info du membre connecte dans la session
            // Creation de la $_SESSION['membre']
            $_SESSION['membre'] = array();
            $_SESSION['membre']['id_membre'] = $infos['id_membre'];
            $_SESSION['membre']['pseudo'] = $infos['pseudo'];
            $_SESSION['membre']['nom'] = $infos['nom'];
            $_SESSION['membre']['prenom'] = $infos['prenom'];
            $_SESSION['membre']['tel'] = $infos['telephone'];
            $_SESSION['membre']['email'] = $infos['email'];
            $_SESSION['membre']['civilite'] = $infos['civilite'];
            $_SESSION['membre']['statut'] = $infos['statut'];
            $_SESSION['membre']['date_enregistrement'] = $infos['date_enregistrement'];

            // Si il est connecte on l'envoi sur la page profil
            header('location:profil.php');


           
        } else {
            // Si il y a erreur sur le mdp
            $msg .= '<div class="alert alert-warning" role="alert"> Attention, Erreur sur le mot de passe.</div>';

        }

        } else {
            // si erreur sur le pseudo
            $msg .= '<div class="alert alert-warning" role="alert"> Attention, Erreur sur le pseudo.</div>';

        }
    }

include 'inc/header.inc.php'; 
include 'inc/nav.inc.php';
?>
        <main class="container">
            <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
                <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Connexion <i class="fas fa-bahai seaGreen"></i></h1>
                <p class="lead seaGreen ">Bienvenue sur notre site.<hr><?php echo $msg; ?></p>                
            </div>

         
                <form class="row border p-3 bg-grayS shadow p-3 mb-5 rounded w-50 mx-auto" method="post" action="">
                        <div class="col-11 col-lg-6 text-center text-white mx-auto">
                            <div class="mb-3">
                                <label for="pseudo" class="form-label"><i class="fas fa-user-alt seaGreen"></i> Pseudo</label>
                                <input type="text" class="form-control rounded-pill" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="mdp" class="form-label"><i class="fas fa-unlock-alt seaGreen"></i> Mot de passe</label>
                                <input type="text" class="form-control rounded-pill" id="mdp" name="mdp">
                            </div>
                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-outline bg-seaGreen w-50" id="inscription" >Connexion</button>
                            </div>
                        </div>
                    </form>
           
        </main>

<?php 
include 'inc/footer.inc.php';
 