<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - liste toutes les resas
Date : Mars 2023
*************************************-->
<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');
$nav_proprio = "active";
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_nav.php');
require '../../limite.php';

require "../../src/Models/Proprios.php";
$proprietaires = new Proprios();
$proprietaires = $proprietaires->getAllAdmin();
?>
<main class="container-fluid">

    <h2 class="text-center m-3">Les propriétaires de jeux prêtés : </h2>
   
    <table class="table container">
        <tr class="bg-beige">
            <th>Nom</th>                   
            <th>email</th>
        </tr>
        <?php      
        foreach($proprietaires as $a): ?>
            <tr>
            <form action="../../src/Models/save_proprio.php" method="post">
            <div class="form-group row">
                <input type="hidden" name="id" value="<?= $a->id ?>">             
                <td><input type="text" name="nom" value="<?= $a->nom ?>"></td>
                <td><input type="text" name="email" value="<?= $a->email ?>"></td>
                <td>
                <a class="btn btn-danger" type="delete" onclick="if(window.confirm('Voulez-vous vraiment supprimer ?')){return true;}else{return false;}" href="../../src/Models/delete_proprio.php?id=<?= ($a->id); ?>">Supprimer</a>
                <button class="btn btn-primary" type="submit">Modifier</button>
              </td>               
            </div>
            </form>
            </tr>
        <?php endforeach ?>
    </table>
    <br>
    <h3 class="text-center m-3">Enregistrer un nouveau propriétaire de jeu : </h3>
    <form onSubmit="return verify(this.mdp, this.mdp2)" action="../../src/Models/create_proprio.php" method="post" class="container">
        <div class="form-group row">
            <label for="nom" class="col-sm-3 col-form-label">Nom * : </label>
            <div class="col-sm-9">
            <input type="text" id="nom" placeholder="nom" name="nom" required></div>
            <label for="email" class="col-sm-3 col-form-label">Email *: </label>
            <div class="col-sm-9">
            <input type="text" id="email" placeholder="email" name="email" required></div>
            <label for="mdp" class="col-sm-3 col-form-label">Mot de passe *: </label>
            <div class="col-sm-9">
            <input type="password" id="mdp" placeholder="mot de passe" name="mdp" required></div>
            <label for="mdp" class="col-sm-3 col-form-label">Confirmer le mot de passe *: </label>
            <div class="col-sm-9">
            <input type="password" id="mdp2" placeholder="mot de passe" name="mdp2" required></div>
            <div class="col-sm-3">
            <input type="hidden" name="token" value=""> 
                Ajouter un nouveau propriétaire de jeu: 
            </div>
            <div class="col-sm-9">
                <button class="btn btn-primary" type="submit" name="submit">Ajouter</button>
            </div>
        </div>
    </form>

<script>
    function verify(pass1, pass2){
        var verified=false
        // Si les valeurs des 2 pass ne sont pas identiques
        if (pass1.value!=pass2.value){
            alert("Les deux mots de passe ne concordent pas")
            pass1.select()
        }else{
        verified=true;}
    return verified
}
</script>