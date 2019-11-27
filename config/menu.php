<?php

/********** CONFIG MENU ************/
/*$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_modalities" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Modalités" ;
$tabMenu["fa-icon"] = "credit-card-alt" ;
$tabMenu["url"] = "/ng/com_zeapps/modalities" ;
$tabMenu["access"] = "com_zeapps_crm_read" ;
$tabMenu["order"] = 40 ;
$menuLeft[] = $tabMenu ;*/




/********** insert in left menu ************/
$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_weekly" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Hebdomadaire" ;
$tabMenu["fa-icon"] = "tags" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/weekly" ;
$tabMenu["order"] = 9 ;
$menuLeft[] = $tabMenu ;



$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_turnover" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Chiffre d'affaires" ;
$tabMenu["fa-icon"] = "chart-pie" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/sales-figures" ;
$tabMenu["order"] = 10 ;
$menuLeft[] = $tabMenu ;



$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_flowing_horizon" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Horizon glissant" ;
$tabMenu["fa-icon"] = "chart-pie" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/flowing-horizon" ;
$tabMenu["order"] = 11 ;
$menuLeft[] = $tabMenu ;





$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_productstats" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Ventes de produits" ;
$tabMenu["fa-icon"] = "tags" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/products" ;
$tabMenu["order"] = 12 ;
$menuLeft[] = $tabMenu ;


$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_productstats_details" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Produits détails" ;
$tabMenu["fa-icon"] = "tags" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/products_details" ;
$tabMenu["order"] = 13 ;
$menuLeft[] = $tabMenu ;



/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_markets" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Vue des marchés" ;
$tabMenu["fa-icon"] = "globe" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/markets" ;
$tabMenu["order"] = 20 ;
$menuLeft[] = $tabMenu ;*/



/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_abonnement" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Abonnements" ;
$tabMenu["fa-icon"] = "book" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/abonnements" ;
$tabMenu["order"] = 30 ;
$menuLeft[] = $tabMenu ;*/



/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_medium" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Catégories de produits par canaux" ;
$tabMenu["fa-icon"] = "tags" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/medium" ;
$tabMenu["order"] = 35 ;
$menuLeft[] = $tabMenu ;*/

/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_distributeur" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Ventes au numéro" ;
$tabMenu["fa-icon"] = "shopping-cart" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/distributeurs" ;
$tabMenu["order"] = 70 ;
$menuLeft[] = $tabMenu ;*/

/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_email" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Evolution du nombre d'emails" ;
$tabMenu["fa-icon"] = "envelope" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/emails" ;
$tabMenu["order"] = 40 ;
$menuLeft[] = $tabMenu ;*/

/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_distributeurs" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Vente distributeurs" ;
$tabMenu["fa-icon"] = "shopping-cart" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/vente_distributeur" ;
$tabMenu["order"] = 72 ;
$menuLeft[] = $tabMenu ;*/








/********** insert in top menu ************/
$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_weekly" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Hebdomadaire" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/weekly" ;
$tabMenu["order"] = 9 ;
$menuHeader[] = $tabMenu ;


$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_turnover" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Chiffre d'affaires" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/sales-figures" ;
$tabMenu["order"] = 10 ;
$menuHeader[] = $tabMenu ;


$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_flowing_horizon" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Horizon glissant" ;
$tabMenu["fa-icon"] = "chart-pie" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/flowing-horizon" ;
$tabMenu["order"] = 11 ;
$menuHeader[] = $tabMenu ;

$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_productstats" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Ventes de produits" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/products" ;
$tabMenu["order"] = 12 ;
$menuHeader[] = $tabMenu ;

$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_productstats_details" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Produits détails" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/products_details" ;
$tabMenu["order"] = 13 ;
$menuHeader[] = $tabMenu ;

/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_markets" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Vue des marchés" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/markets" ;
$tabMenu["order"] = 20 ;
$menuHeader[] = $tabMenu ;*/

/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_abonnement" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Abonnements" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/abonnements" ;
$tabMenu["order"] = 30;
$menuHeader[] = $tabMenu ;*/



/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_medium" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Catégories de produits par canaux" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/medium" ;
$tabMenu["order"] = 35 ;
$menuHeader[] = $tabMenu ;*/

/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_distributeur" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Ventes au numéro" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/distributeurs" ;
$tabMenu["order"] = 70 ;
$menuHeader[] = $tabMenu ;
$tabMenu = array () ;*/

/*$tabMenu["id"] = "com_quiltmania_stats_email" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Evolution du nombre d'emails" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/emails" ;
$tabMenu["order"] = 40 ;
$menuHeader[] = $tabMenu ;*/

/*$tabMenu = array () ;
$tabMenu["id"] = "com_quiltmania_stats_distributeurs" ;
$tabMenu["space"] = "com_zeapps_statistics" ;
$tabMenu["label"] = "Vente distributeurs" ;
$tabMenu["url"] = "/ng/com_zeapps_crm_stats/vente_distributeur" ;
$tabMenu["order"] = 72 ;
$menuHeader[] = $tabMenu ;*/