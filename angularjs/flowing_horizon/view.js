app.controller("ComZeappsStatsFlowingHorizonCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
    function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_flowing_horizon");

        $scope.navigationState = "chart";
        $scope.filters = {
            main: [
                {
                    format: 'select',
                    field: 'periodicity',
                    type: 'text',
                    label: 'Periodicité',
                    options: [
                        {id: 1, label: '1 mois'},
                        {id: 2, label: '2 mois'},
                        {id: 3, label: '3 mois'},
                        {id: 4, label: '4 mois'},
                        {id: 6, label: '6 mois'},
                        {id: 12, label: '12 mois'},
                    ]
                },
            ],
            secondaries: [
                {
                    format: 'select',
                    field: 'id_price_list',
                    type: 'text',
                    label: 'Grille de prix',
                    options: []
                },
                {
                    format: 'select',
                    field: 'id_origin',
                    type: 'text',
                    label: 'Canal de vente',
                    options: []
                },
                {
                    format: 'select',
                    field: 'billing_country_id IN',
                    type: 'text',
                    label: 'Marché clé',
                    options: []
                },
                {
                    format: 'select',
                    field: 'billing_country_id',
                    type: 'text',
                    label: 'Pays',
                    options: []
                }
            ]
        };
        $scope.filter_model = {};

        $scope.filter_model.periodicity = "1" ;


        $scope.options = {
            legend: {display: true},
            tooltips: {
                enabled: true,
                callbacks: {
                    label: function (tooltipItem, data) {
                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        var nStr = "" + datasetLabel;
                        var x = nStr.split(".");
                        var x1 = x[0];
                        var x2 = x.length > 1 ? "," + x[1] : "";
                        var rgx = /(\d+)(\d{3})/;
                        while (rgx.test(x1)) {
                            x1 = x1.replace(rgx, "$1" + " " + "$2");
                        }
                        return " " + x1 + x2 + " €";
                    }
                }
            }
        };


        // grille de prix
        zhttp.crm.price_list.get_all().then(function (response) {
            if (response.data && response.data != "false") {
                $scope.filters.secondaries[0].options = response.data;
            }
        });

        // Canal de vente
        zhttp.crm.crm_origin.get_all().then(function (response) {
            if (response.data && response.data != "false") {
                $scope.filters.secondaries[1].options = response.data;
            }
        });


        // marché clé
        $id_marche_cle = 2;
        $scope.filters.secondaries[$id_marche_cle].options = [];
        $scope.filters.secondaries[$id_marche_cle].options.push({id: 8, label: "France"});
        $scope.filters.secondaries[$id_marche_cle].options.push({id: 13, label: "Pays-Bas"});
        $scope.filters.secondaries[$id_marche_cle].options.push({id: 17, label: "UK"});
        $scope.filters.secondaries[$id_marche_cle].options.push({id: 21, label: "USA"});
        $scope.filters.secondaries[$id_marche_cle].options.push({id: '24, 27', label: "Australie / Nouvelle Zélande"});
        $scope.filters.secondaries[$id_marche_cle].options.push({id:'-8, -13, -17, -21, -24, -27', label:"Reste du monde"});


        // pays
        $id_pays_filtre = 3;
        zhttp.contact.countries.all().then(function (response) {
            $scope.filters.secondaries[$id_pays_filtre].options = [];
            if (response.data && response.data != "false") {
                var countries = response.data.countries;
                angular.forEach(countries, function (value) {
                    $scope.filters.secondaries[$id_pays_filtre].options.push({id: value["id"], label: value["name"]});
                });
            }
        });


        $scope.loadList = loadList;
        $scope.hasImproved = hasImproved;



        $scope.isLoaded = false ;
        function loadList() {
            $scope.isLoaded = true ;

            var filtre = {};
            angular.forEach($scope.filter_model, function (value, key) {
                filtre[key] = value;
            });

            zhttp.quiltmania_stats.flowing_horizon.get(filtre).then(function (response) {
                if (response.data && response.data != "false") {
                    $scope.series = [
                        __t("Horizon glissant")
                    ];
                    $scope.labels = response.data.labels;
                    $scope.data = response.data.total;
                }
            });
        }
        loadList();


        $scope.export_excel = function () {
            var filtre = {};
            angular.forEach($scope.filter_model, function (value, key) {
                filtre[key] = value;
            });



            zhttp.quiltmania_stats.flowing_horizon.export(filtre).then(function (response) {
                if (response.data && response.data != "false") {
                    window.document.location.href = '/download-storage/' + angular.fromJson(response.data);
                }
            });
        };

        function hasImproved(a, b) {
            return a > b ? 'fa-arrow-up text-success' : (a < b ? 'fa-arrow-down text-danger' : 'fa-minus text-info');
        }
    }]);