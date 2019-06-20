<?php

namespace App\com_zeapps_crm_stats\Controllers;

use App\com_zeapps_crm\Models\Invoice\Invoices;
use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Illuminate\Database\Capsule\Manager as Capsule;

use App\com_zeapps_crm\Models\Invoice;

class FlowingHorizon extends Controller
{
    public function index()
    {
        $data = array();
        return view("flowing-horizon/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart()
    {
        $data = array();
        return view("flowing-horizon/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history()
    {
        $data = array();
        return view("flowing-horizon/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
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


        $periodicity = 1 ;
        if (isset($filters['periodicity'])) {
            $periodicity = $filters['periodicity'] ;
            unset($filters['periodicity']);
        }




        $labels = [];
        $total = [
            []
        ];



        // calcul la date de de début d'analyse
        $premierJour = new \DateTime("first day of this month");
        for($month=1;$month<=12;$month++) {
            if ($month == 1) {
                $premierJour->sub(new \DateInterval('P1M'));
            } else {
                $premierJour->sub(new \DateInterval('P' . $periodicity . 'M'));
            }

            $premmierJourPeriode = clone $premierJour;
            $premmierJourPeriode->sub(new \DateInterval('P12M'));
            $premmierJourPeriode->add(new \DateInterval('P1M'));

            $dernierJour = clone $premierJour;
            $dernierJour->add(new \DateInterval('P1M'));
            $dernierJour->sub(new \DateInterval('P1D'));

            //echo $premmierJourPeriode->format('d/m/Y') . " - " . $dernierJour->format('d/m/Y') . "<br>";


            $k = $month - 1;

            $labels[] = __t($dernierJour->format('M')) . " " . $dernierJour->format('Y');

            $total[0][$k] = 0;


            $invoice = Invoices::select(Capsule::raw('SUM(total_ht) as total_ht'))
                ->where("date_creation", ">=", $premmierJourPeriode->format('Y-m-d'))
                ->where("date_creation", "<=", $dernierJour->format('Y-m-d'))
                ->where("finalized", 1)
            ;

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