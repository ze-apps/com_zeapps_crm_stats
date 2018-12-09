<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

class Distributeur_ventes extends Controller
{
    public function view()
    {
        $data = array();
        return view("distributeur_ventes/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function form_modal()
    {
        $data = array();
        return view("distributeur_ventes/form_modal", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function form_modal_edit()
    {
        $data = array();
        return view("distributeur_ventes/form_modal_edit", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }






    public function get_all($limit = 15, $offset = 0, $context = false){
        $this->load->model("Com_quiltmania_distributeur_ventes", "distributeur_ventes");
        $this->load->model("Com_quiltmania_publications", "publications", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_distributeurs", "distributeurs");


        $filters = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }

        if(!$distributeur_ventes = $this->distributeur_ventes->all($filters, $limit, $offset)){
            $distributeur_ventes = [];
        }

        $total = $this->distributeur_ventes->count($filters);

        if($context){
            $publications = $this->publications->all();
            $distributeurs = $this->distributeurs->all();
        }
        else{
            $publications = [];
            $distributeurs = [];
        }

        echo json_encode(array(
            'distributeur_ventes' => $distributeur_ventes,
            'total' => $total,
            'publications' => $publications,
            'distributeurs' => $distributeurs
        ));
    }

    public function get($id = null){
        $this->load->model("Com_quiltmania_distributeur_ventes", "distributeur_ventes");
        $this->load->model("Com_quiltmania_publications", "publications", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_distributeurs", "distributeurs");
        $this->load->model("Zeapps_country", "countries");

        if($id) {
            $vente = $this->distributeur_ventes->get($id);
        }
        else{
            $vente = '';
        }

        $publications = $this->publications->all();
        $distributeurs = $this->distributeurs->all();
        $countries = $this->countries->all();

        echo json_encode(array('vente' => $vente, 'publications' => $publications, 'distributeurs' => $distributeurs, 'countries' => $countries));
    }

    public function save(){
        $this->load->model("Com_quiltmania_distributeur_ventes", "distributeur_ventes");

        // constitution du tableau
        $data = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if($data['id']){
            $id = $data['id'];
            $this->distributeur_ventes->update($data, $id);
        }
        else{
            foreach($data['lines'] as $id_country => $line){
                if($line['total'] > 0) {
                    $vente = array(
                        'id_distributeur' => $data['id_distributeur'],
                        'name_distributeur' => $data['name_distributeur'],
                        'id_publication' => $data['id_publication'],
                        'name_publication' => $data['name_publication'],
                        'num_publication' => $data['num_publication'],
                        'date' => $data['date'],
                        'id_country' => $id_country,
                        'total' => $line['total'],
                        'sold' => $line['sold'],
                        'ca' => $line['ca']
                    );
                    $id = $this->distributeur_ventes->insert($vente);
                }
            }
        }

        echo $id;
    }

    public function delete($id = null){
        $this->load->model("Com_quiltmania_distributeur_ventes", "distributeur_ventes");

        $res = $this->distributeur_ventes->delete($id);

        echo json_encode($res);
    }
}