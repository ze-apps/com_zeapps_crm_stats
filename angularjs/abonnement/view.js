app.controller("ComQuiltmaniaStatsAbonnementCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
    function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_abonnement");

        $scope.filters = {
            main: [
                {
                    format: 'select',
                    field: 'id_publication',
                    type: 'text',
                    label: 'Publication',
                    options: []
                },
                {
                    format: 'input',
                    field: 'numero_debut',
                    type: 'number',
                    label: 'Numero >='
                },
                {
                    format: 'input',
                    field: 'numero_fin',
                    type: 'number',
                    label: 'Numero <='
                },
                {
                    format: 'select',
                    field: 'delivery_country_id IN',
                    type: 'text',
                    label: 'Marché clé',
                    options: []
                },
                {
                    format: 'select',
                    field: 'delivery_country_id',
                    type: 'text',
                    label: 'Pays',
                    options: []
                }
            ]
        };
        $scope.filter_model = {};
        $scope.navigationState = "chart";
        $scope.options = {
            legend: {display: true},
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };
        $scope.series = ["Nombre d'abonnés"];

        $scope.loadList = loadList;


        // Liste des publications
        $scope.publications = [];
        zhttp.quiltmania.publication.get_all().then(function (response) {
            if (response.data && response.data != "false") {
                $scope.publications = response.data;
                $scope.filters.main[0].options = response.data;

                // charge les données
                loadList(true);
            }
        });



        // marché clé
        $id_marche_cle = 3 ;
        $scope.filters.main[$id_marche_cle].options = [];
        $scope.filters.main[$id_marche_cle].options.push({id:8, label:"France"});
        $scope.filters.main[$id_marche_cle].options.push({id:13, label:"Pays-Bas"});
        $scope.filters.main[$id_marche_cle].options.push({id:17, label:"UK"});
        $scope.filters.main[$id_marche_cle].options.push({id:21, label:"USA"});
        $scope.filters.main[$id_marche_cle].options.push({id:'24, 27', label:"Australie / Nouvelle Zélande"});


        // pays
        $id_pays_filtre = 4 ;
        zhttp.contact.countries.all().then(function (response) {
            $scope.filters.main[$id_pays_filtre].options = [] ;
            if (response.data && response.data != "false") {
                var countries = response.data.countries ;
                angular.forEach(countries, function (value) {
                    $scope.filters.main[$id_pays_filtre].options.push({id:value["id"], label:value["name"]}) ;
                });
            }
        });





        function loadList(context) {
            context = context || "";

            var year = $scope.filter_model.year || parseInt(moment().format('YYYY'));

            var formatted_filters = angular.toJson($scope.filter_model);
            zhttp.quiltmania_stats.abonnement.get(year, context, formatted_filters).then(function (response) {
                if (response.data && response.data != "false") {
                    $scope.labels = [];
                    $scope.data = [];
                    angular.forEach($scope.publications, function (publication) {
                        if (response.data.totals[publication.id]) {
                            $scope.labels[publication.id] = [];
                            $scope.data[publication.id] = [[]];
                            angular.forEach(response.data.totals[publication.id], function (total, numero) {
                                $scope.labels[publication.id].push(numero);
                                $scope.data[publication.id][0].push(total);
                            });
                        }
                    });
                }
            });
        }


    }]);