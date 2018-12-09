<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

class Turnover extends Controller
{
    public function index(){
        $data = array();
        return view("turnover/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart(){
        $data = array();
        return view("turnover/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history(){
        $data = array();
        return view("turnover/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function get($year = false, $context = false){
        $this->load->model("Com_quiltmania_distributeur_ventes", "distributeur_ventes");
        $this->load->model("Zeapps_invoices", "invoices", "com_zeapps_crm");
        $this->load->model("Zeapps_crm_origins", "crm_origins", "com_zeapps_crm");

        if(!$year) $year = intval(date('Y'));
        $labels = [];

        $total = [
            [],
            []
        ];

        for($month = 1; $month <= 12; $month++){
            $k = $month - 1;

            $dateObj   = DateTime::createFromFormat('!m', $month);
            $labels[] = $dateObj->format('M'); // March

            $total[0][$k] = 0;
            $total[1][$k] = 0;

            if($lines = $this->distributeur_ventes->getByMonth($year - 1, $month)){
                foreach($lines as $line){
                    $total[1][$k] += floatval($line->ca);
                }
            }

            if($lines = $this->distributeur_ventes->getByMonth($year, $month)){
                foreach($lines as $line){
                    $total[0][$k] += floatval($line->ca);
                }
            }
        }

        if($sums = $this->invoices->turnover($year)){
            foreach($sums as $sum){
                if($sum->year == $year){
                    $total[0][intval($sum->month)] += floatval($sum->total_ht);
                }
                elseif($sum->year == ($year - 1)){
                    $total[1][intval($sum->month)] += floatval($sum->total_ht);
                }
            }
        }

        echo json_encode(array(
            'total' => $total,
            'labels' => $labels
        ));
    }
}