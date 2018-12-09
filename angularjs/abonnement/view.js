app.controller("ComQuiltmaniaStatsAbonnementCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_abonnement");

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
                    format: 'input',
                    field: 'year',
                    type: 'number',
                    label: 'Année'
                },
                {
                    format: 'select',
                    field: 'id',
                    type: 'text',
                    label: 'Publication',
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
						beginAtZero:true
					}
				}]
			}
		};
		$scope.series = ["Nombre d'abonnés"];

		$scope.loadList = loadList;

		loadList(true);

		function loadList(context){
			context = context || "";

			/*var year = $scope.filter_model.year || parseInt(moment().format('YYYY'));

            var formatted_filters = angular.toJson($scope.filter_model);
			zhttp.quiltmania_stats.abonnement.get(year, context, formatted_filters).then(function(response){
				if(response.data && response.data != "false"){
				    if(context) {
                        $scope.filters.main[0].options = response.data.key_markets;
                        $scope.filters.main[2].options = response.data.publications;
                    }

                    $scope.publications = response.data.publications;

                    $scope.labels = [];
                    $scope.data = [];
					angular.forEach($scope.publications, function(publication){
                        $scope.labels[publication.id] = [];
                        $scope.data[publication.id] = [[]];
						angular.forEach(response.data.totals[publication.id], function(total, numero){
							$scope.labels[publication.id].push(numero);
							$scope.data[publication.id][0].push(total);
						});
					});
				}
			});*/




            // TODO : données de bouchage
            var data = {
                "totals": {
                    "1": {
                        "105": 0,
                        "106": 0,
                        "107": 0,
                        "108": 0,
                        "109": 0,
                        "110": 0,
                        "111": 0,
                        "112": 0,
                        "113": 0,
                        "114": 0,
                        "115": 0,
                        "116": 0,
                        "117": 0,
                        "118": 0,
                        "119": 0,
                        "120": 0,
                        "121": 0,
                        "122": 0,
                        "123": 0,
                        "124": 0,
                        "125": 0
                    },
                    "2": {
                        "30": 0,
                        "31": 0,
                        "32": 0,
                        "33": 0,
                        "34": 0,
                        "35": 0,
                        "36": 0,
                        "37": 0,
                        "38": 0,
                        "39": 0,
                        "40": 0,
                        "41": 0,
                        "42": 0,
                        "43": 0,
                        "44": 0,
                        "45": 0,
                        "46": 0,
                        "47": 0,
                        "48": 0,
                        "49": 0,
                        "50": 0
                    },
                    "3": {
                        "105": 0,
                        "106": 0,
                        "107": 0,
                        "108": 0,
                        "109": 0,
                        "110": 0,
                        "111": 0,
                        "112": 0,
                        "113": 0,
                        "114": 0,
                        "115": 0,
                        "116": 0,
                        "117": 0,
                        "118": 0,
                        "119": 0,
                        "120": 0,
                        "121": 0,
                        "122": 0,
                        "123": 0,
                        "124": 0,
                        "125": 0
                    },
                    "4": {
                        "30": 0,
                        "31": 0,
                        "32": 0,
                        "33": 0,
                        "34": 0,
                        "35": 0,
                        "36": 0,
                        "37": 0,
                        "38": 0,
                        "39": 0,
                        "40": 0,
                        "41": 0,
                        "42": 0,
                        "43": 0,
                        "44": 0,
                        "45": 0,
                        "46": 0,
                        "47": 0,
                        "48": 0,
                        "49": 0,
                        "50": 0
                    },
                    "5": {
                        "8": 0,
                        "9": 0,
                        "10": 0,
                        "11": 0,
                        "12": 0,
                        "13": 0,
                        "14": 0,
                        "15": 0,
                        "16": 0,
                        "17": 0,
                        "18": 0,
                        "19": 0,
                        "20": 0,
                        "21": 0,
                        "22": 0,
                        "23": 0,
                        "24": 0,
                        "25": 0,
                        "26": 0,
                        "27": 0,
                        "28": 0
                    },
                    "6": {
                        "14": 0,
                        "15": 0,
                        "16": 0,
                        "17": 0,
                        "18": 0,
                        "19": 0,
                        "20": 0,
                        "21": 0,
                        "22": 0,
                        "23": 0,
                        "24": 0,
                        "25": 0,
                        "26": 0,
                        "27": 0,
                        "28": 0,
                        "29": 0,
                        "30": 0,
                        "31": 0,
                        "32": 0,
                        "33": 0,
                        "34": 0
                    },
                    "7": {
                        "8": 0,
                        "9": 0,
                        "10": 0,
                        "11": 0,
                        "12": 0,
                        "13": 0,
                        "14": 0,
                        "15": 0,
                        "16": 0,
                        "17": 0,
                        "18": 0,
                        "19": 0,
                        "20": 0,
                        "21": 0,
                        "22": 0,
                        "23": 0,
                        "24": 0,
                        "25": 0,
                        "26": 0,
                        "27": 0,
                        "28": 0
                    },
                    "8": [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    "9": [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                "publications": [{
                    "id": "1",
                    "label": "Quiltmania FR",
                    "numero_en_cours": "121",
                    "numero_en_cours_compta": "120",
                    "hs": "0",
                    "created_at": "2017-09-22 15:17:33",
                    "updated_at": "2017-09-22 15:17:33",
                    "deleted_at": null
                }, {
                    "id": "2",
                    "label": "Hors-series Quiltmania FR",
                    "numero_en_cours": "46",
                    "numero_en_cours_compta": "45",
                    "hs": "1",
                    "created_at": "2017-09-22 15:17:33",
                    "updated_at": "2017-09-22 15:42:29",
                    "deleted_at": null
                }, {
                    "id": "3",
                    "label": "Quiltmania GB",
                    "numero_en_cours": "121",
                    "numero_en_cours_compta": "120",
                    "hs": "0",
                    "created_at": "2017-09-22 15:17:33",
                    "updated_at": "2017-09-22 15:17:33",
                    "deleted_at": null
                }, {
                    "id": "4",
                    "label": "Hors-series Quiltmania GB",
                    "numero_en_cours": "46",
                    "numero_en_cours_compta": "45",
                    "hs": "1",
                    "created_at": "2017-09-22 15:17:33",
                    "updated_at": "2017-09-22 15:42:35",
                    "deleted_at": null
                }, {
                    "id": "5",
                    "label": "Simply Vintage FR",
                    "numero_en_cours": "24",
                    "numero_en_cours_compta": "23",
                    "hs": "0",
                    "created_at": "2017-09-22 15:17:33",
                    "updated_at": "2017-09-22 15:17:33",
                    "deleted_at": null
                }, {
                    "id": "6",
                    "label": "Carnets de Scrap FR",
                    "numero_en_cours": "30",
                    "numero_en_cours_compta": "29",
                    "hs": "0",
                    "created_at": "2017-09-22 15:17:33",
                    "updated_at": "2017-09-22 15:17:33",
                    "deleted_at": null
                }, {
                    "id": "7",
                    "label": "Simply Vintage GB",
                    "numero_en_cours": "24",
                    "numero_en_cours_compta": "23",
                    "hs": "0",
                    "created_at": "2017-09-22 15:17:33",
                    "updated_at": "2017-09-22 15:17:33",
                    "deleted_at": null
                }, {
                    "id": "8",
                    "label": "Simply Moderne FR",
                    "numero_en_cours": "10",
                    "numero_en_cours_compta": "10",
                    "hs": "0",
                    "created_at": "2017-09-22 15:17:33",
                    "updated_at": "2017-09-22 15:17:33",
                    "deleted_at": null
                }, {
                    "id": "9",
                    "label": "Simply Moderne GB",
                    "numero_en_cours": "10",
                    "numero_en_cours_compta": "10",
                    "hs": "0",
                    "created_at": "2017-09-22 15:17:33",
                    "updated_at": "2017-09-22 15:17:33",
                    "deleted_at": null
                }],
                "key_markets": [{
                    "id": "1",
                    "label": "France",
                    "countries": "{\"8\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "2",
                    "label": "Pays-Bas",
                    "countries": "{\"13\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "3",
                    "label": "UK",
                    "countries": "{\"17\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "4",
                    "label": "US",
                    "countries": "{\"21\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "5",
                    "label": "Australie \/ Nouvelle Z\u00e9lande",
                    "countries": "{\"27\":true,\"24\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "6",
                    "label": "Reste de l'Europe",
                    "countries": "{\"13\":true,\"17\":true,\"21\":true,\"24\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "7",
                    "label": "Reste du monde",
                    "countries": "{\"13\":true,\"17\":true,\"21\":true,\"24\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }]
            };
            var year = 2017 ;
            if(context) {
                $scope.filters.main[0].options = data.key_markets;
                $scope.filters.main[2].options = data.publications;
            }

            $scope.publications = data.publications;

            $scope.labels = [];
            $scope.data = [];
            angular.forEach($scope.publications, function(publication){
                $scope.labels[publication.id] = [];
                $scope.data[publication.id] = [[]];
                angular.forEach(data.totals[publication.id], function(total, numero){
                    $scope.labels[publication.id].push(numero);
                    $scope.data[publication.id][0].push(total);
                });
            });
            // FIN TODO : données de bouchage
        }
    }]);