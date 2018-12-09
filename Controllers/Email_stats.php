<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

class Email_stats extends Controller
{
    public function index(){
        $data = array();
        return view("email/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart(){
        $data = array();
        return view("email/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history(){
        $data = array();
        return view("email/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function get($year = false, $context = false){
        $this->load->model("Zeapps_contacts", "contacts", "com_zeapps_contact");
        $this->load->model("Com_quiltmania_marketing_contacts", "marketing_contacts", "com_quiltmania_marketing");
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

        $total = [];

        $where = array("created_at <" => $year."-01-01 00:00:00", "email !=" => "");
        if(isset($filters['country_id'])){
            $where['country_id'] = $filters['country_id'];
        }

        $init = 0;
        $lines = $this->contacts->count($where);
        $init += $lines;
        $lines = $this->marketing_contacts->count($where);
        $init += $lines;

        for($month = 1; $month <= 12; $month++){
            $k = $month - 1;

            $dateObj   = DateTime::createFromFormat('!m', $month);
            $labels[] = $dateObj->format('M'); // March

            $total[$k] = isset($total[$k - 1]) ? $total[$k - 1] : $init;

            if($emails = $this->contacts->getEmailsByMonth($filters, $year, $month)){
                $total[$k] += $emails[0]->total;
            }

            if($emails = $this->marketing_contacts->getEmailsByMonth($filters, $year, $month)){
                $total[$k] += $emails[0]->total;
            }
        }

        echo json_encode(array(
            'total' => $total,
            'labels' => $labels,
            "key_markets" => $key_markets
        ));
    }
}