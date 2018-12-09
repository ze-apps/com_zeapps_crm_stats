<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

class Key_market extends Controller
{
    public function config(){
        $data = array();
        return view("key_markets/config", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function config_form(){
        $data = array();
        return view("key_markets/config_form", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }



    public function get($id){
        $this->load->model("com_quiltmania_statistique_key_markets", "key_markets");

        $key_market = $this->key_markets->get($id);

        echo json_encode(array(
            "key_market" => $key_market
        ));
    }

    public function get_all(){
        $this->load->model("com_quiltmania_statistique_key_markets", "key_markets");

        if(!$key_markets = $this->key_markets->all()){
            $key_markets = [];
        }

        echo json_encode(array(
            "key_markets" => $key_markets
        ));
    }

    public function save(){
        $this->load->model("com_quiltmania_statistique_key_markets", "key_markets");

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
            $this->key_markets->update($data, $id);
        }
        else{
            $id = $this->key_markets->insert($data);
        }

        echo $id;
    }

    public function delete($id){
        $this->load->model("com_quiltmania_statistique_key_markets", "key_markets");

        echo json_encode($this->key_markets->delete($id));
    }
}