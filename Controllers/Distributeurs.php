<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

class Distributeurs extends Controller
{
    public function index(){
        $data = array();
        return view("distributeur/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart(){
        $data = array();
        return view("distributeur/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history(){
        $data = array();
        return view("distributeur/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function config()
    {
        $data = array();
        return view("distributeur/config", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function config_form()
    {
        $data = array();
        return view("distributeur/config_form", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function get_stats($context = false){
        $this->load->model("Com_quiltmania_distributeur_ventes", "ventes");
        $this->load->model("Com_quiltmania_distributeurs", "distributeurs");
        $this->load->model("Com_quiltmania_publications", "publications", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_statistique_key_markets", "key_markets");

        $filters = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);

            if(isset($filters['id_market'])){
                if($market = $this->key_markets->get($filters['id_market'])) {
                    $filters['com_quiltmania_distributeur_ventes.id_country'] = array_keys(json_decode($market->countries, true));
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

        $ventes = [];
        if($distributeurs = $this->distributeurs->all()){
            foreach($distributeurs as $distributeur){
                $ventes[$distributeur->id] = array(
                    "name_distributeur" => $distributeur->label,
                    "ca" => 0,
                    "leftover" => 0,
                    "sold" => 0
                );
            }
        }

        if($res = $this->ventes->all($filters)) {
            foreach($res as $line){
                if(isset($ventes[$line->id_distributeur])){
                    $ventes[$line->id_distributeur]["ca"] += floatval($line->ca);
                    $ventes[$line->id_distributeur]["leftover"] += floatval($line->total) - floatval($line->sold);
                    $ventes[$line->id_distributeur]["sold"] += floatval($line->sold);
                }
                else{
                    $ventes[$line->id_distributeur] = array(
                        "name_distributeur" => $line->name_distributeur,
                        "ca" => floatval($line->ca),
                        "leftover" => floatval($line->total) - floatval($line->sold),
                        "sold" => floatval($line->sold)
                    );
                }
            }
        }

        if($context){
            $publications = $this->publications->all();
        }
        else{
            $publications = [];
        }

        echo json_encode(array(
            "ventes" => $ventes,
            "publications" => $publications,
            "key_markets" => $key_markets
        ));
    }

    public function get_all(){
        $this->load->model("Com_quiltmania_distributeurs", "distributeurs");

        $distributeurs = $this->distributeurs->all();

        echo json_encode($distributeurs);
    }

    public function get($id){
        $this->load->model("Com_quiltmania_distributeurs", "distributeurs");

        $distributeur = $this->distributeurs->get($id);

        echo json_encode($distributeur);
    }

    public function get_countries(){
        $this->load->model("Zeapps_country", "countries");

        $countries = $this->countries->all();

        echo json_encode($countries);
    }

    public function save(){
        $this->load->model("Com_quiltmania_distributeurs", "distributeurs");

        // constitution du tableau
        $data = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if($data['countries']){
            $data['countries'] = json_encode($data['countries']);
        }

        if($data['id']){
            $id = $data['id'];
            $this->distributeurs->update($data, $id);
        }
        else{
            $id = $this->distributeurs->insert($data);
        }

        echo $id;
    }

    public function delete($id = null){
        $this->load->model("Com_quiltmania_distributeurs", "distributeurs");

        $res = $this->distributeurs->delete($id);

        echo json_encode($res);
    }
}