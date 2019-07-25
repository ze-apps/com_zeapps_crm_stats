app.controller("ComZeappsStatsDistributeurCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
    function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_distributeur");

        $scope.navigationState = "chart";
        $scope.options = {
            legend: {display: true}
        };
        $scope.data = [];
        $scope.labels = [
            [],
            [
                "Vendus",
                "Invendus"
            ]
        ];
        $scope.filters = {
            main: [
                {
                    format: 'select',
                    field: 'id_market',
                    type: 'text',
                    label: 'Marché clé',
                    options: []
                },
                {
                    format: 'select',
                    field: 'id_publication',
                    type: 'text',
                    label: 'Publication',
                    options: []
                },
                {
                    format: 'input',
                    field: 'num_publication',
                    type: 'number',
                    label: 'N° de publication'
                }
            ]
        };
        $scope.filter_model = {};

        $scope.loadList = loadList;

        loadList(true);

        function loadList(context) {
            context = context || "";

            /*var formatted_filters = angular.toJson($scope.filter_model);
            zhttp.quiltmania_stats.distributeur.get_stats(context, formatted_filters).then(function (response) {
                if (response.data && response.data != "false") {
                    if (context) {
                        $scope.filters.main[0].options = response.data.key_markets;
                        $scope.filters.main[1].options = response.data.publications;
                    }

                    $scope.ventes = response.data.ventes;
                    $scope.data = [
                        [],
                        [0, 0]
                    ];
                    $scope.labels[0] = [];
                    angular.forEach(response.data.ventes, function (vente) {
                        $scope.labels[0].push(vente.name_distributeur);
                        $scope.data[0].push(vente.ca);
                        $scope.data[1][0] += parseFloat(vente.sold);
                        $scope.data[1][1] += parseFloat(vente.leftover);
                    });
                }
            });*/

            // TODO : données de bouchage
            var data = {"ventes":{"1":{"name_distributeur":"Pineapple","ca":1000,"leftover":0,"sold":1000},"4":{"name_distributeur":"Presstalis","ca":4853,"leftover":34760,"sold":37978},"5":{"name_distributeur":"MLP","ca":50,"leftover":0,"sold":50}},"publications":[{"id":"1","label":"Quiltmania FR","numero_en_cours":"121","numero_en_cours_compta":"120","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"2","label":"Hors-series Quiltmania FR","numero_en_cours":"46","numero_en_cours_compta":"45","hs":"1","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:42:29","deleted_at":null},{"id":"3","label":"Quiltmania GB","numero_en_cours":"121","numero_en_cours_compta":"120","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"4","label":"Hors-series Quiltmania GB","numero_en_cours":"46","numero_en_cours_compta":"45","hs":"1","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:42:35","deleted_at":null},{"id":"5","label":"Simply Vintage FR","numero_en_cours":"24","numero_en_cours_compta":"23","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"6","label":"Carnets de Scrap FR","numero_en_cours":"30","numero_en_cours_compta":"29","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"7","label":"Simply Vintage GB","numero_en_cours":"24","numero_en_cours_compta":"23","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"8","label":"Simply Moderne FR","numero_en_cours":"10","numero_en_cours_compta":"10","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"9","label":"Simply Moderne GB","numero_en_cours":"10","numero_en_cours_compta":"10","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null}],"key_markets":[{"id":"1","label":"France","countries":"{\"8\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"2","label":"Pays-Bas","countries":"{\"13\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"3","label":"UK","countries":"{\"17\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"4","label":"US","countries":"{\"21\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"5","label":"Australie \/ Nouvelle Z\u00e9lande","countries":"{\"27\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"6","label":"Reste de l'Europe","countries":"{\"13\":true,\"17\":true,\"21\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"7","label":"Reste du monde","countries":"{\"13\":true,\"17\":true,\"21\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null}]} ;
            if (context) {
                $scope.filters.main[0].options = data.key_markets;
                $scope.filters.main[1].options = data.publications;
            }

            $scope.ventes = data.ventes;
            $scope.data = [
                [],
                [0, 0]
            ];
            $scope.labels[0] = [];
            angular.forEach(data.ventes, function (vente) {
                $scope.labels[0].push(vente.name_distributeur);
                $scope.data[0].push(vente.ca);
                $scope.data[1][0] += parseFloat(vente.sold);
                $scope.data[1][1] += parseFloat(vente.leftover);
            });
            // FIN TODO : données de bouchage
        }
    }]);