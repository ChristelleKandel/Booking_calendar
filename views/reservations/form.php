<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - form resa / jeu
Date : Mars 2023
*************************************-->

<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');
require '../../limite.php';

//Récupération de l'ID du jeu dans le GET (passage par l'URL) pour afficher le form de resa correspondant (avec la liste des resa de ce jeu)
if (isset($_GET['id'])) {
    try {
        //Affichage des réservations déjà enregistrées
        $connection = new PDO($dsn, $username, $dbpassword, $options);
        $id = $_GET['id'];
        $sql = "SELECT * FROM reservations WHERE id_jeu = :id ORDER BY date_debut DESC";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetchAll();
        // var_dump($result);

        //Récupération du nom du jeu
        $sql2 = "SELECT * FROM jeux WHERE id = :id";
        $statement2 = $connection->prepare($sql2);
        $statement2->bindValue(':id', $id);
        $statement2->execute();
        $jeu = $statement2->fetch(PDO::FETCH_ASSOC);
        // debug($jeu);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "Une erreur est survenue !";
    exit;
}
?>
<body>
<main>
    <form action="../../src/Models/create_resa.php?id_jeu=<?= $jeu['id'] ?>" method="post" class="container">
        <h1 class="text-center">Réservation pour le jeu <?= $jeu['nom'] ?></h1>
        <br>
        <!-- Formulaire à remplir pour enregistrer une nouvelle réservation, avec input caché contenant id_jeu -->
        <h4> Nouvelle réservation </h4>
        <input type="hidden" class="form-control" id="id_jeu" name="id_jeu" value="<?= $jeu['id']; ?>" required>
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
        <br><br>
        <input class="btn btn-green" type="submit" name="submit" value="Enregistrer la réservation">
        <input class="btn btn-secondary" type="reset" value="Ré-initialiser" onclick="document.location.reload(false)"/>
        <a class="btn btn-green" href="calendar.php?id=<?= $id ?>">Voir le calendrier</a>
    </form>
    </br>
    </br>
    <!-- Tableau des réservations enregistrées pour ce jeu -->
    <table class="table table-bordered table-striped container">
        <thead>
            <tr>
                <th> </th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Emprunteur</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row): ?>
                <tr>
                    <form action="../../src/Models/save_resa.php?id_jeu=<?= $row['id_jeu'] ?>" method="post">
                        <div class="form-group row">
                            <td><input type="hidden" name="idd" value="<?= ($row["id_resa"]); ?>" ></td>
                            <td><input type="date" name="date_debut" value="<?= ($row["date_debut"]); ?>" ></td>
                            <td><input type="date" name="date_fin" value="<?= ($row["date_fin"]); ?>" ></td>
                            <td><input type="texte" name="emprunteur" value="<?= ($row["emprunteur"]); ?>"></td>
                            <td>
                                <a class="btn btn-danger" type="delete" onclick="if(window.confirm('Voulez-vous vraiment supprimer ?')){return true;}else{return false;}" href="../../src/Models/delete_resa.php?id=<?= ($row["id_resa"]); ?>&id_jeu=<?= ($row["id_jeu"]); ?>">Supprimer</a>
                                <button class="btn btn-primary" type="submit">Modifier</button>
                            </td>
                        </div>
                    </form> 
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</main>
</body>
</html>


