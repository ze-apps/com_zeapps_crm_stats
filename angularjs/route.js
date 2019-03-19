app.config(["$routeProvider",
    function ($routeProvider) {
        $routeProvider
        // OVERVIEW
            .when("/ng/com_quiltmania_stats/overview", {
                templateUrl: "/com_zeapps_crm_stats/overview/",
                controller: "ComQuiltmaniaStatsOverviewCtrl"
            })

            // DETAILS
            .when("/ng/com_quiltmania_stats/sales-figures", {
                templateUrl: "/com_zeapps_crm_stats/sales-figures/",
                controller: "ComQuiltmaniaStatsSalesFiguresCtrl"
            })
            .when("/ng/com_quiltmania_stats/markets", {
                templateUrl: "/com_zeapps_crm_stats/market/",
                controller: "ComQuiltmaniaStatsMarketCtrl"
            })
            .when("/ng/com_quiltmania_stats/abonnements", {
                templateUrl: "/com_zeapps_crm_stats/abonnement_stats/",
                controller: "ComQuiltmaniaStatsAbonnementCtrl"
            })
            .when("/ng/com_quiltmania_stats/products", {
                templateUrl: "/com_zeapps_crm_stats/product_stats/",
                controller: "ComQuiltmaniaStatsProductstatsCtrl"
            })
            .when("/ng/com_quiltmania_stats/medium", {
                templateUrl: "/com_zeapps_crm_stats/medium/",
                controller: "ComQuiltmaniaStatsMediumCtrl"
            })
            .when("/ng/com_quiltmania_stats/emails", {
                templateUrl: "/com_zeapps_crm_stats/email_stats/",
                controller: "ComQuiltmaniaStatsEmailCtrl"
            })
            .when("/ng/com_quiltmania_stats/distributeurs", {
                templateUrl: "/com_zeapps_crm_stats/distributeurs/",
                controller: "ComQuiltmaniaStatsDistributeurCtrl"
            })

            // DISTRIBUTEUR VENTE
            .when("/ng/com_quiltmania_stats/vente_distributeur", {
                templateUrl: "/com_zeapps_crm_stats/distributeur_ventes/view/",
                controller: "ComQuiltmaniaStatsDistributeurViewCtrl"
            })

            // CONFIG
            .when("/ng/com_quiltmania_stats/distributeur", {
                templateUrl: "/com_zeapps_crm_stats/distributeurs/config/",
                controller: "ComQuiltmaniaStatsDistributeurConfigCtrl"
            })
            .when("/ng/com_quiltmania_stats/distributeur/new/", {
                templateUrl: "/com_zeapps_crm_stats/distributeurs/config_form/",
                controller: "ComQuiltmaniaStatsDistributeurConfigFormCtrl"
            })
            .when("/ng/com_quiltmania_stats/distributeur/edit/:id", {
                templateUrl: "/com_zeapps_crm_stats/distributeurs/config_form/",
                controller: "ComQuiltmaniaStatsDistributeurConfigFormCtrl"
            })
            .when("/ng/com_quiltmania_stats/key_markets/config", {
                templateUrl: "/com_zeapps_crm_stats/key_market/config",
                controller: "ComQuiltmaniaStatsKeyMarketsConfigCtrl"
            })
            .when("/ng/com_quiltmania_stats/key_markets/new/", {
                templateUrl: "/com_zeapps_crm_stats/key_market/config_form",
                controller: "ComQuiltmaniaStatsKeyMarketsConfigFormCtrl"
            })
            .when("/ng/com_quiltmania_stats/key_markets/edit/:id", {
                templateUrl: "/com_zeapps_crm_stats/key_market/config_form",
                controller: "ComQuiltmaniaStatsKeyMarketsConfigFormCtrl"
            })
        ;
    }
]);