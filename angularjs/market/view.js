app.controller("ComZeappsStatsMarketCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_markets");

		$scope.navigationState = "chart";
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
                }
            ]
        };
        $scope.filter_model = {};
		$scope.options = {
			legend: {display: true},
			tooltips: {
				enabled: true,
				callbacks: {
					label: function(tooltipItem, data) {
						var datasetLabel = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
						var nStr = ""+datasetLabel;
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

		$scope.loadList = loadList;
		$scope.hasImproved = hasImproved;

        loadList(true);

		function loadList(context) {
            context = context || "";
            /*var year = $scope.filter_model.year || parseInt(moment().format('YYYY'));

            zhttp.quiltmania_stats.market.get(year, context, $scope.filter_model).then(function (response) {
                if (response.data && response.data != "false") {
                    if(context) {
                        $scope.filters.main[0].options = response.data.key_markets;
                    }

                    $scope.year = year;
                    $scope.series = [
                        "Chiffre d'affaires " + year,
                        "Chiffre d'affaires " + (year - 1)
                    ];
                    $scope.labels_total = response.data.labels;
                    $scope.total = response.data.total;

                    $scope.data_canaux = {
                        'en_cours' : [],
                        'old' : []
                    };
                    $scope.labels_canaux = [];
                    angular.forEach(response.data.canaux, function(ca, canal){
                        $scope.labels_canaux.push(canal);
                        $scope.data_canaux.en_cours.push(ca[0]);
                        $scope.data_canaux.old.push(ca[1]);
                    });
                }
            });*/




            // TODO : données de bouchage
            var data = {"total":[[0,87041.98,111640,169156.16,162190.89,164559.24,154517.89,84653.57,128667.38,81973.91,30958.83,12700],[0,175981.25,109939.82,157147.87,124360.65,116542.24,241440.98,138582.67,100654.81,117673.1,251867.27,84502.58,145915.89]],"canaux":{"Distributeurs":[3305,2598],"Vente par correspondance":[1051708.74,1542073.17],"Web":[133046.11,219937.96],"Salons":[0,0]},"labels":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],"key_markets":[{"id":"1","label":"France","countries":"{\"8\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"2","label":"Pays-Bas","countries":"{\"13\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"3","label":"UK","countries":"{\"17\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"4","label":"US","countries":"{\"21\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"5","label":"Australie \/ Nouvelle Z\u00e9lande","countries":"{\"27\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"6","label":"Reste de l'Europe","countries":"{\"13\":true,\"17\":true,\"21\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"7","label":"Reste du monde","countries":"{\"13\":true,\"17\":true,\"21\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null}]};
            var year = 2017 ;
            if(context) {
                $scope.filters.main[0].options = data.key_markets;
            }

            $scope.year = year;
            $scope.series = [
                "Chiffre d'affaires " + year,
                "Chiffre d'affaires " + (year - 1)
            ];
            $scope.labels_total = data.labels;
            $scope.total = data.total;

            $scope.data_canaux = {
                'en_cours' : [],
                'old' : []
            };
            $scope.labels_canaux = [];
            angular.forEach(data.canaux, function(ca, canal){
                $scope.labels_canaux.push(canal);
                $scope.data_canaux.en_cours.push(ca[0]);
                $scope.data_canaux.old.push(ca[1]);
            });
            // FIN TODO : données de bouchage
        }

        function hasImproved(a, b){
            return a > b ? 'fa-arrow-up text-success' : (a < b ? 'fa-arrow-down text-danger' : 'fa-minus text-info');
        }
	}]);