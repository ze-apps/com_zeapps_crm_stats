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


        if (!isset($filters['year'])) {
            $filters['year'] = intval(date('Y'));
        }


        $labels = [];
        $total = [
            [],
            []
        ];

        for ($month = 1; $month <= 12; $month++) {
            $k = $month - 1;

            $dateObj = \DateTime::createFromFormat('!m', $month);
            $labels[] = __t($dateObj->format('M'));

            $total[0][$k] = 0;
            $total[1][$k] = 0;


            $invoice = Invoices::select(Capsule::raw('SUM(total_ht) as total_ht'), Capsule::raw('YEAR(date_creation) as annee'))
                ->whereYear("date_creation", $filters['year'])
                ->whereMonth("date_creation", $month)
                ->where("finalized", 1)
                ->groupBy("annee");

            foreach ($filters as $key => $value) {
                if ($key == "year") {

                } elseif (strpos($key, " LIKE") !== false) {
                    $key = str_replace(" LIKE", "", $key);
                    $invoice = $invoice->where($key, 'like', '%' . $value . '%');
                } elseif (strpos(strtolower($key), " in") !== false) {
                    $tabKey = explode(" ", $key);
                    $invoice = $invoice->whereIn($tabKey[0], explode(",", $value));
                } elseif (strpos($key, " ") !== false) {
                    $tabKey = explode(" ", $key);
                    $invoice = $invoice->where($tabKey[0], $tabKey[1], $value);
                } else {
                    $invoice = $invoice->where($key, $value);
                }
            }
            $invoice = $invoice->first();

            if ($invoice) {
                $total[0][$k] = $invoice->total_ht;
            }


            $invoice = Invoices::select(Capsule::raw('SUM(total_ht) as total_ht'), Capsule::raw('YEAR(date_creation) as annee'))
                ->whereYear("date_creation", $filters['year'] - 1)
                ->whereMonth("date_creation", $month)
                ->where("finalized", 1)
                ->groupBy("annee");

            foreach ($filters as $key => $value) {
                if ($key == "year") {

                } elseif (strpos($key, " LIKE") !== false) {
                    $key = str_replace(" LIKE", "", $key);
                    $invoice = $invoice->where($key, 'like', '%' . $value . '%');
                } elseif (strpos(strtolower($key), " in") !== false) {
                    $tabKey = explode(" ", $key);
                    $invoice = $invoice->whereIn($tabKey[0], explode(",", $value));
                } elseif (strpos($key, " ") !== false) {
                    $tabKey = explode(" ", $key);
                    $invoice = $invoice->where($tabKey[0], $tabKey[1], $value);
                } else {
                    $invoice = $invoice->where($key, $value);
                }
            }
            $invoice = $invoice->first();

            if ($invoice) {
                $total[1][$k] = $invoice->total_ht;
            }


            // TODO : intégrer les ventes des distributeurs
            // TODO : intégrer les ventes des distributeurs
            // TODO : intégrer les ventes des distributeurs
            // TODO : intégrer les ventes des distributeurs
            // TODO : intégrer les ventes des distributeurs
            // TODO : intégrer les ventes des distributeurs

        }

        echo json_encode(array(
            'total' => $total,
            'labels' => $labels
        ));
    }
}