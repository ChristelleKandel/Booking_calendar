<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - index tous les jeux
Date : Mars 2023
*************************************-->
<?php 
$nav_jeux = "active";
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');
require 'limite.php';

if (isset($_GET['id'])) {
	$id = ($_GET["id"]);
  if($id==1){
    include_once ('views/_partials/_nav.php');
    include_once ('views/jeux/add_jeu.php');
    try {
      $sql = 'SELECT * FROM jeux';
      $statement = $connection->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_OBJ);

    } catch (PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }else{
    try {
      $sql = "SELECT * FROM jeux WHERE id_proprio = :id";
      $statement = $connection->prepare($sql);
      $statement->bindValue(':id', $id);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_OBJ);
    } 
    catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
    }
  }
} else {
  $id = 1;
    exit;
}
?>
<body>
<main class="container-fluid">
  <h2 class="text-center"> Tous mes jeux </h2>
  <div class="container">
    <div class="row justify-content-center">
      <?php foreach ($result as $row): ?>
        <div class="col-md-6 text-center p-2"> 
          <div class="border px-2">
            <img>id du jeu : <?= $row->id ?></img>           
            <h2><?= ($row->nom); ?></h2>
            <a class="btn btn-primary m-1" href="views/reservations/calendar.php?id=<?= ($row->id); ?>">Calendrier</a>
            <?php if($id==1){ ?>
              <form action="src/Controller/control_jeux.php" method="post">
              <input type="hidden" name="id" value="<?= $row->id ?>"> 
              <div class="row justify-content-end align-items-end"><button class="btn btn-danger m-1 col-sm-1" type="submit" name="supprJeu" onclick="if(window.confirm('Voulez-vous vraiment supprimer ?')){return true;}else{return false;}">X</button></div>  
              </form>              
            <?php } ?>
          </div>
        </div>
      <?php endforeach;?>
    </div>
  </div>
</main>
</body>
</html>