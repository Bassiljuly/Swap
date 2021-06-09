<?php 
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

    // // Restriction d'accès, si l'utilisateur est connecté, on redirige vers profil.php
    // if( user_is_connected() == true ) {
    //     header('location:profil.php');
    // }
    
    // Declaration des variables pour eviter les errerus dans le formulaire
     $pseudo = '';
     $mdp = '';
     $nom = '';
     $prenom = '';
     $email ='';
     $civilite ='';
     $tel ='';

     
     // Si tous les champs sont remplis
     if(isset($_POST['pseudo']) && isset($_POST['mdp']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['civilite']) && isset($_POST['tel'])) {
         
         // On retire les caracteres speciaux et les espaces et on injecte les resultats du formulaire dans les variables
         $pseudo = trim($_POST['pseudo']);
         $mdp = trim($_POST['mdp']);
         $nom = trim($_POST['nom']);
         $prenom = trim($_POST['prenom']);
         $email = trim($_POST['email']);
         $civilite = trim($_POST['civilite']);
         $tel = trim($_POST['tel']);
         
         
         // on prevois les cas d'erreur
         $erreur = false;

        // On verifie le pseudo 
         // -- avec une taille minimum de 4 et maximum de 15 caracteres
        if( iconv_strlen($pseudo) >= 4 && iconv_strlen($pseudo) <= 15) {
            $erreur = false ;
          
        } else {
            $erreur = true;
            $msg .= '<div class="alert alert-warning" role="alert"> Attention, Votre pseudo doit contenir entre 4 et 15 caractères.</div>';
        }

        // On verifie les caracteres du pseudo
        $verification_caracteres = preg_match('#^[a-zA-Z0-9._-]+$#', $pseudo);

        if($verification_caracteres == true) {
            $erreur == false;
        }else {
            $erreur == true;
            $msg .= '<div class="alert alert-warning" role="alert"> Attention, Votre pseudo Ne doit pas contenir de caracère spécial. <hr>Les caractères autorisés sont les lettres de A à Z minucules ou majuscule, les chiffres de 0 à 9, ainsi que les signes "-" "_" "." </div>';
        }

        // Verification de la disponibilité du pseudo dans la BDD

        $verif_dispo_pseudo = $pdo->prepare("SELECT * FROM membre WHERE pseudo =:pseudo ");
        $verif_dispo_pseudo->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $verif_dispo_pseudo->execute();

        if($verif_dispo_pseudo->rowCount() > 0) {
            $erreur = true;
            $msg .= '<div class="alert alert-warning" role="alert"> Attention, Votre pseudo existe déjà, veuillez en choisir un autre.</div>';
        }

        // Verification du mail 
            // - Verification de son format
        if( filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $erreur = true;
            $msg .= '<div class="alert alert-warning" role="alert"> Attention, Le format du mail est invalide.</div>';

        }

            // verification qu'il ne soit pas vide
        if(empty($mdp)) {
            $erreur = true;
            $msg .= '<div class="alert alert-warning" role="alert"> Attention, Le mot de passe est obligatoire.</div>';

        }

        // Si tout est OK on lance l'enregistrement 
        if($erreur == false) {

            // On cryypt le mot de passe
            $mdp = password_hash($mdp, PASSWORD_DEFAULT);

            // ON COMMENCE L'ENREGISTREMENT
            $enregistrement = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, telephone, email, civilite, statut, date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite, 1, NOW())");
            $enregistrement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $enregistrement->bindParam(':mdp', $mdp, PDO::PARAM_STR);
            $enregistrement->bindParam(':nom', $nom, PDO::PARAM_STR);
            $enregistrement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $enregistrement->bindParam(':telephone', $tel, PDO::PARAM_STR);
            $enregistrement->bindParam(':email', $email, PDO::PARAM_STR);
            $enregistrement->bindParam(':civilite', $civilite, PDO::PARAM_STR);
            $enregistrement->execute();

            // Si enregistrement ok on envoi sur la page connexion afin d'eviter le rechargement de la page
            header('location:connexion.php');
        }

     } 


include 'inc/header.inc.php'; 
include 'inc/nav.inc.php';
?>
        <main class="container">

          
            <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
                <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Inscription <i class="fas fa-bahai seaGreen"></i></h1>
                <p class="lead seaGreen ">Bienvenue sur notre site.<hr><?php echo $msg; ?></p>                
            </div>

                    <form class="row border p-3 bg-grayS shadow p-3 mb-5 rounded" method="post" action="">
                        <div class="col-sm-6 text-center text-white">
                            <div class="mb-3">
                                <label for="pseudo" class="form-label"><i class="fas fa-user-alt seaGreen"></i> Pseudo</label>
                                <input type="text" class="form-control rounded-pill" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="mdp" class="form-label"><i class="fas fa-unlock-alt seaGreen"></i> Mot de passe</label>
                                <input type="text" class="form-control rounded-pill" id="mdp" name="mdp">
                            </div>
                            <div class="mb-3">
                                <label for="nom" class="form-label"><i class="fas fa-user-alt seaGreen"></i> Nom</label>
                                <input type="text" class="form-control rounded-pill" id="nom" name="nom" value="<?php echo $nom; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label"><i class="seaGreen fas fa-user-alt"></i> Prénom</label>
                                <input type="text" class="form-control rounded-pill" id="prenom" name="prenom" value="<?php echo $prenom; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 text-center text-white">
                            <div class="mb-3">
                                        <div class="mb-3">
                                            <label for="email" class="form-label"><i class="far fa-envelope-open seaGreen"></i> Email</label>
                                            <input type="text" class="form-control rounded-pill" id="email" name="email" value="<?php echo $email; ?>">
                                        </div>                            
                                <label for="civilite" class="form-label"><i class="seaGreen fas fa-user-alt"></i> Civilité</label>
                                <select class="form-control rounded-pill" id="civilite" name="civilite">
                                    <option value="m">homme</option>
                                    <option value="f" <?php if( $civilite == 'f' ) { echo 'selected'; } ?> >femme</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tel" class="form-label"><i class="seaGreen fas fa-phone"></i> Téléphone</label>
                                <input type="text" class="form-control rounded-pill" id="tel" name="tel" value="<?php echo $tel; ?>">
                            </div>
                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-outline bg-seaGreen w-50" id="inscription" >Inscription</button>
                            </div>
                        </div>
                    </form>
          
        </main>

<?php 
include 'inc/footer.inc.php';




 