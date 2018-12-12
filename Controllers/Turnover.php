<?php

namespace App\com_zeapps_crm_stats\Controllers;

use App\com_zeapps_crm\Models\Invoice\Invoices;
use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Illuminate\Database\Capsule\Manager as Capsule;

use App\com_zeapps_crm\Models\Invoice;

class Turnover extends Controller
{
    public function index()
    {
        $data = array();
        return view("turnover/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart()
    {
        $data = array();
        return view("turnover/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history()
    {
        $data = array();
        return view("turnover/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function get(Request $request)
    {
        $year = $request->input('year', 0);
        $context = $request->input('context', 0);


        if (!$year) {
            $year = intval(date('Y'));
        }
        $labels = [];

        $total = [
            [],
            []
        ];

        for ($month = 1; $month <= 12; $month++) {
            $k = $month - 1;

            $dateObj = \DateTime::createFromFormat('!m', $month);
            $labels[] = $dateObj->format('M'); // March

            $total[0][$k] = 0;
            $total[1][$k] = 0;




            $invoice = Invoices::select(Capsule::raw('SUM(total_ht) as total_ht'), Capsule::raw('YEAR(date_creation) as annee'))
                ->whereYear("date_creation", $year)
                ->whereMonth("date_creation", $month)
                ->where("finalized", 1)
                ->groupBy("annee")
                ->first();

            if ($invoice) {
                $total[0][$k] = $invoice->total_ht;
            }



            $invoice = Invoices::select(Capsule::raw('SUM(total_ht) as total_ht'), Capsule::raw('YEAR(date_creation) as annee'))
                ->whereYear("date_creation", $year-1)
                ->whereMonth("date_creation", $month)
                ->where("finalized", 1)
                ->groupBy("annee")
                ->first();

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