<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

class Market extends Controller
{
    public function index(){
        $data = array();
        return view("market/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart(){
        $data = array();
        return view("market/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history(){
        $data = array();
        return view("market/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function get($year = false, $context = false){
        $this->load->model("Com_quiltmania_distributeur_ventes", "distributeur_ventes");
        $this->load->model("Zeapps_invoices", "invoices", "com_zeapps_crm");
        $this->load->model("Zeapps_crm_origins", "crm_origins", "com_zeapps_crm");
        $this->load->model("Com_quiltmania_statistique_key_markets", "key_markets");

        $filters = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);

            if(isset($filters['year'])) unset($filters['year']);
            if(isset($filters['id_market'])){
                if($market = $this->key_markets->get($filters['id_market'])) {
                    $filters['country_id'] = array_keys(json_decode($market->countries, true));
                }
                unset($filters['id_market']);
            }
        }

        if($context) {
            $key_markets = $this->key_markets->all();
        }
        else{
            $key_markets = [];
        }

        if(!$year) $year = intval(date('Y'));
        $labels = [];

        $total = [
            [],
            []
        ];

        $canaux = [
            'Distributeurs' => [0,0]
        ];

        $crm_origins = [];
        if($lines = $this->crm_origins->all()){
            foreach($lines as $line){
                $canaux[$line->label] = [0,0];
                $crm_origins[$line->id] = $line->label;
            }
        }

        for($month = 1; $month <= 12; $month++){
            $k = $month - 1;

            $dateObj   = DateTime::createFromFormat('!m', $month);
            $labels[] = $dateObj->format('M'); // March

            $total[0][$k] = 0;
            $total[1][$k] = 0;

            if($lines = $this->distributeur_ventes->getByMonth($year - 1, $month)){
                foreach($lines as $line){
                    $total[1][$k] += floatval($line->ca);
                    $canaux['Distributeurs'][1] += floatval($line->ca);
                }
            }

            if($lines = $this->distributeur_ventes->getByMonth($year, $month)){
                foreach($lines as $line){
                    $total[0][$k] += floatval($line->ca);
                    $canaux['Distributeurs'][0] += floatval($line->ca);
                }
            }
        }

        foreach($crm_origins as $id_origin => $label){
            $filters['id_origin'] = $id_origin;
            if($sums = $this->invoices->turnover($year, $filters)){
                foreach($sums as $sum){
                    if($sum->year == $year){
                        $total[0][intval($sum->month)] += floatval($sum->total_ht);
                        $canaux[$label][0] += floatval($sum->total_ht);
                    }
                    elseif($sum->year == ($year - 1)){
                        $total[1][intval($sum->month)] += floatval($sum->total_ht);
                        $canaux[$label][1] += floatval($sum->total_ht);
                    }
                }
            }
        }

        echo json_encode(array(
            'total' => $total,
            'canaux' => $canaux,
            'labels' => $labels,
            "key_markets" => $key_markets
        ));
    }
}