<?php

namespace App\com_zeapps_crm_stats\Controllers;

use App\com_zeapps_crm\Models\Invoice\Invoices;
use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Illuminate\Database\Capsule\Manager as Capsule;

use App\com_zeapps_crm\Models\Invoice;

class SalesFigures extends Controller
{
    public function index()
    {
        $data = array();
        return view("sales-figures/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart()
    {
        $data = array();
        return view("sales-figures/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history()
    {
        $data = array();
        return view("sales-figures/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function get(Request $request)
    {
        $filters = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }


        $dateDebut = null ;
        $dateFin = null ;


        $type_view = "month" ;
        if (isset($filters['type_view'])) {
            $type_view = $filters['type_view'] ;
            unset($filters['type_view']);
        }


        if (isset($filters['date_sales >='])) {
            if (trim($filters['date_sales >=']) != "") {
                $dateDebut = $filters['date_sales >='];
            }
            unset($filters['date_sales >=']);
        }


        if (isset($filters['date_sales <='])) {
            if (trim($filters['date_sales <=']) != "") {
                $dateFin = $filters['date_sales <='];
            }
            unset($filters['date_sales <=']);
        }




        if (!$dateDebut && !$dateFin) {
            $dateDebut = date("Y") . "-01-01" ;
            $dateFin = date("Y") . "-12-31" ;
        }


        $labels = [];
        $total = [
            []
        ];






        $invoices = Invoices::where("finalized", 1) ;


        if ($type_view == "week") {
            $invoices = $invoices->select(Capsule::raw('SUM(total_ht) as total_ht'), Capsule::raw('CONCAT(YEAR(date_creation), \'/\', DATE_FORMAT(date_creation, "%v")) as period')) ;
            $invoices = $invoices->groupBy(Capsule::raw('CONCAT(YEAR(date_creation), \'/\', DATE_FORMAT(date_creation, "%v"))'))
                ->orderBy(Capsule::raw('CONCAT(YEAR(date_creation), \'/\', DATE_FORMAT(date_creation, "%v"))')) ;

        } elseif ($type_view == "month") {
            $invoices = $invoices->select(Capsule::raw('SUM(total_ht) as total_ht'), Capsule::raw('CONCAT(YEAR(date_creation), \'/\', DATE_FORMAT(date_creation, "%m")) as period')) ;
            $invoices = $invoices->groupBy(Capsule::raw('CONCAT(YEAR(date_creation), \'/\', DATE_FORMAT(date_creation, "%m"))'))
                ->orderBy(Capsule::raw('CONCAT(YEAR(date_creation), \'/\', DATE_FORMAT(date_creation, "%m"))')) ;

        } elseif ($type_view == "year") {
            $invoices = $invoices->select(Capsule::raw('SUM(total_ht) as total_ht'), Capsule::raw('YEAR(date_creation) as period')) ;
            $invoices = $invoices->groupBy(Capsule::raw('YEAR(date_creation)'))
                ->orderBy(Capsule::raw('YEAR(date_creation)')) ;
        }





        if ($dateDebut) {
            $invoices = $invoices->where("date_creation", ">=", $dateDebut);
        }

        if ($dateFin) {
            $invoices = $invoices->where("date_creation", "<=", $dateFin);
        }

        foreach ($filters as $key => $value) {
            if ($key == "year") {

            } elseif (strpos($key, " LIKE") !== false) {
                $key = str_replace(" LIKE", "", $key);
                $invoices = $invoices->where($key, 'like', '%' . $value . '%');
            } elseif (strpos(strtolower($key), " in") !== false) {
                $tabKey = explode(" ", $key);
                if (strpos($value, "-")!== false) {
                    $invoices = $invoices->whereNotIn($tabKey[0], explode(",", str_replace("-","", $value)));
                } else {
                    $invoices = $invoices->whereIn($tabKey[0], explode(",", $value));
                }
            } elseif (strpos($key, " ") !== false) {
                $tabKey = explode(" ", $key);
                $invoices = $invoices->where($tabKey[0], $tabKey[1], $value);
            } else {
                $invoices = $invoices->where($key, $value);
            }
        }

        $invoices = $invoices->get();




        $indexArray = -1 ;
        foreach ($invoices as $invoice) {
            $indexArray++;

            $labels[] = $invoice->period ;

            $total[0][$indexArray] = $invoice->total_ht;
        }



        // affichage de l'info du nom de la série
        $serie_label = "" ;

        if ($dateDebut && $dateFin) {
            $serie_label .= " du " . date("d/m/Y", strtotime($dateDebut)) . " au " . date("d/m/Y", strtotime($dateFin)) ;
        } elseif ($dateDebut) {
            $serie_label .= " depuis le " . date("d/m/Y", strtotime($dateDebut)) ;
        } elseif ($dateFin) {
            $serie_label .= " jusqu'au " . date("d/m/Y", strtotime($dateFin)) ;
        }


        if ($type_view == "week") {
            $serie_label .= " - vue par semaine" ;
        } elseif ($type_view == "month") {
            $serie_label .= " - vue par mois" ;
        } elseif ($type_view == "year") {
            $serie_label .= " - vue par année" ;
        }




        echo json_encode(array(
            'infoSerie' => $serie_label,
            'total' => $total,
            'labels' => $labels
        ));
    }
}