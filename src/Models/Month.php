<?php
// namespace App\Models;

// use \DateTime;
// use \Exception;

class Month {

    public $days = ["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"];

    public $months = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"];
    public $month;
    public $year;

    /**
     * Month constructor
     *
     * @param integer $month
     * @param integer $year
     * @throws \Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if($month === null){
            $month = date('m');
        }
        if($year === null){
            $year = date('Y');
        }
    //     if($month < 1 || $month > 12){
    //         throw new Exception(message:"Le mois $month doit être compris entre 1 et 12");
    //     }
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Return le 1er jour du mois
     *
     * @return \DateTime
     */
    public function getStartingDay(): \DateTime{
        // Le format DateTime est ("Y-m-d"), on choisit 01 pour le premier d
        return new \DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * Retourne le mois en toutes lettres
     *
     * @return string
     */
    public function toString(): string {
        // On récupére le tableau $months[] sachant que la première clef d'un tableau est [0] donc le numéro du mois en cours -1
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    /**
     * Calcul le nombre de semaines dans le mois. 
     * Vaut 6 quand le 1er jour de janvier est sur la dernière semaine 
     * ou le dernier jour de Décembre sur la 1ere semaine de l'année suivante
     *
     * @return integer
     */
    public function getWeeks(): int {
        $start = $this->getStartingDay();
        // On clone $start pour ne pas l'écraser et on rajoute un mois moins un jour pour avoir le dernier jour du mois.
        $end = (clone $start)->modify('+1month -1day');
        //
        // var_dump(intVal($start->format('W')));
        $weeks =  (intVal($end->format('W')) - intVal($start->format('W'))) +1;
        if ($weeks < 0){
            // $weeks = intVal($end->format('W'));
            $weeks = 6;
        }
        return $weeks;
    }

    /**
     * Est ce que ce jour est dans l'ANNEE et MOIS en cours (===) ou est ce avant ou après le mois en cours?
     *
     * @param \DateTime $date
     * @return boolean
     */
    public function withinMonth(\DateTime $date): bool{
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Renvoie le mois suivant
     *
     * @return Month
     */
    public function nextMonth(): Month{
        $month = $this->month + 1;
        $year = $this->year;
        if ($month>12){
            $month=1;
            $year += 1;
        }
        return new Month($month, $year);
    }
    
    /**
     * Renvoie le mois précédent
     *
     * @return Month
     */
    public function previousMonth(): Month{
        $month = $this->month - 1;
        $year = $this->year;
        if ($month<1){
            $month=12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
}