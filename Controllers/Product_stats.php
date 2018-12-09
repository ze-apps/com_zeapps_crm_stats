<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

class Product_stats extends Controller
{
    public function index(){
        $data = array();
        return view("product/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart(){
        $data = array();
        return view("product/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history(){
        $data = array();
        return view("product/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }



    public function get($id_parent = 0, $year = false, $context = false){
        $this->load->model("Zeapps_product_categories", "categories", "com_zeapps_crm");
        $this->load->model("Zeapps_product_products", "products", "com_zeapps_crm");
        $this->load->model("Zeapps_crm_origins", "crm_origins", "com_zeapps_crm");
        $this->load->model("Com_quiltmania_statistique_key_markets", "key_markets");

        if(!$year) $year = intval(date('Y'));

        $category = $this->categories->get($id_parent);

        $filters = array() ;

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

        if($categories = $this->categories->all(array('id_parent' => $id_parent))){
            foreach($categories as $cat){
                $ids = $this->categories->getSubCatIds_r($cat->id);
                $filters['id_cat'] = $ids;
                $cat->total_ht = [];
                if($sums = $this->categories->turnover($year, $filters)){
                    foreach($sums as $sum){
                        if($sum->year == $year){
                            $cat->total_ht[0] += floatval($sum->total_ht);
                        }
                        elseif($sum->year == ($year - 1)){
                            $cat->total_ht[1] += floatval($sum->total_ht);
                        }
                    }
                }
                else{
                    $cat->total_ht[0] = 0;
                    $cat->total_ht[1] = 0;
                }

                if($cat->total_ht[0] < 0) $cat->total_ht[0] = 0;
                if($cat->total_ht[1] < 0) $cat->total_ht[1] = 0;
            }
        }
        else{
            $categories = [];
        }

        if($id_parent !== "0")
            $filters['id_cat'] = $this->categories->getSubCatIds_r($id_parent);
        else{
            unset($filters['id_cat']);
        }

        $products = [];
        if(!$products[0] = $this->products->top10($year, $filters)){
            $products[0] = [];
        }
        if(!$products[1] = $this->products->top10($year - 1, $filters)){
            $products[1] = [];
        }

        if($context){
            $canaux = [
                ['id' => 0, "label" => 'Distributeurs']
            ];

            if($lines = $this->crm_origins->all()){
                foreach($lines as $line){
                    $canaux[] = ['id' => $line->id, "label" => $line->label];
                }
            }

            $key_markets = $this->key_markets->all();
        }
        else{
            $canaux = [];
            $key_markets = [];
        }

        echo json_encode(array(
            "category" => $category,
            "categories" => $categories,
            "products" => $products,
            "canaux" => $canaux,
            "key_markets" => $key_markets
        ));
    }
}