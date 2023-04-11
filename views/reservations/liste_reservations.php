<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - liste toutes les resas
Date : Mars 2023
*************************************-->
<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');
$nav_resa = "active";
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_nav.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/calendar/limite.php');

// require '../../limite.php';

try {
    // $sql = 'SELECT * FROM reservations';
    $sql = 'SELECT r.date_debut as date_debut, r.date_fin as date_fin, r.id_resa as id_resa, r.emprunteur as emprunteur, j.nom as nom FROM reservations as r, jeux as j WHERE j.id=r.id_jeu ORDER BY r.date_debut DESC';
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();

} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<body>
<main class="container-fluid">
  <div class="m-5 text-center">
    <h1>Toutes les réservations</h1>
    <a class="btn btn-lg btn-green" href="add_resa.php">Ajouter une réservation</a>
  </div>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th> </th>
        <th>Nom du jeu</th>
        <th>Date début</th>
        <th>Date fin</th>
        <th>Emprunteur</th>
        <th> </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($result as $row): ?>
        <tr>
          <form action="../../src/Models/save_resa.php" method="post">
            <div class="form-group row">
              <td><input type="hidden" name="idd" value="<?= ($row["id_resa"]); ?>" ></td>
              <td><input type="text" name="id_jeu" value="<?= ($row["nom"]); ?>" disabled="disabled"></td>
              <td><input type="date" name="date_debut" value="<?= ($row["date_debut"]); ?>" ></td>
              <td><input type="date" name="date_fin" value="<?= ($row["date_fin"]); ?>" ></td>
              <td><input type="texte" name="emprunteur" value="<?= ($row["emprunteur"]); ?>"></td>
              <td>
                <a class="btn btn-danger" type="delete" onclick="if(window.confirm('Voulez-vous vraiment supprimer ?')){return true;}else{return false;}" href="../../src/Models/delete_resa.php?id=<?= ($row["id_resa"]); ?>">Supprimer</a>
                <button class="btn btn-primary" type="submit">Modifier</button>
              </td>
            </div>
          </form> 
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
<!-- <a class="btn btn-danger" href="delete_all.php">Supprimer toute la liste</a> -->

  </main>
  </body>
  </html>