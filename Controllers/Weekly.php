<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use App\com_zeapps_crm\Models\Invoice\Invoices;



class Weekly extends Controller
{
    public function index() {
        $data = array();
        return view("weekly/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }


    private function getIsoWeeksInYear($year) {
        $date = new \DateTime;
        $date->setISODate($year, 53);
        return ($date->format("W") === "53" ? 53 : 52);
    }

    private function getStartAndEndDate($week, $year) {
        $ret = [];
        $dto = new \DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
    }

    private function getStartAndEndDateFR($week, $year) {
        $ret = [];
        $dto = new \DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('d/m/Y');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('d/m/Y');
        return $ret;
    }

    public function get(Request $request)
    {
        $data = [];
        $currentWeek = (int)date('W');
        $currentYear = (int)date('Y');



        // détermine la semaine de début d'analyse
        $anneeAnalyse = (int)date('Y')-1 ;
        $semaineAnalyse = (int)date('W') ;

        if ($semaineAnalyse == 53 && $this->getIsoWeeksInYear($anneeAnalyse) == 52) {
            $anneeAnalyse++;
            $semaineAnalyse = 1 ;
        }



        $onContinue = true ;
        $totalMoyenneCA = 0 ;
        $totalMoyenneCASansQInc = 0 ;
        $nbSemaineMoyenneCA = 0 ;


        while ($onContinue) {
            $semaineAnalyse++;

            if ($semaineAnalyse == $this->getIsoWeeksInYear($anneeAnalyse)) {
                $anneeAnalyse++;
                $semaineAnalyse = 1 ;
            }


            $tabDate = $this->getStartAndEndDate($semaineAnalyse, $anneeAnalyse) ;
            $tabDateFR = $this->getStartAndEndDateFR($semaineAnalyse, $anneeAnalyse) ;
            $tabDateNMoins1 = $this->getStartAndEndDate($semaineAnalyse, $anneeAnalyse-1) ;


            $qInc = 0 ;
            $particuliers = 0 ;
            $salons = 0 ;
            $boutiques = 0 ;
            $total = 0 ;
            $totalSansQInc = 0 ;
            $totalNMoins1 = 0 ;
            $totalNMoins1SansQInc = 0 ;
            $moyenneCA = 0 ;
            $moyenneCASansQInc = 0 ;


            // Recherche les factures
            $invoices = Invoices::where("date_creation", ">=", $tabDate['week_start'] . " 00:00:00")
                ->where("date_creation", "<=", $tabDate['week_end'] . " 23:59:59")
                ->get();


            $invoicesNMoins1 = Invoices::where("date_creation", ">=", $tabDateNMoins1['week_start'] . " 00:00:00")
                ->where("date_creation", "<=", $tabDateNMoins1['week_end'] . " 23:59:59")
                ->get();

            foreach ($invoicesNMoins1 as $invoice) {
                $totalNMoins1 += $invoice->total_ht ;
                if ($invoice->id_company != 1389) {
                    $totalNMoins1SansQInc += $invoice->total_ht;
                }
            }

            foreach ($invoices as $invoice) {
                $total += $invoice->total_ht ;

                if ($invoice->id_company == 1389) {
                    $qInc += $invoice->total_ht;
                } elseif ($invoice->id_origin == 3) { // salons
                    $salons += $invoice->total_ht;
                } elseif ($invoice->id_company == 0) {
                    $particuliers += $invoice->total_ht;
                } else {
                    $boutiques += $invoice->total_ht;
                }
            }


            $totalSansQInc = $total - $qInc ;
            $totalMoyenneCA += $total ;
            $totalMoyenneCASansQInc += $totalSansQInc ;
            $nbSemaineMoyenneCA++;

            $moyenneCA = $totalMoyenneCA / $nbSemaineMoyenneCA ;
            $moyenneCASansQInc = $totalMoyenneCASansQInc / $nbSemaineMoyenneCA ;

            $data[] = array("semaine" => $anneeAnalyse . "-" . $semaineAnalyse,
                "semaine_date"=> $tabDateFR["week_start"] . " au " . $tabDateFR["week_end"],
                "qInc" => number_format($qInc, 2, ",", " "),
                "particuliers" => number_format($particuliers, 2, ",", " "),
                "salons" => number_format($salons, 2, ",", " "),
                "boutiques" => number_format($boutiques, 2, ",", " "),
                "total" => number_format($total, 2, ",", " "),
                "totalSansQInc" => number_format($totalSansQInc, 2, ",", " "),
                "totalNMoins1" => number_format($totalNMoins1, 2, ",", " "),
                "totalNMoins1SansQInc" => number_format($totalNMoins1SansQInc, 2, ",", " "),
                "moyenneCA" => number_format($moyenneCA, 2, ",", " "),
                "moyenneCASansQInc" => number_format($moyenneCASansQInc, 2, ",", " "));

            if ($anneeAnalyse == $currentYear && $semaineAnalyse == $currentWeek) {
                $onContinue = false ;
            }
        }

        echo json_encode($data);
    }
}