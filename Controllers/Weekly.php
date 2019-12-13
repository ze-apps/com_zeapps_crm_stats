<?php

namespace App\com_zeapps_crm_stats\Controllers;

use App\com_quiltmania_abonnement\Models\AbonnementClient;
use App\com_zeapps_contact\Models\Companies;
use App\com_zeapps_contact\Models\Contacts;
use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use App\com_zeapps_crm\Models\Invoice\Invoices;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Zeapps\Core\Storage;


class Weekly extends Controller
{
    public function index() {
        $data = array();
        return view("weekly/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }


    private function getIsoWeeksInYear($year) {
        $date = new \DateTime;
        $date->setISODate($year, 53);
        return ($date->format("W") === "53" ? 53 : 52);
    }

    private function getStartAndEndDate($week, $year) {
        $ret = [];
        $dto = new \DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
    }

    private function getStartAndEndDateFR($week, $year) {
        $ret = [];
        $dto = new \DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('d/m/Y');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('d/m/Y');
        return $ret;
    }



    private function getData()
    {
        $dataSrc = [];

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $dataSrc = json_decode(file_get_contents('php://input'), true);
        }

        $date_debut = strtotime($dataSrc["date_debut"]);
        $date_fin = strtotime($dataSrc["date_fin"]);


        $currentWeek = (int)date('W', $date_fin);
        $currentYear = (int)date('Y', $date_fin);



        // détermine la semaine de début d'analyse
        $semaineAnalyse = (int)date('W', $date_debut);
        $anneeAnalyse = (int)date('Y', $date_debut);


        if ($semaineAnalyse == 53 && $this->getIsoWeeksInYear($anneeAnalyse) == 52) {
            $anneeAnalyse++;
            $semaineAnalyse = 1;
        }


        $onContinue = true;
        $totalMoyenneCA = 0;
        $totalMoyenneCASansQInc = 0;
        $nbSemaineMoyenneCA = 0;


        while ($onContinue) {
            if ($semaineAnalyse > $this->getIsoWeeksInYear($anneeAnalyse)) {
                $anneeAnalyse++;
                $semaineAnalyse = 1;
            }


            $tabDate = $this->getStartAndEndDate($semaineAnalyse, $anneeAnalyse);
            $tabDateFR = $this->getStartAndEndDateFR($semaineAnalyse, $anneeAnalyse);
            $tabDateNMoins1 = $this->getStartAndEndDate($semaineAnalyse, $anneeAnalyse - 1);


            $qInc = 0;
            $particuliers = 0;
            $salons = 0;
            $boutiques = 0;
            $total = 0;
            $totalSansQInc = 0;
            $totalNMoins1 = 0;
            $totalNMoins1SansQInc = 0;
            $moyenneCA = 0;
            $moyenneCASansQInc = 0;
            $nbNouveauClient = 0 ;
            $nbNouveauAbonnement = 0 ;
            $nbRenouvellementAbonnement = 0 ;



            // recherche le nombre de nouveau contact + entreprise
            $nbNouveauClient = Contacts::where("created_at", ">=", $tabDate['week_start'] . " 00:00:00")
                ->where("created_at", "<=", $tabDate['week_end'] . " 23:59:59")
                ->count();

            $nbNouveauClient += Companies::where("created_at", ">=", $tabDate['week_start'] . " 00:00:00")
                ->where("created_at", "<=", $tabDate['week_end'] . " 23:59:59")
                ->count();


            // recherche les abonnements
            $abonnementClients = AbonnementClient::where("created_at", ">=", $tabDate['week_start'] . " 00:00:00")
                ->where("created_at", "<=", $tabDate['week_end'] . " 23:59:59")
                ->get();

            foreach ($abonnementClients as $abonnementClient) {
                $checkAbonnment = AbonnementClient::where("id", "!=", $abonnementClient->id) ;
                if ($abonnementClient->id_company != 0) {
                    $checkAbonnment = $checkAbonnment->where("id_company", $abonnementClient->id_company) ;
                } else {
                    $checkAbonnment = $checkAbonnment->where("id_contact", $abonnementClient->id_contact) ;
                }

                if ($checkAbonnment->count()) {
                    $nbRenouvellementAbonnement++;
                } else {
                    $nbNouveauAbonnement++;
                }
            }




            // Recherche les factures
            $invoices = Invoices::where("date_creation", ">=", $tabDate['week_start'] . " 00:00:00")
                ->where("date_creation", "<=", $tabDate['week_end'] . " 23:59:59")
                ->get();


            $invoicesNMoins1 = Invoices::where("date_creation", ">=", $tabDateNMoins1['week_start'] . " 00:00:00")
                ->where("date_creation", "<=", $tabDateNMoins1['week_end'] . " 23:59:59")
                ->get();

            foreach ($invoicesNMoins1 as $invoice) {
                $totalNMoins1 += $invoice->total_ht;
                if ($invoice->id_company != 1389) {
                    $totalNMoins1SansQInc += $invoice->total_ht;
                }
            }

            foreach ($invoices as $invoice) {
                $total += $invoice->total_ht;

                if ($invoice->id_company == 1389) {
                    $qInc += $invoice->total_ht;
                } elseif ($invoice->id_origin == 3) { // salons
                    $salons += $invoice->total_ht;
                } elseif ($invoice->id_company == 0) {
                    $particuliers += $invoice->total_ht;
                } else {
                    $boutiques += $invoice->total_ht;
                }
            }


            $totalSansQInc = $total - $qInc;
            $totalMoyenneCA += $total;
            $totalMoyenneCASansQInc += $totalSansQInc;
            $nbSemaineMoyenneCA++;

            $moyenneCA = $totalMoyenneCA / $nbSemaineMoyenneCA;
            $moyenneCASansQInc = $totalMoyenneCASansQInc / $nbSemaineMoyenneCA;

            $data[] = array("semaine" => $anneeAnalyse . "-" . $semaineAnalyse,
                "semaine_date" => $tabDateFR["week_start"] . " au " . $tabDateFR["week_end"],
                "qInc" => $qInc,
                "particuliers" => $particuliers,
                "salons" => $salons,
                "boutiques" => $boutiques,
                "total" => $total,
                "totalSansQInc" => $totalSansQInc,
                "totalNMoins1" => $totalNMoins1,
                "totalNMoins1SansQInc" => $totalNMoins1SansQInc,
                "moyenneCA" => $moyenneCA,
                "moyenneCASansQInc" => $moyenneCASansQInc,
                "nbNouveauClient"=>$nbNouveauClient,
                "nbNouveauAbonnement"=>$nbNouveauAbonnement,
                "nbRenouvellementAbonnement"=>$nbRenouvellementAbonnement);

            if ($anneeAnalyse == $currentYear && $semaineAnalyse == $currentWeek) {
                $onContinue = false;
            }

            $semaineAnalyse++;
        }

        $data = array_reverse($data);

        return $data;
    }

    public function get()
    {
        echo json_encode($this->getData());
    }

    public function getExcel() {
        $currentWeek = (int)date('W');
        $currentYear = (int)date('Y');

        $data = $this->getData() ;

        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Semaine");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "Date");
        $objPHPExcel->getActiveSheet()->setCellValue('C1', "Q. Inc");
        $objPHPExcel->getActiveSheet()->setCellValue('D1', "Particuliers");
        $objPHPExcel->getActiveSheet()->setCellValue('E1', "Salons");
        $objPHPExcel->getActiveSheet()->setCellValue('F1', "Boutiques");
        $objPHPExcel->getActiveSheet()->setCellValue('G1', "Total");
        $objPHPExcel->getActiveSheet()->setCellValue('H1', "Total sans Q. Inc");
        $objPHPExcel->getActiveSheet()->setCellValue('I1', "Total N-1");
        $objPHPExcel->getActiveSheet()->setCellValue('J1', "Total N-1 sans Q. Inc");
        $objPHPExcel->getActiveSheet()->setCellValue('K1', "Moyenne CA");
        $objPHPExcel->getActiveSheet()->setCellValue('L1', "Moyenne CA sans Q. Inc");
        $objPHPExcel->getActiveSheet()->setCellValue('M1', "Nombre nouveau client");
        $objPHPExcel->getActiveSheet()->setCellValue('N1', "Nombre nouvel abonnement");
        $objPHPExcel->getActiveSheet()->setCellValue('O1', "Nombre renouvellement abonnement");

        $nLigne = 1 ;
        foreach ($data as $ligne) {
            if (is_array($ligne)) {
                $nLigne++;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $nLigne, $ligne["semaine"]);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $nLigne, $ligne["semaine_date"]);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $nLigne, $ligne["qInc"]);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $nLigne, $ligne["particuliers"]);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $nLigne, $ligne["salons"]);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $nLigne, $ligne["boutiques"]);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $nLigne, $ligne["total"]);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $nLigne, $ligne["totalSansQInc"]);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $nLigne, $ligne["totalNMoins1"]);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $nLigne, $ligne["totalNMoins1SansQInc"]);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $nLigne, $ligne["moyenneCA"]);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $nLigne, $ligne["moyenneCASansQInc"]);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $nLigne, $ligne["nbNouveauClient"]);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $nLigne, $ligne["nbNouveauAbonnement"]);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $nLigne, $ligne["nbRenouvellementAbonnement"]);



                $objPHPExcel->getActiveSheet()->getStyle('A' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('B' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('C' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('D' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('E' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('F' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('G' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('H' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('I' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('J' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('K' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('L' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('M' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('N' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('O' . $nLigne)->getNumberFormat()
                    ->setFormatCode('#,##0');


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


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);



        // header
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($styleArray);



        // bordure
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $objPHPExcel->getActiveSheet()->getStyle('A1:O' . $nLigne)->applyFromArray($styleArray);

        $xlsxFilePath = Storage::getFolder("stats") . $currentYear . "-" . $currentWeek . '.xlsx';
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save(BASEPATH . $xlsxFilePath);

        echo json_encode($xlsxFilePath);
    }
}