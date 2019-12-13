<?php

namespace App\com_zeapps_crm_stats\Controllers;

use App\com_zeapps_crm\Models\Invoice\Invoices;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Illuminate\Database\Capsule\Manager as Capsule;

use App\com_zeapps_crm\Models\Invoice;
use Zeapps\Core\Storage;

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

    private function getData() {
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
        $premierJour->sub(new \DateInterval('P1M'));
        $premierJour->sub(new \DateInterval('P' . ($periodicity*12) . 'M'));
        $indexCA = -1 ;
        for($month=12;$month>=1;$month--) {
            $indexCA++;

            $premierJour->add(new \DateInterval('P' . $periodicity . 'M'));

            $premmierJourPeriode = clone $premierJour;
            $premmierJourPeriode->sub(new \DateInterval('P12M'));
            $premmierJourPeriode->add(new \DateInterval('P1M'));

            $dernierJour = clone $premierJour;
            $dernierJour->add(new \DateInterval('P1M'));
            $dernierJour->sub(new \DateInterval('P1D'));


            $labels[] = __t($dernierJour->format('M')) . " " . $dernierJour->format('Y');

            $total[0][$indexCA] = 0;


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
                    if (strpos($value, "-")!== false) {
                        $invoice = $invoice->whereNotIn($tabKey[0], explode(",", str_replace("-","", $value)));
                    } else {
                        $invoice = $invoice->whereIn($tabKey[0], explode(",", $value));
                    }
                } elseif (strpos($key, " ") !== false) {
                    $tabKey = explode(" ", $key);
                    $invoice = $invoice->where($tabKey[0], $tabKey[1], $value);
                } else {
                    $invoice = $invoice->where($key, $value);
                }
            }
            $invoice = $invoice->first();

            if ($invoice) {
                $total[0][$indexCA] = $invoice->total_ht;
            }
        }

        return array(
            'total' => $total,
            'labels' => $labels
        );
    }

    public function get()
    {
        echo json_encode($this->getData());
    }

    public function getExcel() {
        $data = $this->getData() ;
        $total = $data["total"];
        $labels = $data["labels"];

        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Mois");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "Horizon glissant");

        $nLigne = 1 ;
        foreach ($labels as $keyLabel => $label) {
                $nLigne++;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $nLigne, $label);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $nLigne, $total[0][$keyLabel]);

                $objPHPExcel->getActiveSheet()->getStyle('B' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
        }


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);



        // header
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray($styleArray);



        // bordure
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $objPHPExcel->getActiveSheet()->getStyle('A1:B' . $nLigne)->applyFromArray($styleArray);

        $xlsxFilePath = Storage::getFolder("stats") . 'horizon-glissant.xlsx';
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save(BASEPATH . $xlsxFilePath);

        echo json_encode($xlsxFilePath);
    }
}