app.config(["$routeProvider",
    function ($routeProvider) {
        $routeProvider
        // OVERVIEW
            .when("/ng/com_zeapps_crm_stats/weekly", {
                templateUrl: "/com_zeapps_crm_stats/weekly",
                controller: "ComZeappsStatsWeeklyCtrl"
            })
            .when("/ng/com_zeapps_crm_stats/overview", {
                templateUrl: "/com_zeapps_crm_stats/overview/",
                controller: "ComZeappsStatsOverviewCtrl"
            })

            .when("/ng/com_zeapps_crm_stats/sales-figures", {
                templateUrl: "/com_zeapps_crm_stats/sales-figures/",
                controller: "ComZeappsStatsSalesFiguresCtrl"
            })

            .when("/ng/com_zeapps_crm_stats/flowing-horizon", {
                templateUrl: "/com_zeapps_crm_stats/flowing-horizon",
                controller: "ComZeappsStatsFlowingHorizonCtrl"
            })

            .when("/ng/com_zeapps_crm_stats/markets", {
                templateUrl: "/com_zeapps_crm_stats/market/",
                controller: "ComZeappsStatsMarketCtrl"
            })
            .when("/ng/com_zeapps_crm_stats/abonnements", {
                templateUrl: "/com_zeapps_crm_stats/abonnement_stats/",
                controller: "ComZeappsStatsAbonnementStatCtrl"
            })
            .when("/ng/com_zeapps_crm_stats/products", {
                templateUrl: "/com_zeapps_crm_stats/product_stats/",
                controller: "ComZeappsStatsProductstatsCtrl"
            })


            .when("/ng/com_zeapps_crm_stats/products_details", {
                templateUrl: "/com_zeapps_crm_stats/product_stats_details/",
                controller: "ComZeappsStatsProductstatsDetailsCtrl"
            })

            .when("/ng/com_zeapps_crm_stats/abonnement", {
                templateUrl: "/com_zeapps_crm_stats/abonnement/",
                controller: "ComZeappsStatsAbonnementCtrl"
            })


            .when("/ng/com_zeapps_crm_stats/medium", {
                templateUrl: "/com_zeapps_crm_stats/medium/",
                controller: "ComZeappsStatsMediumCtrl"
            })
            .when("/ng/com_zeapps_crm_stats/emails", {
                templateUrl: "/com_zeapps_crm_stats/email_stats/",
                controller: "ComZeappsStatsEmailCtrl"
            })
            .when("/ng/com_zeapps_crm_stats/distributeurs", {
                templateUrl: "/com_zeapps_crm_stats/distributeurs/",
                controller: "ComZeappsStatsDistributeurCtrl"
            })

            // DISTRIBUTEUR VENTE
            .when("/ng/com_zeapps_crm_stats/vente_distributeur", {
                templateUrl: "/com_zeapps_crm_stats/distributeur_ventes/view/",
                controller: "ComZeappsStatsDistributeurViewCtrl"
            })

            // CONFIG
            .when("/ng/com_zeapps_crm_stats/distributeur", {
                templateUrl: "/com_zeapps_crm_stats/distributeurs/config/",
                controller: "ComZeappsStatsDistributeurConfigCtrl"
            })
            .when("/ng/com_zeapps_crm_stats/distributeur/new/", {
                templateUrl: "/com_zeapps_crm_stats/distributeurs/config_form/",
                controller: "ComZeappsStatsDistributeurConfigFormCtrl"
            })
            .when("/ng/com_zeapps_crm_stats/distributeur/edit/:id", {
                templateUrl: "/com_zeapps_crm_stats/distributeurs/config_form/",
                controller: "ComZeappsStatsDistributeurConfigFormCtrl"
            })
            .when("/ng/com_zeapps_crm_stats/key_markets/config", {
                templateUrl: "/com_zeapps_crm_stats/key_market/config",
                controller: "ComZeappsStatsKeyMarketsConfigCtrl"
            })
            .when("/ng/com_zeapps_crm_stats/key_markets/new/", {
                templateUrl: "/com_zeapps_crm_stats/key_market/config_form",
                controller: "ComZeappsStatsKeyMarketsConfigFormCtrl"
            })
            .when("/ng/com_zeapps_crm_stats/key_markets/edit/:id", {
                templateUrl: "/com_zeapps_crm_stats/key_market/config_form",
                controller: "ComZeappsStatsKeyMarketsConfigFormCtrl"
            })
        ;
    }
]);