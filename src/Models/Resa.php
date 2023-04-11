<?php
require_once "DBconnect.php";
class Resa {
    /**
     * Récupére les réservations commençant entre le premier jour et le dernier jour de la page du calendrier affiché
     *
     * @param \DateTime $start
     * @param \DateTime $end
     * @param integer $id
     * @return array
     */
    public function getResaBetween (\DateTime $start, \DateTime $end, ?int $id = null): array {
        GLOBAL $connection;
        $sql = "SELECT * FROM reservations WHERE id_jeu = $id AND date_debut BETWEEN '{$start->format('Y-m-d')}' AND '{$end->format('Y-m-d')}' ORDER BY date_debut";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        // debug($result);
        return $result;
    }

    /**
     * Récupére les réservations mais INDEXEES par date_debut
     *
     * @param \DateTime $start
     * @param \DateTime $end
     * @param integer $id
     * @return array
     */
    public function getResaByDayBetween (\DateTime $start, \DateTime $end, ?int $id = null): array {
        $resas = $this->getResaBetween($start, $end, $id);
        $days = [];
        foreach($resas as $resa){
            $date = $resa['date_debut'];
            if (!isset($days[$date])){
                //si le tableau $days avec l'index $date n'existe pas, on le crée SOUS FORME DE TABLEAU: [$resa] et pas juste $resa
                $days[$date] = [$resa];
            }else{
                //Si $days avec l'index $date existe déjà, on peut ainsi lui ajouter un autre TABLEAU contenant les valeurs d'une autre résa.
                $days[$date][] = $resa;
            }
        }
        // debug($days);
        return $days;
    }

    /**
     * Récupére les réservations indexées par date_debut jusqu'à la date de fin
     *
     * @param \DateTime $start
     * @param \DateTime $end
     * @param integer $id
     * @return array
     */
    public function withinResa (\DateTime $start, \DateTime $end, ?int $id = null): array  {
        $mesResas = $this->getResaBetween($start, $end, $id);
        // debug($mesResas);
        $allResas = [];
        foreach($mesResas as $resa){
            $debut = $resa['date_debut'];
            // debug($allResas[$date]['date_debut']);
            $debut = strtotime($resa['date_debut']);
            // debug($debut);
            $fin = strtotime($resa['date_fin']);
            // debug($fin);
            $cursor = $debut;
            while ($cursor <= $fin) { // On parcourt tous les jours de la plage de l'evenement
                $allResas[date("Y-m-d", $cursor)][] = $resa;
                $cursor += 86400; // On ajoute un journee en timestamp pour passer au jour suivant
            }
        }
        return $allResas;
    }

    /**
     * Est ce que ce jour posséde une réservation?
        *
     * @param \DateTime $start
     * @param \DateTime $end
     * @param integer $id
     * @param \DateTime $date
     * @return boolean
     */
    public function dayWithResa(\DateTime $start, \DateTime $end, ?int $id = null, \DateTime $date): bool{
        //Je récupère le tableau ayant pour clé tous les jours réservés
        $liste = $this->withinResa($start, $end, $id, $date);
        //Je récupère un tableau liste de toutes les clefs (donc les dates déjà réservées)
        $liste = array_keys($liste);
        // debug($liste);
        //Si ma date appartient à la liste des dates réservées => true
        //in_array($date, $liste)
        return in_array($date->format('Y-m-d'), $liste);
    }
}