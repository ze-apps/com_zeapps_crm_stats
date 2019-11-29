<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use App\com_zeapps_crm\Models\Product\ProductCategories;
use App\com_zeapps_crm\Models\Product\Products;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Zeapps\Core\Storage;

class Product_stats_details extends Controller
{
    public function index()
    {
        $data = array();
        return view("product_details/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart()
    {
        $data = array();
        return view("product_details/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chartQty()
    {
        $data = array();
        return view("product_details/chart-qty", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history()
    {
        $data = array();
        return view("product_details/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    private function getData(Request $request) {
        $id_parent = $request->input("id_parent", 0);

        $filters = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }





        // calcul les dates de début et de fin
        $dateDebut = null ;
        $dateFin = null ;
        $dateDebut_n_1 = null ;
        $dateFin_n_1 = null ;

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
            $dateDebut = date("Y") . "-01-01" ;
            $dateFin = date("Y") . "-12-31" ;
        }






        if ($id_parent !== "0") {
            $filters['id_cat'] = ProductCategories::getSubCatIds_r($id_parent);
        } else {
            unset($filters['id_cat']);
        }

        $products = [];
        if ($dateDebut || $dateFin) {
            if (!$products[0] = Products::top10($dateDebut, $dateFin, $filters, 0)) {
                $products[0] = [];
            }
        } else {
            $products[0] = [];
        }

        if ($dateDebut_n_1 || $dateFin_n_1) {
            if (!$products[1] = Products::top10($dateDebut_n_1, $dateFin_n_1, $filters, 0)) {
                $products[1] = [];
            }
        } else {
            $products[1] = [];
        }





        // calcul du tableau de résultat
        $idsProduct = [];
        foreach ($products[0] as $product) {
            if (!in_array($product->id_product, $idsProduct)) {
                $idsProduct[] = $product->id_product ;
            }
        }
        foreach ($products[1] as $product) {
            if (!in_array($product->id_product, $idsProduct)) {
                $idsProduct[] = $product->id_product ;
            }
        }


        $tabResultProduit = [];
        foreach ($idsProduct as $idProduct) {
            $dataProduit = [];
            $dataProduit["ref"] = "" ;
            $dataProduit["libelle"] = "" ;
            $dataProduit["qteN"] = 0 ;
            $dataProduit["qteNmoins1"] = 0 ;
            $dataProduit["caN"] = 0 ;
            $dataProduit["caNmoins1"] = 0 ;
            $dataProduit["caParUniteN"] = 0 ;
            $dataProduit["caParUniteNmoins1"] = 0 ;
            $dataProduit["qteEvolution"] = 0 ;
            $dataProduit["caEvolution"] = 0 ;

            foreach ($products[0] as $product) {
                if ($product->id_product == $idProduct) {
                    $dataProduit["ref"] = $product->ref ;
                    $dataProduit["name"] = $product->name ;
                    $dataProduit["qteN"] = $product->qty ;
                    $dataProduit["caN"] = $product->total_ht ;
                    if ($product->qty != 0) {
                        $dataProduit["caParUniteN"] = $product->total_ht / $product->qty;
                    }

                    break;
                }
            }

            foreach ($products[1] as $product) {
                if ($product->id_product == $idProduct) {
                    $dataProduit["ref"] = $product->ref ;
                    $dataProduit["name"] = $product->name ;
                    $dataProduit["qteNmoins1"] = $product->qty ;
                    $dataProduit["caNmoins1"] = $product->total_ht ;
                    if ($product->qty != 0) {
                        $dataProduit["caParUniteNmoins1"] = $product->total_ht / $product->qty;
                    }

                    break;
                }
            }

            if ($dataProduit["caN"] > $dataProduit["caNmoins1"]) {
                $dataProduit["caEvolution"] = 1 ;
            } else if ($dataProduit["caN"] < $dataProduit["caNmoins1"]) {
                $dataProduit["caEvolution"] = -1 ;
            }

            if ($dataProduit["qteN"] > $dataProduit["qteNmoins1"]) {
                $dataProduit["qteEvolution"] = 1 ;
            } else if ($dataProduit["qteN"] < $dataProduit["qteNmoins1"]) {
                $dataProduit["qteEvolution"] = -1 ;
            }



            $tabResultProduit[] = $dataProduit ;
        }

        return $tabResultProduit ;
    }

    public function get(Request $request)
    {
        echo json_encode(array(
            "products" => $this->getData($request)
        ));
    }

    public function getExport(Request $request) {
        $filters = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }

        $dateDebut = null ;
        $dateFin = null ;
        $dateDebut_n_1 = null ;
        $dateFin_n_1 = null ;

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


        $products = $this->getData($request) ;

        $currentWeek = (int)date('W');
        $currentYear = (int)date('Y');

        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Ref");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "Produits");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
        $objPHPExcel->getActiveSheet()->mergeCells('B1:B2');

        $objPHPExcel->getActiveSheet()->setCellValue('C1', "N");
        $objPHPExcel->getActiveSheet()->mergeCells('C1:E1');

        if ($dateDebut_n_1 || $dateFin_n_1) {
            $objPHPExcel->getActiveSheet()->setCellValue('F1', "N-1");
            $objPHPExcel->getActiveSheet()->mergeCells('F1:H1');
        }

        $objPHPExcel->getActiveSheet()->setCellValue('C2', "CA");
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "Quantité");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "CA / Unité");

        if ($dateDebut_n_1 || $dateFin_n_1) {
            $objPHPExcel->getActiveSheet()->setCellValue('F2', "CA");
            $objPHPExcel->getActiveSheet()->setCellValue('G2', "Quantité");
            $objPHPExcel->getActiveSheet()->setCellValue('H2', "CA / Unité");
        }





        $nLigne = 2 ;
        foreach ($products as $ligne) {
            if (is_array($ligne)) {
                $nLigne++;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $nLigne, $ligne["ref"]);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $nLigne, $ligne["name"]);

                $objPHPExcel->getActiveSheet()->setCellValue('C' . $nLigne, $ligne["caN"]);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $nLigne, $ligne["qteN"]);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $nLigne, $ligne["caParUniteN"]);

                if ($dateDebut_n_1 || $dateFin_n_1) {
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $nLigne, $ligne["caNmoins1"]);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $nLigne, $ligne["qteNmoins1"]);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $nLigne, $ligne["caParUniteNmoins1"]);
                }



                $objPHPExcel->getActiveSheet()->getStyle('C' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('D' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('E' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');

                if ($dateDebut_n_1 || $dateFin_n_1) {
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $nLigne)->getNumberFormat()
                        ->setFormatCode('#,##0.00');
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $nLigne)->getNumberFormat()
                        ->setFormatCode('#,##0.00');
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $nLigne)->getNumberFormat()
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

        $objPHPExcel->getActiveSheet()->setCellValue('C' . $nLigne, "=SUM(C3:C" . ($nLigne-1) . ")");
        $objPHPExcel->getActiveSheet()->getStyle('C' . $nLigne)->getNumberFormat()
            ->setFormatCode('#,##0.00');

        if ($dateDebut_n_1 || $dateFin_n_1) {
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
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nLigne . ':H' . $nLigne)->applyFromArray($styleArray);
        } else {
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nLigne . ':E' . $nLigne)->applyFromArray($styleArray);
        }







        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

        if ($dateDebut_n_1 || $dateFin_n_1) {
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
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
            $objPHPExcel->getActiveSheet()->getStyle('A1:H2')->applyFromArray($styleArray);
        } else {
            $objPHPExcel->getActiveSheet()->getStyle('A1:E2')->applyFromArray($styleArray);
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
            $objPHPExcel->getActiveSheet()->getStyle('A1:H' . $nLigne)->applyFromArray($styleArray);
        } else {
            $objPHPExcel->getActiveSheet()->getStyle('A1:E' . $nLigne)->applyFromArray($styleArray);
        }

        $xlsxFilePath = Storage::getFolder("stats") . 'produits_details.xlsx';
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save(BASEPATH . $xlsxFilePath);

        echo json_encode($xlsxFilePath);
    }
}