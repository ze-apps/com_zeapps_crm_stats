<?php

namespace App\com_zeapps_crm_stats\Controllers;

use App\com_zeapps_crm\Models\Product\Products;
use Zeapps\Core\Controller;
use Zeapps\Core\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Zeapps\Core\Storage;

class Abonnement extends Controller
{
    public function index()
    {
        $data = array();
        return view("abonnement_info/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart()
    {
        $data = array();
        return view("abonnement_info/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history()
    {
        $data = array();
        return view("abonnement_info/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    private function getData(Request $request)
    {
        $id_parent = $request->input("id_parent", 0);

        $filters = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }





        // calcul les dates de début et de fin
        $dateDebut = null;
        $dateFin = null;
        $dateDebut_n_1 = null;
        $dateFin_n_1 = null;

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





        if (isset($filters['date_sales_n_1 >='])) {
            if (trim($filters['date_sales_n_1 >=']) != "") {
                $dateDebut_n_1 = $filters['date_sales_n_1 >='];
            }
            unset($filters['date_sales_n_1 >=']);
        }


        if (isset($filters['date_sales_n_1 <='])) {
            if (trim($filters['date_sales_n_1 <=']) != "") {
                $dateFin_n_1 = $filters['date_sales_n_1 <='];
            }
            unset($filters['date_sales_n_1 <=']);
        }


        if (!$dateDebut && !$dateFin) {
            $dateDebut = date("Y") . "-01-01";
            $dateFin = date("Y") . "-12-31";
        }






        unset($filters['id_cat']);

        $products = [];



        $traitementPossible = true;
        if ($dateDebut && \DateTime::createFromFormat('Y-m-d', $dateDebut) === FALSE) {
            $traitementPossible = false;
        } else {
            $date_dateDebut = strtotime($dateDebut);
            if (date("Y", $date_dateDebut) < 1900) {
                $traitementPossible = false;
            }
        }

        if ($dateFin && \DateTime::createFromFormat('Y-m-d', $dateFin) === FALSE) {
            $traitementPossible = false;
        } else {
            $date_dateFin = strtotime($dateFin);
            if (date("Y", $date_dateFin) < 1900) {
                $traitementPossible = false;
            }
        }

        if (!$dateDebut && !$dateFin) {
            $traitementPossible = false;
        }

        if ($traitementPossible) {
            //            if (!$products[0] = Products::top10($dateDebut, $dateFin, $filters, 0, true)) {
            //                $products[0] = [];
            //            }
            $products[0] = [];
            if ($autresProduits = Products::top10Autre($dateDebut, $dateFin, $filters, 0, true)) {
                $products[0] = array_merge($products[0], $autresProduits);
            }
        } else {
            $products[0] = [];
        }







        $traitementPossible = true;
        if ($dateDebut_n_1 && \DateTime::createFromFormat('Y-m-d', $dateDebut_n_1) === FALSE) {
            $traitementPossible = false;
        } else {
            $date_dateDebut = strtotime($dateDebut_n_1);
            if (date("Y", $date_dateDebut) < 1900) {
                $traitementPossible = false;
            }
        }

        if ($dateFin_n_1 && \DateTime::createFromFormat('Y-m-d', $dateFin_n_1) === FALSE) {
            $traitementPossible = false;
        } else {
            $date_dateFin = strtotime($dateFin_n_1);
            if (date("Y", $date_dateFin) < 1900) {
                $traitementPossible = false;
            }
        }

        if (!$dateDebut_n_1 && !$dateFin_n_1) {
            $traitementPossible = false;
        }

        if ($traitementPossible) {
            //            if (!$products[1] = Products::top10($dateDebut_n_1, $dateFin_n_1, $filters, 0, true)) {
            //                $products[1] = [];
            //            }

            $products[1] = [];
            if ($autresProduits = Products::top10Autre($dateDebut_n_1, $dateFin_n_1, $filters, 0, true)) {
                $products[1] = array_merge($products[1], $autresProduits);
            }
        } else {
            $products[1] = [];
        }











        // calcul du tableau de résultat
        $idsProduct = [];
        foreach ($products[0] as $product) {
            if (!in_array($product->id_product, $idsProduct)) {
                $idsProduct[] = $product->id_product;
            }
        }
        foreach ($products[1] as $product) {
            if (!in_array($product->id_product, $idsProduct)) {
                $idsProduct[] = $product->id_product;
            }
        }


        $tabResultProduit = [];
        foreach ($idsProduct as $idProduct) {
            $dataProduit = [];
            $dataProduit["ref"] = "";
            $dataProduit["libelle"] = "";
            $dataProduit["qteN"] = 0;
            $dataProduit["qteNmoins1"] = 0;
            $dataProduit["caN"] = 0;
            $dataProduit["caNmoins1"] = 0;
            $dataProduit["caParUniteN"] = 0;
            $dataProduit["caParUniteNmoins1"] = 0;
            $dataProduit["qteEvolution"] = 0;
            $dataProduit["caEvolution"] = 0;

            foreach ($products[0] as $product) {
                if ($product->id_product == $idProduct) {
                    $dataProduit["ref"] = $product->ref;
                    $dataProduit["name"] = $product->name;
                    $dataProduit["qteN"] = $product->qty;
                    $dataProduit["caN"] = $product->total_ht;
                    if ($product->qty != 0) {
                        $dataProduit["caParUniteN"] = $product->total_ht / $product->qty;
                    }

                    break;
                }
            }

            foreach ($products[1] as $product) {
                if ($product->id_product == $idProduct) {
                    $dataProduit["ref"] = $product->ref;
                    $dataProduit["name"] = $product->name;
                    $dataProduit["qteNmoins1"] = $product->qty;
                    $dataProduit["caNmoins1"] = $product->total_ht;
                    if ($product->qty != 0) {
                        $dataProduit["caParUniteNmoins1"] = $product->total_ht / $product->qty;
                    }

                    break;
                }
            }

            if ($dataProduit["caN"] > $dataProduit["caNmoins1"]) {
                $dataProduit["caEvolution"] = 1;
            } else if ($dataProduit["caN"] < $dataProduit["caNmoins1"]) {
                $dataProduit["caEvolution"] = -1;
            }

            if ($dataProduit["qteN"] > $dataProduit["qteNmoins1"]) {
                $dataProduit["qteEvolution"] = 1;
            } else if ($dataProduit["qteN"] < $dataProduit["qteNmoins1"]) {
                $dataProduit["qteEvolution"] = -1;
            }



            $tabResultProduit[] = $dataProduit;
        }




        // calcul le total
        $totalQteN = 0;
        $totalCAN = 0;
        $totalQteNmoins1 = 0;
        $totalCANmoins1 = 0;
        foreach ($tabResultProduit as $ligne) {
            $totalQteN += $ligne["qteN"];
            $totalCAN += $ligne["caN"];
            $totalQteNmoins1 += $ligne["qteNmoins1"];
            $totalCANmoins1 += $ligne["caNmoins1"];
        }
        $dataProduit = [];
        $dataProduit["ref"] = "";
        $dataProduit["libelle"] = "Total";
        $dataProduit["qteN"] = $totalQteN;
        $dataProduit["qteNmoins1"] = $totalQteNmoins1;
        $dataProduit["caN"] = $totalCAN;
        $dataProduit["caNmoins1"] = $totalCANmoins1;
        $dataProduit["caParUniteN"] = 0;
        $dataProduit["caParUniteNmoins1"] = 0;
        $dataProduit["qteEvolution"] = 0;
        $dataProduit["caEvolution"] = 0;
        if ($dataProduit["caN"] > $dataProduit["caNmoins1"]) {
            $dataProduit["caEvolution"] = 1;
        } else if ($dataProduit["caN"] < $dataProduit["caNmoins1"]) {
            $dataProduit["caEvolution"] = -1;
        }

        if ($dataProduit["qteN"] > $dataProduit["qteNmoins1"]) {
            $dataProduit["qteEvolution"] = 1;
        } else if ($dataProduit["qteN"] < $dataProduit["qteNmoins1"]) {
            $dataProduit["qteEvolution"] = -1;
        }
        $tabResultProduit[] = $dataProduit;

        return $tabResultProduit;
    }

    public function get(Request $request)
    {
        echo json_encode(array(
            "products" => $this->getData($request)
        ));
    }


    public function getExport(Request $request)
    {
        $filters = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }

        $dateDebut = null;
        $dateFin = null;
        $dateDebut_n_1 = null;
        $dateFin_n_1 = null;

        if (isset($filters['date_sales_n_1 >='])) {
            if (trim($filters['date_sales_n_1 >=']) != "") {
                $dateDebut_n_1 = $filters['date_sales_n_1 >='];
            }
        }


        if (isset($filters['date_sales_n_1 <='])) {
            if (trim($filters['date_sales_n_1 <=']) != "") {
                $dateFin_n_1 = $filters['date_sales_n_1 <='];
            }
        }


        $products = $this->getData($request);

        $currentWeek = (int)date('W');
        $currentYear = (int)date('Y');

        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Ref");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "Produits");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
        $objPHPExcel->getActiveSheet()->mergeCells('B1:B2');

        $objPHPExcel->getActiveSheet()->setCellValue('C1', "N");
        $objPHPExcel->getActiveSheet()->mergeCells('C1:D1');

        if ($dateDebut_n_1 || $dateFin_n_1) {
            $objPHPExcel->getActiveSheet()->setCellValue('E1', "N-1");
            $objPHPExcel->getActiveSheet()->mergeCells('E1:F1');
        }

        $objPHPExcel->getActiveSheet()->setCellValue('C2', "CA");
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "Quantité");

        if ($dateDebut_n_1 || $dateFin_n_1) {
            $objPHPExcel->getActiveSheet()->setCellValue('E2', "CA");
            $objPHPExcel->getActiveSheet()->setCellValue('F2', "Quantité");
        }





        $nLigne = 2;
        foreach ($products as $ligne) {
            if (is_array($ligne) && isset($ligne["name"])) {
                $nLigne++;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $nLigne, $ligne["ref"]);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $nLigne, $ligne["name"]);

                $objPHPExcel->getActiveSheet()->setCellValue('C' . $nLigne, $ligne["caN"]);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $nLigne, $ligne["qteN"]);

                if ($dateDebut_n_1 || $dateFin_n_1) {
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $nLigne, $ligne["caNmoins1"]);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $nLigne, $ligne["qteNmoins1"]);
                }

                $objPHPExcel->getActiveSheet()->getStyle('C' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('D' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');

                if ($dateDebut_n_1 || $dateFin_n_1) {
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $nLigne)->getNumberFormat()
                        ->setFormatCode('#,##0.00');
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $nLigne)->getNumberFormat()
                        ->setFormatCode('#,##0.00');
                }


                // formatage des 2 premières colonnes
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ];

                $objPHPExcel->getActiveSheet()->getStyle('A' . $nLigne)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $nLigne)->applyFromArray($styleArray);
            }
        }


        // Total en pied de feuille
        $nLigne++;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $nLigne, "Total");
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $nLigne . ':B' . $nLigne);

        $objPHPExcel->getActiveSheet()->setCellValue('C' . $nLigne, "=SUM(C3:C" . ($nLigne - 1) . ")");
        $objPHPExcel->getActiveSheet()->getStyle('C' . $nLigne)->getNumberFormat()
            ->setFormatCode('#,##0.00');

        $objPHPExcel->getActiveSheet()->setCellValue('D' . $nLigne, "=SUM(D3:D" . ($nLigne - 1) . ")");
        $objPHPExcel->getActiveSheet()->getStyle('D' . $nLigne)->getNumberFormat()
            ->setFormatCode('#,##0.00');

        if ($dateDebut_n_1 || $dateFin_n_1) {
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $nLigne, "=SUM(E3:E" . ($nLigne - 1) . ")");
            $objPHPExcel->getActiveSheet()->getStyle('E' . $nLigne)->getNumberFormat()
                ->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $nLigne, "=SUM(F3:F" . ($nLigne - 1) . ")");
            $objPHPExcel->getActiveSheet()->getStyle('F' . $nLigne)->getNumberFormat()
                ->setFormatCode('#,##0.00');
        }

        $styleArray = [
            'font' => [
                'bold' => true,
            ]
        ];
        if ($dateDebut_n_1 || $dateFin_n_1) {
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nLigne . ':G' . $nLigne)->applyFromArray($styleArray);
        } else {
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nLigne . ':D' . $nLigne)->applyFromArray($styleArray);
        }







        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        if ($dateDebut_n_1 || $dateFin_n_1) {
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        }



        // header
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        if ($dateDebut_n_1 || $dateFin_n_1) {
            $objPHPExcel->getActiveSheet()->getStyle('A1:G2')->applyFromArray($styleArray);
        } else {
            $objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($styleArray);
        }



        // bordure
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        if ($dateDebut_n_1 || $dateFin_n_1) {
            $objPHPExcel->getActiveSheet()->getStyle('A1:G' . $nLigne)->applyFromArray($styleArray);
        } else {
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $nLigne)->applyFromArray($styleArray);
        }

        $xlsxFilePath = Storage::getFolder("stats") . 'stats_abonnement.xlsx';
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save(BASEPATH . $xlsxFilePath);

        echo json_encode($xlsxFilePath);
    }
}
