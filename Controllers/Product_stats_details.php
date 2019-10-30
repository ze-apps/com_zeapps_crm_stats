<?php

namespace App\com_zeapps_crm_stats\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use App\com_zeapps_crm\Models\Product\ProductCategories;
use App\com_zeapps_crm\Models\Product\Products;

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








        if ($id_parent !== "0") {
            $filters['id_cat'] = ProductCategories::getSubCatIds_r($id_parent);
        } else {
            unset($filters['id_cat']);
        }

        $products = [];
        if (!$products[0] = Products::top10($dateDebut, $dateFin, $filters, 0)) {
            $products[0] = [];
        }
        if (!$products[1] = Products::top10($dateDebut_n_1, $dateFin_n_1, $filters, 0)) {
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
                    $dataProduit["libelle"] = $product->name ;
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



        echo json_encode(array(
            "products" => $tabResultProduit
        ));
    }
}