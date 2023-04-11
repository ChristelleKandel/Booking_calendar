<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - form ajout
Date : Mars 2023
*************************************-->
<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');
$nav_add = "active";
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_nav.php');

// Récupération de tous les jeux pour le menu déroulant
try {
  $request = "SELECT * FROM jeux";
  // var_dump($request);
  $statement = $connection->prepare($request);
  $statement->execute();
  $jeux = $statement->fetchAll();
} catch (PDOException $error) {
  echo $request . "<br>" . $error->getMessage();
}
// Traitement de l'enregistrement de la nouvelle réservation si le form est submitted
if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $dbpassword, $options);
    $sql = sprintf("INSERT INTO reservations (date_debut, date_fin, emprunteur, id_jeu) VALUES (?, ?, ?, ?)");
    $new_resa = array(
      $_POST['date_debut'],
      $_POST['date_fin'],
      $_POST['emprunteur'],
      $_POST['id_jeu'],
    );

    $statement = $connection->prepare($sql);
    $statement->execute($new_resa);
    
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<body>
  <main class="container-fluid">
    <h1 class="text-center m-3">Enregistrer une nouvelle réservation de jeu</h1>
    <form action="../../src/Models/create_resa.php" method="post" class="container">
      <h4> Nouvelle réservation </h4>
      <div class="form-group row">
        <label for="date_debut" class="col-sm-2 col-form-label text-right">Jour d'emprunt :</label>
        <div class="col-sm-6">
            <input type="date" class="form-control" id="date_debut" name="date_debut" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="date_fin" class="col-sm-2 col-form-label text-right">Jour de retour :</label>
        <div class="col-sm-6">
            <input type="date" class="form-control" id="date_fin" name="date_fin" required>
        </div>
      </div>    
      <br>
      <div class="form-group row">
        <label for="emprunteur" class="col-sm-2 col-form-label text-right">Emprunteur :</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="emprunteur" name="emprunteur" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="id_jeu" class="col-sm-2 col-form-label text-right">Jeu emprunté</label>
        <div class="col-sm-6">
          <select name="id_jeu">
            <?php foreach ($jeux as $row): ?>
              <option value="<?= ($row['id']); ?>">            
                <?php echo $row['nom']; ?>
              </option>
            <?php endforeach;?>  
          </select>
        </div>
      </div>
      <input type="submit" name="submit" class="btn btn-green" value="Enregistrer">
    </form>
    </br>
    <?php if (isset($_POST['submit']) && $statement) { ?>
      <p>  La réservation a été ajoutée. </p>
    <?php } ?>
    </br>
  </main>
</body>
</html>