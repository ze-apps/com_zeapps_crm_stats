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

class Customer extends Controller
{
    public function index()
    {
        $data = array();
        return view("customer/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history()
    {
        $data = array();
        return view("customer/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    private function getData() {
        $filters = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }


        $dateDebut = null ;
        $dateFin = null ;


        $type_client = "" ;
        if (isset($filters['type_client'])) {
            $type_client = $filters['type_client'] ;
            unset($filters['type_client']);
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



        // type_client



        if (!$dateDebut && !$dateFin) {
            $dateDebut = date("Y") . "-01-01" ;
            $dateFin = date("Y") . "-12-31" ;
        }


        $labels = [];
        $total = [
            []
        ];






        $invoices = Invoices::where("finalized", 1) ;




        if ($type_client == 1) {
            $invoices = $invoices->where("id_company", 0) ;
        } elseif ($type_client == 2)  {
            $invoices = $invoices->where("id_company", "!=", 0) ;
        }

        $invoices = $invoices->select(Capsule::raw('SUM(total_ht) as total_ht, name_company, name_contact')) ;
        if ($type_client == 1) {
            $invoices = $invoices->groupBy(Capsule::raw('id_contact'));
        } elseif ($type_client == 2) {
            $invoices = $invoices->groupBy(Capsule::raw('id_company'));
        } else {
            $invoices = $invoices->groupBy(Capsule::raw('id_company, id_contact'));
        }

        $invoices = $invoices->orderBy(Capsule::raw('name_company, name_contact'));



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

            $nomLabel = $invoice->name_company ;
            if ($nomLabel != "" && $invoice->name_contact != "") {
                $nomLabel .= " - " ;
            }
            $nomLabel .= $invoice->name_contact ;

            $labels[] = $nomLabel ;

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


        return array(
            'infoSerie' => $serie_label,
            'total' => $total,
            'labels' => $labels
        );
    }

    public function get(Request $request)
    {
        echo json_encode($this->getData());
    }

    public function getExcel() {
        $data = $this->getData() ;

        $infoSerie = $data["infoSerie"];
        $total = $data["total"];
        $labels = $data["labels"];

        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Clients" . $infoSerie);
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "Total");

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

        $xlsxFilePath = Storage::getFolder("stats") . 'client.xlsx';
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save(BASEPATH . $xlsxFilePath);

        echo json_encode($xlsxFilePath);
    }
}