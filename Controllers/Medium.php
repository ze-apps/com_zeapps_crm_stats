<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

class Medium extends Controller
{
    public function index(){
        $data = array();
        return view("medium/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart(){
        $data = array();
        return view("medium/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history(){
        $data = array();
        return view("medium/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }


    public function get($id_parent = 0, $year = false, $context = false){
        $this->load->model("Zeapps_product_categories", "categories", "com_zeapps_crm");
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

        $canaux = [];
        $total_categories = [];

        $crm_origins = [];
        if($origins = $this->crm_origins->all()){
            foreach($origins as $line){
                $canaux[] = $line->label;
                $crm_origins[$line->id] = $line->label;
            }
        }

        $category = $this->categories->get($id_parent);

        if($categories = $this->categories->all(array('id_parent' => $id_parent))){
            foreach($categories as $cat){
                if($this->categories->all(array('id_parent' => $cat->id))){
                    $cat->has_childrens = true;
                }

                foreach($canaux as $canal) {
                    $total_categories[$cat->id][$canal] = [0,0];
                }
            }
        }
        else{
            $categories = [];
        }

        if($id_parent !== "0")
            $filters['id_cat'] = $this->categories->getSubCatIds_r($id_parent);

        if($sums = $this->categories->turnover_details($year, $filters)){
            foreach($sums as $sum){
                if($sum->year == $year){
                    $total_categories[$sum->id_cat][$crm_origins[$sum->id_origin]][0] += floatval($sum->total_ht);
                }
                elseif($sum->year == ($year - 1)){
                    $total_categories[$sum->id_cat][$crm_origins[$sum->id_origin]][1] += floatval($sum->total_ht);
                }
            }
        }

        echo json_encode(array(
            "category" => $category,
            "categories" => $categories,
            "total_categories" => $total_categories,
            "canaux" => $canaux,
            "key_markets" => $key_markets
        ));
    }
}