<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use App\com_quiltmania\Models\Publications;
use App\com_quiltmania_abonnement\Models\AbonnementStats;

class Abonnement_stats extends Controller
{
    public function index()
    {
        $data = array();
        return view("abonnement/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart()
    {
        $data = array();
        return view("abonnement/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history()
    {
        $data = array();
        return view("abonnement/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function get($year = 0, $context = false)
    {
        $filters = array();
        $filters_abo = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
            $filters_abo = json_decode(file_get_contents('php://input'), true);

            if (isset($filters['year'])) {
                unset($filters['year']);
            }
            if (isset($filters_abo['year'])) {
                unset($filters_abo['year']);
            }


            if (isset($filters_abo['com_quiltmania_publications.label LIKE'])) {
                $filters_abo['label_publication LIKE'] = $filters_abo['com_quiltmania_publications.label LIKE'];
                unset($filters_abo['com_quiltmania_publications.label LIKE']);
            }

            if (isset($filters_abo['id'])) {
                $filters_abo['id_publication'] = $filters_abo['id'];
                unset($filters_abo['id']);
            }
        }







        $totals = [];


        $lignesAbonnement = AbonnementStats::get($filters) ;
        foreach ($lignesAbonnement as $ligneAbonnement) {
            if (!isset($totals[$ligneAbonnement->id_publication])) {
                $totals[$ligneAbonnement->id_publication] = [];
            }

            for ($numero = $ligneAbonnement->num_debut; $numero <= $ligneAbonnement->num_fin; $numero++) {
                if (!isset($totals[$ligneAbonnement->id_publication][$numero])) {
                    $totals[$ligneAbonnement->id_publication][$numero] = 0;
                }

                $totals[$ligneAbonnement->id_publication][$numero] += $ligneAbonnement->nb_abonnes;
            }
        }


        echo json_encode(array(
            "totals" => $totals
        ));
    }
}