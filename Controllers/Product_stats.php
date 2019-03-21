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

    public function history()
    {
        $data = array();
        return view("product/history", $data, BASEPATH . 'App/com_zeapps_crm_stats/views/');
    }


    public function get(Request $request)
    {
        $id_parent = $request->input("id_parent", 0);
        $year = $request->input("year", false);


        if (!$year) {
            $year = intval(date('Y'));
        }

        //$category = ProductCategories::find($id_parent);

        $filters = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);

            if (isset($filters['year'])) {
                unset($filters['year']);
            }
        }

        if ($categories = ProductCategories::where('id_parent', $id_parent)->get()) {
            foreach ($categories as $cat) {
                $ids = ProductCategories::getSubCatIds_r($cat->id);
                $filters['id_cat'] = $ids;
                $total_ht = [] ;
                $total_ht[0] = 0;
                $total_ht[1] = 0;

                if ($sums = ProductCategories::turnover($year, $filters)) {
                    foreach ($sums as $sum) {
                        if ($sum->year == $year) {
                            $total_ht[0] += floatval($sum->total_ht);
                        } elseif ($sum->year == ($year - 1)) {
                            $total_ht[1] += floatval($sum->total_ht);
                        }
                    }
                }

                if ($total_ht[0] < 0) {
                    $total_ht[0] = 0;
                }
                if ($total_ht[1] < 0) {
                    $total_ht[1] = 0;
                }

                $cat->total_ht = $total_ht ;
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
        if (!$products[0] = Products::top10($year, $filters)) {
            $products[0] = [];
        }
        if (!$products[1] = Products::top10($year - 1, $filters)) {
            $products[1] = [];
        }

        echo json_encode(array(
            "categories" => $categories,
            "products" => $products
        ));
    }
}