<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-seaGreen seaGrenn">
            <div class="container-fluid">
                <a class="navbar-brand grayS text-uppercase logo" href="<?php echo URL; ?>index.php">Swap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?php echo URL; ?>index.php">Annonces</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>contact.php">Contact</a>
                        </li>

                        <?php if( user_is_connected() == false ) { ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>connexion.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>inscription.php">Inscription</a>
                        </li>
                        

                        <?php } else { ?>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo URL; ?>profil.php">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo URL; ?>depot_annonce.php">Ajout annonce</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo URL; ?>connexion.php?action=deconnexion">Déconnexion</a>
                            </li>

                        <?php } ?>
                        
                        <!-- liens pour l'admin -->
                        <?php if( user_is_admin() == true ) { ?>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_annonces.php">Gestion annonces</a>
                                <a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_membres.php">Gestion membres</a>
                                <a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_categories.php">Gestion catégories</a>
                                <a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_notes.php">Gestion des notes</a>
                                <a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_commentaires.php">Gestion des commentaires</a>
                                <a class="dropdown-item" href="<?php echo URL; ?>admin/statistiques.php">Statistiques</a>
                           
                            </div>
                        </li>

                        <?php } ?>
                        <!-- /liens pour l'admin -->

                    </ul>
                 <!-- Formulaire de recherche -->
                    <form class="d-flex" method="GET">
                    <input class="form-control me-2" list="datalistOptions" id="myDataList" placeholder="Rechercher">
                    <datalist id="datalistOptions">
                    </datalist>
                    </form>
                </div>
            </div>
        </nav>