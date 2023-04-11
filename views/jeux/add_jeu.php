<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - add jeu
Date : Mars 2023
*************************************-->
<?php 
// Récupération de tous les proprietaires pour le menu déroulant
try {
    $request = "SELECT * FROM proprietaires";
    // var_dump($request);
    $statement = $connection->prepare($request);
    $statement->execute();
    $proprietaires = $statement->fetchAll();
  } catch (PDOException $error) {
    echo $request . "<br>" . $error->getMessage();
  }
?>
<h3 class="text-center m-3">Enregistrer un nouveau jeu disponible au prêt</h3>
<form action="src/Controller/control_jeux.php" method="post" class="container">
    <div class="form-group row">
        <label for="nom" class="col-sm-2 col-form-label text-right">Nom du jeu :</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="id_proprio" class="col-sm-2 col-form-label text-right">Proprietaire du jeu</label>
        <div class="col-sm-6">
            <select name="id_proprio">
                <?php foreach ($proprietaires as $proprio): ?>
                <option value="<?= ($proprio['id']); ?>">            
                    <?php echo $proprio['nom']; ?>
                </option>
                <?php endforeach;?>  
            </select>
        </div>
    </div>
    <div class="col-sm-9">
        <button class="btn btn-primary" type="submit" name="addJeu">Ajouter</button>
    </div>
</form>