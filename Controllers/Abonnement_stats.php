<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

class Abonnement_stats extends Controller
{
    public function index(){
        $data = array();
        return view("abonnement/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart(){
        $data = array();
        return view("abonnement/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history(){
        $data = array();
        return view("abonnement/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function get($year = 0, $context = false){
        $this->load->model("com_quiltmania_abonnements", "abonnements", "com_quiltmania_abonnement");
        $this->load->model("com_quiltmania_statistique_abonnements", "stat_abonnements");
        $this->load->model("Com_quiltmania_publications", "publications", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_statistique_key_markets", "key_markets");

        $filters = array();
        $filters_abo = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
            $filters_abo = json_decode(file_get_contents('php://input'), true);

            if(isset($filters['year'])) unset($filters['year']);
            if(isset($filters_abo['year'])) unset($filters_abo['year']);
            if(isset($filters['id_market'])){
                unset($filters['id_market']);
            }
            if(isset($filters_abo['id_market'])){
                if($market = $this->key_markets->get($filters_abo['id_market'])) {
                    $filters_abo['country_id'] = array_keys(json_decode($market->countries, true));
                }
                unset($filters_abo['id_market']);
            }
            if(isset($filters_abo['com_quiltmania_publications.label LIKE'])){
                $filters_abo['label_publication LIKE'] = $filters_abo['com_quiltmania_publications.label LIKE'];
                unset($filters_abo['com_quiltmania_publications.label LIKE']);
            }
            if(isset($filters_abo['id'])){
                $filters_abo['id_publication'] = $filters_abo['id'];
                unset($filters_abo['id']);
            }
        }

        if($context) {
            $key_markets = $this->key_markets->all();
        }
        else{
            $key_markets = [];
        }

        $totals = [];

        $c_year = intval(date('Y'));
        $year_diff = $c_year - intval($year);

        if($publications = $this->publications->all($filters)){
            foreach($publications as $publication){
                if(!isset($totals[$publication->id])) {
                    $totals[$publication->id] = [];
                }

                $start = intval($publication->numero_en_cours) - ($year_diff * 6);
                if($start < 0) $start = 0;

                $first = intval($start) - 10;
                if($first < 0) $first = 0;

                $last = intval($start) + 10;

                $filters_abo['id_publication'] = $publication->id;
                for($i = $first; $i <= $last; $i++){
                    if(!isset($totals[$publication->id][$i])) {
                        $totals[$publication->id][$i] = 0;
                    }

                    $filters_abo['num_debut <='] = $i;
                    $filters_abo['num_fin >='] = $i;

                    if($total = $this->stat_abonnements->count($filters_abo)){
                        $totals[$publication->id][$i] += $total;
                    }
                }
            }
        }


        echo json_encode(array(
            "totals" => $totals,
            "publications" => $publications,
            "key_markets" => $key_markets
        ));
    }
}