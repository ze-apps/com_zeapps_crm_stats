<?php
use Zeapps\Core\Routeur ;



Routeur::get("/com_zeapps_crm_stats/sales-figures/", 'App\\com_zeapps_crm_stats\\Controllers\\SalesFigures@index');
Routeur::get("/com_zeapps_crm_stats/sales-figures/chart", 'App\\com_zeapps_crm_stats\\Controllers\\SalesFigures@chart');
Routeur::get("/com_zeapps_crm_stats/sales-figures/history", 'App\\com_zeapps_crm_stats\\Controllers\\SalesFigures@history');
Routeur::post("/com_zeapps_crm_stats/sales-figures/get", 'App\\com_zeapps_crm_stats\\Controllers\\SalesFigures@get');


Routeur::get("/com_zeapps_crm_stats/flowing-horizon", 'App\\com_zeapps_crm_stats\\Controllers\\FlowingHorizon@index');
Routeur::get("/com_zeapps_crm_stats/flowing-horizon/chart", 'App\\com_zeapps_crm_stats\\Controllers\\FlowingHorizon@chart');
Routeur::get("/com_zeapps_crm_stats/flowing-horizon/history", 'App\\com_zeapps_crm_stats\\Controllers\\FlowingHorizon@history');
Routeur::post("/com_zeapps_crm_stats/flowing-horizon/get", 'App\\com_zeapps_crm_stats\\Controllers\\FlowingHorizon@get');




Routeur::get("/com_zeapps_crm_stats/market/", 'App\\com_zeapps_crm_stats\\Controllers\\Market@index');
Routeur::get("/com_zeapps_crm_stats/market/chart", 'App\\com_zeapps_crm_stats\\Controllers\\Market@chart');
Routeur::get("/com_zeapps_crm_stats/market/history", 'App\\com_zeapps_crm_stats\\Controllers\\Market@history');

Routeur::get("/com_zeapps_crm_stats/abonnement_stats/", 'App\\com_zeapps_crm_stats\\Controllers\\Abonnement_stats@index');
Routeur::get("/com_zeapps_crm_stats/abonnement_stats/chart", 'App\\com_zeapps_crm_stats\\Controllers\\Abonnement_stats@chart');
Routeur::get("/com_zeapps_crm_stats/abonnement_stats/history", 'App\\com_zeapps_crm_stats\\Controllers\\Abonnement_stats@history');

Routeur::get("/com_zeapps_crm_stats/product_stats/", 'App\\com_zeapps_crm_stats\\Controllers\\Product_stats@index');
Routeur::get("/com_zeapps_crm_stats/product_stats/chart", 'App\\com_zeapps_crm_stats\\Controllers\\Product_stats@chart');
Routeur::get("/com_zeapps_crm_stats/product_stats/chartQty", 'App\\com_zeapps_crm_stats\\Controllers\\Product_stats@chartQty');
Routeur::get("/com_zeapps_crm_stats/product_stats/history", 'App\\com_zeapps_crm_stats\\Controllers\\Product_stats@history');

Routeur::get("/com_zeapps_crm_stats/medium/", 'App\\com_zeapps_crm_stats\\Controllers\\Medium@index');
Routeur::get("/com_zeapps_crm_stats/medium/chart", 'App\\com_zeapps_crm_stats\\Controllers\\Medium@chart');
Routeur::get("/com_zeapps_crm_stats/medium/history", 'App\\com_zeapps_crm_stats\\Controllers\\Medium@history');

Routeur::get("/com_zeapps_crm_stats/email_stats/", 'App\\com_zeapps_crm_stats\\Controllers\\Email_stats@index');
Routeur::get("/com_zeapps_crm_stats/email_stats/chart", 'App\\com_zeapps_crm_stats\\Controllers\\Email_stats@chart');
Routeur::get("/com_zeapps_crm_stats/email_stats/history", 'App\\com_zeapps_crm_stats\\Controllers\\Email_stats@history');

Routeur::get("/com_zeapps_crm_stats/distributeurs/", 'App\\com_zeapps_crm_stats\\Controllers\\Distributeurs@index');
Routeur::get("/com_zeapps_crm_stats/distributeurs/chart", 'App\\com_zeapps_crm_stats\\Controllers\\Distributeurs@chart');
Routeur::get("/com_zeapps_crm_stats/distributeurs/history", 'App\\com_zeapps_crm_stats\\Controllers\\Distributeurs@history');


Routeur::get("/com_zeapps_crm_stats/overview/", 'App\\com_zeapps_crm_stats\\Controllers\\Overview@index');


Routeur::post("/com_quiltmania_stats/product_stats/get/{id_parent}/{context}", 'App\\com_zeapps_crm_stats\\Controllers\\Product_stats@get');





Routeur::post("/com_quiltmania_stats/abonnement_stats/get/{year}/{context}", 'App\\com_zeapps_crm_stats\\Controllers\\Abonnement_stats@get');




Routeur::get("/com_zeapps_crm_stats/distributeur_ventes/view/", 'App\\com_zeapps_crm_stats\\Controllers\\Distributeur_ventes@view');
Routeur::get("/com_zeapps_crm_stats/distributeurs/config/", 'App\\com_zeapps_crm_stats\\Controllers\\Distributeurs@config');
Routeur::get("/com_zeapps_crm_stats/distributeurs/config_form/", 'App\\com_zeapps_crm_stats\\Controllers\\Distributeurs@config_form');
Routeur::get("/com_zeapps_crm_stats/key_market/config", 'App\\com_zeapps_crm_stats\\Controllers\\Key_market@config');
Routeur::get("/com_zeapps_crm_stats/key_market/config_form", 'App\\com_zeapps_crm_stats\\Controllers\\Key_market@config_form');

