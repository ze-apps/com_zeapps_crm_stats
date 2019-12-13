<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use App\com_zeapps_crm\Models\Product\ProductCategories;
use App\com_zeapps_crm\Models\Product\Products;

class Product_stats extends Controller
{
    public function index()
    {
        $data = array();
        return view("product/view", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chart()
    {
        $data = array();
        return view("product/chart", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function chartQty()
    {
        $data = array();
        return view("product/chart-qty", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }

    public function history()
    {
        $data = array();
        return view("product/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }


    public function get(Request $request)
    {
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





        if ($categories = ProductCategories::where('id_parent', $id_parent)->get()) {
            foreach ($categories as $cat) {
                $ids = ProductCategories::getSubCatIds_r($cat->id);
                $filters['id_cat'] = $ids;
                $total_ht = [] ;
                $total_ht[0] = 0;
                $total_ht[1] = 0;

                $qty = [] ;
                $qty[0] = 0;
                $qty[1] = 0;

                $traitementPossible = true ;
                if ($dateDebut && \DateTime::createFromFormat('Y-m-d', $dateDebut) === FALSE) {
                    $traitementPossible = false ;
                } else {
                    $date_dateDebut = strtotime($dateDebut);
                    if (date("Y", $date_dateDebut) < 1900) {
                        $traitementPossible = false ;
                    }
                }

                if ($dateFin && \DateTime::createFromFormat('Y-m-d', $dateFin) === FALSE) {
                    $traitementPossible = false ;
                } else {
                    $date_dateFin = strtotime($dateFin);
                    if (date("Y", $date_dateFin) < 1900) {
                        $traitementPossible = false ;
                    }
                }

                if (!$dateDebut && !$dateFin) {
                    $traitementPossible = false ;
                }

                if ($traitementPossible) {
                    $sums = ProductCategories::turnover($dateDebut, $dateFin, $filters) ;
                    foreach ($sums as $sum) {
                        $total_ht[0] += floatval($sum->total_ht);
                        $qty[0] += floatval($sum->qty);
                    }
                }






                $traitementPossible = true ;
                if ($dateDebut_n_1 && \DateTime::createFromFormat('Y-m-d', $dateDebut_n_1) === FALSE) {
                    $traitementPossible = false ;
                } else {
                    $date_dateDebut = strtotime($dateDebut_n_1);
                    if (date("Y", $date_dateDebut) < 1900) {
                        $traitementPossible = false ;
                    }
                }

                if ($dateFin_n_1 && \DateTime::createFromFormat('Y-m-d', $dateFin_n_1) === FALSE) {
                    $traitementPossible = false ;
                } else {
                    $date_dateFin = strtotime($dateFin_n_1);
                    if (date("Y", $date_dateFin) < 1900) {
                        $traitementPossible = false ;
                    }
                }

                if (!$dateDebut_n_1 && !$dateFin_n_1) {
                    $traitementPossible = false ;
                }

                if ($traitementPossible) {
                    $sums = ProductCategories::turnover($dateDebut_n_1, $dateFin_n_1, $filters) ;
                    foreach ($sums as $sum) {
                        $total_ht[1] += floatval($sum->total_ht);
                        $qty[1] += floatval($sum->qty);
                    }
                }


                $cat->total_ht = $total_ht ;
                $cat->qty = $qty ;
            }
        } else {
            $categories = [];
        }

        if ($id_parent !== "0") {
            $filters['id_cat'] = ProductCategories::getSubCatIds_r($id_parent);
        } else {
            unset($filters['id_cat']);
        }



        $products = [];
//        if (!$products[0] = Products::top10($dateDebut, $dateFin, $filters)) {
//            $products[0] = [];
//        }
//        if (!$products[1] = Products::top10($dateDebut_n_1, $dateFin_n_1, $filters)) {
//            $products[1] = [];
//        }




        $serie_label = "" ;

        if ($dateDebut && $dateFin) {
            $serie_label .= " du " . date("d/m/Y", strtotime($dateDebut)) . " au " . date("d/m/Y", strtotime($dateFin)) ;
        } elseif ($dateDebut) {
            $serie_label .= " depuis le " . date("d/m/Y", strtotime($dateDebut)) ;
        } elseif ($dateFin) {
            $serie_label .= " jusqu'au " . date("d/m/Y", strtotime($dateFin)) ;
        }



        $serie_label_n_1 = "" ;

        if ($dateDebut_n_1 && $dateFin_n_1) {
            $serie_label_n_1 .= " du " . date("d/m/Y", strtotime($dateDebut_n_1)) . " au " . date("d/m/Y", strtotime($dateFin_n_1)) ;
        } elseif ($dateDebut_n_1) {
            $serie_label_n_1 .= " depuis le " . date("d/m/Y", strtotime($dateDebut_n_1)) ;
        } elseif ($dateFin_n_1) {
            $serie_label_n_1 .= " jusqu'au " . date("d/m/Y", strtotime($dateFin_n_1)) ;
        }




        echo json_encode(array(
            'infoSerie' => $serie_label,
            'infoSerie_n_1' => $serie_label_n_1,
            "categories" => $categories,
            "products" => $products
        ));
    }
}