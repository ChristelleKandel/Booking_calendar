<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - identification
Date : Mars 2023
*************************************-->

<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');
?>
    <div class="container m-5 row">
        <a class="navbar-brand h1 col" href="https://eco-lab.fr"><img src="/calendar/assets/img/logo.png" class="rounded-circle logo" alt="Logo d'Ecolab"> Les outils d'Ecolab</a>
    </div>

<body>
<main class="container mt-5">
    <h3 class="m-3">Accés réservé au propriétaire de l'outil</h3>
    <form action="verificationIdentification.php" method="post"> 
        <div class="form-group row">   	  
            <label for="nom_admin" class="col-lg-2 col-form-label">Entrez le nom du propriétaire: </label>         
            <div class="col-lg-10">
                <input type="text" id="nom_admin" name="nom_administrateur" required minlength="3"><br/><br/>
            </div>
            <label for="mdp_admin" class="col-lg-2 col-form-label">Entrez votre mot de passe: </label>  
            <div class="col-lg-10">
                <input type="password" id="mdp_admin" name="mdp_administrateur" required minlength="3"><br/><br/>
            </div>
            <div class="col-lg-10">
                <input class="btn btn-primary" type="submit" value="Connexion" />
            </div>
        </div>      
    </form> 

    <form action="motDePasseOublie.php" method="post" > 
        <h3 class="m-3">J'ai oublié mon mot de passe: </h3>
        <div class="form-group row">   	
            <label for="email_admin" class="col-lg-2 col-form-label">Mon email: </label>         
            <div class="col-lg-10">
                <input type="text" id="email_admin" name="email_administrateur" required ><br/><br/>
            </div>
            <div class="col-lg-10">
                <input class="btn btn-danger" type="submit" value="Ré-initialiser mon mot de passe" />
            </div>
        </div>      
    </form> 
</body>
</html>

