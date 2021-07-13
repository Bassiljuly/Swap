<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';


// CODE ...


include 'inc/header.inc.php';
include 'inc/nav.inc.php';
?>
<main class="container">
    <div class="bg-light p-5 rounded text-center shadow p-3 mb-5 bg-body rounded">
        <h1 class="grayS"><i class="fas fa-bahai seaGreen"></i> Contact <i class="fas fa-bahai seaGreen"></i></h1>
        <p class="lead seaGreen ">Bienvenue sur notre site.
            <hr><?php echo $msg; ?></p>
    </div>

    <div class="row">
        <div class="col-6 mt-5 m-auto">

            <!-- ********** Formulaire de contact ************** -->
            <form class="border p-3 bg-grayS shadow p-3 mb-5 rounded text-center" name="formcontact">

                <div class="mb-3 w-75 m-auto rounded-pill mt-5">
                    <label for="nomC" class="form-label">Nom <span style="color:red"> *</span></label>
                    <input type="text" class="form-control rounded-pill" id="nomC" name="nomC" required>
                </div>
                <div class="mb-3 w-75 m-auto rounded-pill">
                    <label for="prenomC" class="form-label">Prenom</label>
                    <input type="text" class="form-control rounded-pill" id="prenomC" name="prenomC">
                </div>
                <div class="mb-3 w-75 m-auto">
                    <label for="exampleInputEmail1" class="form-label">Email<span style="color:red"> *</span></label>
                    <input type="email" class="form-control rounded-pill" id="exampleInputEmail1" aria-describedby="emailHelp" name="emailC" required>
                </div>
                <div class="mb-3 w-75 m-auto">
                    <label for="sujet" class="form-label">Sujet<span style="color:red"> *</span></label>
                    <textarea class="form-control rounded-pill" id="sujet" name="sujet" required></textarea>
                </div>
                <button type="submit" class="btnFormContact orfont mt-3 btn btn-dark mb-5">Envoyer</button>
            </form>
        </div>
        <div class="row">
            <div class="col-sm-11 text-center m-auto">
                <p style="color:red;">* Champs obligtoire</p>
            </div>

        </div>

    </div>
</main>

<?php
include 'inc/footer.inc.php';
