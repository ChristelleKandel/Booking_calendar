<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - affiche calendar
Date : Mars 2023
*************************************-->
<?php 

include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');
$days = ["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"];
$months = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"];

require "../../src/Models/Month.php";
require "../../src/Models/Resa.php";
// require ($_SERVER['DOCUMENT_ROOT'] . '/calendar/src/Models/Month.php');
// require ($_SERVER['DOCUMENT_ROOT'] . '/calendar/src/Models/Resa.php');


if (isset($_GET['id'])) {
	$id = ($_GET["id"]);
	try {
		$sql2 = "SELECT nom FROM jeux WHERE id = :id";
		$statement2 = $connection->prepare($sql2);
		$statement2->bindValue(':id', $id);
		$statement2->execute();
		$jeu = $statement2->fetch(PDO::FETCH_ASSOC);
	} 
	catch (PDOException $error) {
	echo $sql . "<br>" . $error->getMessage();
	}
} else {
    echo "Une erreur est survenue: il faut choisir un outil!";
    exit;
}
$resas = new Resa();
$month = new Month($_GET['month'] ?? null, $_GET['year'] ?? null);
// if(!isset($_GET['month'])){
// 	$month->month = date('m');
// }else{
// 	$month->month = $_GET['month'];
// }
// if(!isset($_GET['year'])){
// 	$month->year = date('Y');
// }else{
// 	$month->year = $_GET['year'];
// }
// debug($month);
$weeks = $month->getWeeks();
$today = new DateTime();
$today = $today->format('Y-m-d');

//récupération du 1er jour du mois
// $start = $month->getStartingDay();
//Si le 1er jour du mois est un lundi, ce sera le 1er mois affiché, sinon afficher le lundi précédent en premier
// $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
$start = $month->getStartingDay()->modify('monday this week');
$end = (clone $start)->modify('+' . (7*$weeks -1) . 'day');
// $resas = $resas->getResaBetween($start, $end);
$resas = $resas->getResaByDayBetween($start, $end, $id);
// debug($resas);
// debug($resas['2023-03-26']['emprunteur']);

$withinResa = new Resa();
$withinResa = $withinResa->withinResa($start, $end, $id);
// debug($withinResa);

$month2 = (clone $month)->nextMonth();
$weeks2 = $month2->getWeeks();
// debug($month2);
$start2 = $month2->getStartingDay()->modify('monday this week');
$end2 = (clone $start2)->modify('+' . (7*$weeks2 -1) . 'day');
$resas2 = new Resa();
$resas2 = $resas2->getResaByDayBetween($start2, $end2, $id);
// debug($resas2);
$withinResa2 = new Resa();
$withinResa2 = $withinResa2->withinResa($start2, $end2, $id);
?>
<body>
<main>
<section class="calendar-section container">
	<div class="text-center mb-5">
		<h1 class="heading-section">Calendrier des disponibilités de <?= $jeu['nom'] ?></h1>
	</div>
	<div class="row no-gutters">
		<!-- calendar 1 =  mois en cours -->
		<div class="col-lg-6"> 
			<div class="calendar">
				<div class="calendar_header">
					<button class="switch-month switch-left">
						<!-- je passe le mois et l'année dans l'URL pour le récupérer et mettre à jour -->
						<a href= "calendar.php?id=<?= $id ?>&month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" ><i class="fa fa-chevron-left"></i></a>
					</button>
					<h2> <?= $month->toString(); ?></h2>
					<button class="switch-month switch-right">
					<a href= "calendar.php?id=<?= $id ?>&month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" ><i class="fa fa-chevron-right"></i></a>
					</button>
				</div>
				
				<table class="calendar__table">
				<!-- Mon tableau aura $weeks lignes -->
				<thead>
					<tr>
					<?php foreach($month->days as $day):?>
						<th class="calendar_weekdays"> <?= $day; ?> </th>
					<?php endforeach; ?>
					</tr>
				</thead>
				<?php for ($i = 0; $i < $weeks; $i++): ?>
					<tr>
						<?php
						// foreach($month->days as $day) permet de récupérer chaque day (de Lundi à Dimanche) définis dans notre Class Month.php
						//Mon tableau aura donc 7 colonnes.
						//Je rajoute $d, une variable qui me permet de savoir sur quelle colonne j'en suis (entre 1 et 7) 
						// Je lui rajoute 7, 14, 21, 28 jours selon la ligne 
						//($i = le numéro de la semaine donc de la ligne, je le multiplie par 7jours)
						foreach($month->days as $d => $day): 
							$date = (clone $start)->modify("+" . ($d + $i*7) . " days");
							// $resaDuJour = $withinResa[$date->format('Y-m-d')] ?? [];
							$dayWithResa = new Resa();
							$dayWithResa = $dayWithResa->dayWithResa($start, $end, $id, $date);
							// debug($dayWithResa);
							// debug($resaDuJour);
						?>
						<!-- Mon td sera spécial si: 
						out-month = hors du mois en cours, 
						selected = la date fait partie des dates réservées, 
						today pour la date du jour -->
						<td class="<?= $month->withinMonth($date) ? '' : 'out_month'; ?> <?= $dayWithResa ? 'selected' : ''; ?>  <?= ($date->format('Y-m-d') === $today) ? 'today' : ''; ?>"> 
							<!-- Je mets le numéro du jour ('d') récupéré grâce à $date dans chaque td -->
							<div class="calendar_content ">
								<?= $date->format('d');?> 
							</div>

						</td>
						<?php endforeach; ?>
					</tr>
				<?php endfor; ?>
				</table>
			</div> 
		</div> 
		<!-- calendar 2 = mois suivant -->
		<div class="col-lg-6 d-lg-block d-none">
			<div class="calendar">
				<div class="calendar_header">
					<button class="switch-month switch-left">
						<!-- je passe le mois et l'année dans l'URL pour le récupérer et mettre à jour -->
						<a href= "calendar.php?id=<?= $id; ?>&month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" ><i class="fa fa-chevron-left"></i></a>
					</button>
					<h2> <?= $month2->toString(); ?></h2>
					<button class="switch-month switch-right">
					<a href= "calendar.php?id=<?= $id; ?>&month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" ><i class="fa fa-chevron-right"></i></a>
					</button>
				</div>
				<table class="calendar__table">
				<thead>
					<tr>
					<?php foreach($month2->days as $day):?>
						<th class="calendar_weekdays"> <?= $day; ?> </th>
					<?php endforeach; ?>
					</tr>
				</thead>
				<?php for ($i = 0; $i < $weeks2; $i++): ?>
					<tr>
						<?php
						foreach($month2->days as $d => $day): 
							$date2 = (clone $start2)->modify("+" . ($d + $i*7) . " days");
							$dayWithResa2 = new Resa();
							$dayWithResa2 = $dayWithResa2->dayWithResa($start2, $end2, $id, $date2);
						?>
						<td class="<?= $month2->withinMonth($date2) ? '' : 'out_month'; ?> <?= $dayWithResa2 ? 'selected' : ''; ?>  <?= ($date2->format('Y-m-d') === $today) ? 'today' : ''; ?>">  
							<div class="calendar_content <?= ($date2->format('Y-m-d') === $today) ? 'today' : ''; ?>">
								<?= $date2->format('d'); ?> 
							</div>
						</td>
						<?php endforeach; ?>
					</tr>
				<?php endfor; ?>
				</table>
			</div>         
		</div>
	</div> <!-- end row -->
	<div class="text-center mt-5">
	<a class="text-center" href="form.php?id=<?= $id ?>">Lien privé pour une nouvelle reservation</a>
	</div>
</section>
</main>
</body>
</html>

